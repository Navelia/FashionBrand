<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PointsHistory;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Variant;
use Illuminate\Http\Request;

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
        $transaction->staff_id = 2; //Auth Belum
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
}
