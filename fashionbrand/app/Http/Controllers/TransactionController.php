<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PointsHistory;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::all();
        return view('admin.transaction.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('owner');
        $customers = Customer::all();
        $products = Product::orderBy('name')->get();

        return view('admin.transaction.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('owner', $request);
        $pelanggan = $request->get('namePelanggan');
        $variants = $request->get('varianProduk');
        $jmlhs = $request->get('jmlhProduk');
        $prices = [];
        $grandtotal = 0;

        foreach ($variants as $key => $var) {
            $dataVarian = Variant::find($var);
            $prices[] = $dataVarian->product->price;
            $grandtotal += $dataVarian->product->price * $jmlhs[$key];
        }

        if ($request->get('poin')) {
            $poin = Customer::select('points')->where('id', $pelanggan)->get()[0]['points'];
            $grandtotal -= ($poin * 1000);
        }

        $tax = $grandtotal * 0.11;
        $total = $grandtotal + $tax * 1;

        $transaction = new Transaction();
        $transaction->grand_total = $grandtotal;
        $transaction->tax = $tax;
        $transaction->total = $total;
        $transaction->customer_id = $pelanggan;
        $transaction->staff_id = Auth::user()->id;
        $transaction->created_at = date('Y-m-d H:i:s');
        $transaction->save();

        foreach ($variants as $key => $var) {
            $quantity = $jmlhs[$key];
            $stock = Variant::select('stock')->where('id', $var)->get()[0]['stock'];
            if($quantity >= $stock){
                $quantity = $stock;
            }
            $subtotal = $prices[$key] * $quantity;
            $transaction->variants()->attach($var, ['price' => $prices[$key], 'quantity' => $quantity, 'sub_total' => $subtotal]);
        }

        if ($request->get('poin')) {
            $pointHis = new PointsHistory();
            $pointHis->date = date('Y-m-d H:i:s');
            $pointHis->type = 'out';
            $amount = Customer::select('points')->where('id', $pelanggan)->get()[0]['points'];
            $pointHis->amount = $amount;
            $pointHis->transaction_id = $transaction->id;
            $pointHis->save();

            $dataCust = Customer::find($pelanggan);
            $dataCust->points = $dataCust->points - $amount * 1;
            $dataCust->save();
        }

        if ($grandtotal > 100000) {
            $pointIn = floor($grandtotal / 100000);
            $pointHis = new PointsHistory();
            $pointHis->date = date('Y-m-d H:i:s');
            $pointHis->type = 'in';
            $pointHis->amount = $pointIn;
            $pointHis->transaction_id = $transaction->id;
            $pointHis->save();

            $dataCust = Customer::find($pelanggan);
            $dataCust->points = $dataCust->points + $pointIn * 1;
            $dataCust->save();
        }

        return redirect()->route('transaction.index')->with('status', 'Transaksi Berhasil dilakukan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $data = $transaction;
        return view('admin.transaction.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function reporting(){
        // 3 Varian yang paling laku dibeli
        $query = DB::select(DB::raw('select p.name, v.dimension, sum(tv.quantity) as \'total_quantity\' from transactions_variants tv inner join variants v on v.id=tv.variant_id inner join products p on p.id=v.product_id group by variant_id order by total_quantity desc limit 3;'));
        return view('admin.transaction.report', compact('query'));
    }

    public function addToCart(Request $request){
        $this->authorize('customer');
        $id = $request->get('variant');
        $var = Variant::find($id);

        $cart = session()->get('cart');
        if(!isset($cart[$id]))
        {
            $cart[$id] = [
                "name" => $var->product->name,
                "dimension" => $var->dimension,
                "price" => $var->product->price,
                "quantity" => 1,
            ];
        }
        else{
            $cart[$id]["quantity"]++;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with("status", "Hooray, Product telah ditambah");
    }

    public function cart(){
        return view('customer.cart');
    }

    public function checkout(Request $request){
        $grandtotal = 0;
        foreach(session('cart') as $key=>$details){
            $grandtotal += ($details['price'] * $details['quantity'])*1;
        }

        if ($request->get('tukar')=='ya' && $grandtotal>100000) {
            $poin = Customer::select('points')->where('id', Auth::user()->customer->id)->get()[0]['points'];
            $grandtotal -= ($poin * 1000);
        }

        $tax = $grandtotal*0.11;
        $total = $grandtotal + $tax;

        $transaction = new Transaction();
        $transaction->grand_total = $grandtotal;
        $transaction->tax = $tax;
        $transaction->total = $total;
        $transaction->customer_id = Auth::user()->customer->id;
        $transaction->created_at = date('Y-m-d H:i:s');
        $transaction->save();

        foreach (session('cart') as $key=>$details) {
            $stock = Variant::select('stock')->where('id', $key)->get()[0]['stock'];
            if($details['quantity'] >= $stock){
                $details['quantity'] = $stock;
            }
            $subtotal = $details['price'] * $details['quantity'];
            $transaction->variants()->attach($key, ['price' => $details['price'], 'quantity' => $details['quantity'], 'sub_total' => $subtotal]);
        }

        if ($request->get('tukar')=='ya' && $grandtotal>100000) {
            $pointHis = new PointsHistory();
            $pointHis->date = date('Y-m-d H:i:s');
            $pointHis->type = 'out';
            $amount = Customer::select('points')->where('id', Auth::user()->customer->id)->get()[0]['points'];
            $pointHis->amount = $amount;
            $pointHis->transaction_id = $transaction->id;
            $pointHis->save();

            $dataCust = Customer::find(Auth::user()->customer->id);
            $dataCust->points = $dataCust->points - $amount * 1;
            $dataCust->save();
        }

        if ($grandtotal > 100000) {
            $pointIn = floor($grandtotal / 100000);
            $pointHis = new PointsHistory();
            $pointHis->date = date('Y-m-d H:i:s');
            $pointHis->type = 'in';
            $pointHis->amount = $pointIn;
            $pointHis->transaction_id = $transaction->id;
            $pointHis->save();

            $dataCust = Customer::find(Auth::user()->customer->id);
            $dataCust->points = $dataCust->points + $pointIn * 1;
            $dataCust->save();
        }
        session()->forget('cart');
        return redirect()->route('customer.profile')->with("status", "Transaksi telah Berhasil");
    }
    public function custDetail(Transaction $transaction){
        return view('customer.detailtransaction', compact('transaction'));
    }
}
