<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return view('admin.product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        return view('admin.product.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nameproduct' => 'required',
                'brandproduct' => 'required',
                'priceproduct' => 'required|numeric',
                'urlproduct' => 'mimes:jpg,png|required|file'
            ],
            ['nameproduct.required' => 'Nama produk tidak boleh kosong.'],
            ['brandproduct.required' => 'Brand produk tidak boleh kosong.'],
            ['priceproduct.required' => 'Harga produk tidak boleh kosong.', 'priceproduct.numeric' => 'Harga produk harus ditulis nominalnya dalam angka.'],
            ['urlproduct.required' => 'Upload gambar produk.'],
            ['urlproduct.mimes:jpg,png' => 'Format gambar yang diterima hanya .jpg dan .png.'],
        );

        $file = $request->file('urlproduct');
        $imgFolder = 'products';
        $imgName = $request->get('nameproduct') . '.' . $file->getClientOriginalExtension();
        $file->move($imgFolder, $imgName);

        $data = new Product();
        $data->name = $request->get('nameproduct');
        $data->brand = $request->get('brandproduct');
        $data->price = $request->get('priceproduct');

        $data->image_url = 'products/' . $imgName;

        $data->type_id = $request->get('typesproduct');
        $data->save();
        $data->id;

        $prodDim = $request->get('dimensionproduct');
        foreach ($prodDim as $dim) {
            $variant = new Variant();
            $variant->product_id = $data->id;
            $variant->dimension = $dim;
            $variant->stock = 0;
            $variant->save();
        }

        $categoryArr = $request->get('categoryproduct');
        foreach ($categoryArr as $cat) {
            $data->categories()->attach($cat);
        }
        return redirect()->route('product.index')->with('status', 'Berhasil menambahkan data baru.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $types = Type::all();
        $proCat = [];
        $proDim = [];
        foreach ($product->categories as $cat) {
            $proCat[] = $cat->id;
        }

        foreach ($product->variants as $var) {
            $proDim[] = $var->dimension;
        }

        return view('admin.product.edit', compact('product', 'categories', 'types', 'proCat', 'proDim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(
            [
                'nameproduct' => 'required',
                'brandproduct' => 'required',
                'priceproduct' => 'required|numeric',
            ],
            ['nameproduct.required' => 'Nama produk tidak boleh kosong.'],
            ['brandproduct.required' => 'Brand produk tidak boleh kosong.'],
            ['priceproduct.required' => 'Harga produk tidak boleh kosong.', 'priceproduct.numeric' => 'Harga produk harus ditulis nominalnya dalam angka.'],
        );

        $product->categories()->detach();
        $product->name = $request->get('nameproduct');
        $product->brand = $request->get('brandproduct');
        $product->price = $request->get('priceproduct');

        $unitSize = "";

        $dimProduct = Variant::select('dimension')->where('product_id', $request->get('idProduct'))->get();
        $dimProductVars = $dimProduct;
        $arrDimPro = [];

        foreach ($dimProductVars as $dp) {
            $arrDimPro[] = $dp->dimension;
        }

        $prodDim = $request->get('dimensionproduct');
        if ($product->type->unit == 'pcs') {
            foreach ($arrDimPro as $dbdim) {
                if (in_array($dbdim, $prodDim) == false) {
                    $variant = Variant::where('product_id', $request->get('idProduct'))->where('dimension', $dbdim)->first();
                    $variant->delete();
                }
            }

            foreach ($prodDim as $dim) {
                if (in_array($dim, $arrDimPro) == false) {
                    $variant = new Variant();
                    $variant->product_id = $product->id;
                    $variant->dimension = $dim;
                    $variant->stock = 0;
                    $variant->save();
                }
            }
        }
        else{
            $variantNotPcs = Variant::where('product_id', $request->get('idProduct'))->first();
            $variantNotPcs->dimension = $prodDim[0];
            $variantNotPcs->save();
        }

        if ($request->file('urlproduct')) {
            $file = $request->file('urlproduct');
            $imgFolder = 'products';
            $imgName = $request->get('nameproduct') . '.' . $file->getClientOriginalExtension();
            $file->move($imgFolder, $imgName);

            $product->image_url = 'products/' . $imgName;
        }

        $product->save();

        $categoryArr = $request->get('categoryproduct');
        foreach ($categoryArr as $cat) {
            $product->categories()->attach($cat);
        }
        return redirect()->route('product.index')->with('status', 'Data produk berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('product.index')->with('status', 'Data berhasil dihapus.');
            // dd($objCategory);
        } catch (\PDOException $ex) {
            $msg = "Gagal untuk menghapus data, pastikan data yang dihapus tidak berelasi dengan data dari kolom lain.";
            return redirect()->route('product.index')->with('status', $msg);
        }
    }


    public function showAddStock(Product $product)
    {
        $variants = Variant::where('product_id', $product->id)->get();
        return view('admin.product.addstock', compact('variants', 'product'));
    }

    public function addStock(Request $request, Variant $variant)
    {
        $varId = $request->get('variantssproduct');
        $variant = Variant::find($varId);

        $stockBaru = $variant->stock + $request->get('stockproduct');
        $variant->stock =  $stockBaru;
        $variant->save();
        
        return redirect()->route('product.index')->with('status', 'Berhasil tambah stok untuk '.$variant->product->name.'.');
    }

    public function getUnit(Request $request)
    {
        $typeUnit = Type::select('unit')->where('id', $request->get('idType'))->get();
        return response()->json(array(
            'msg' => $typeUnit[0]['unit']
        ));
    }

    public function getDimension(Request $request)
    {
        $idProduct = $request->get('idProduct');
        $productDimension = Variant::where('product_id', $idProduct)->get();
        $dimensions = $productDimension;

        return response()->json(array('status' => 'ok', 'msg' => view('admin.product.dimensionoptions', compact('dimensions'))->render()));
    }    

    public function displayCatalog()
    {
        $data = Product::all();
        return view('customer.catalog', compact('data'));
    }
}
