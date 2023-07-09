<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
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
        $data->stock = 0;
        $data->price = $request->get('priceproduct');

        $unitSize = "";

        $typeUnit = Type::select('unit')->where('id', $request->get('typesproduct'))->get();

        if ($typeUnit[0]['unit'] == 'pcs') {
            $arrSize = $request->get('dimensionproduct');
            foreach ($arrSize as $size) {
                $unitSize .= $size . ",";
            }
            $unitSize = rtrim($unitSize, ',');
        } else {
            $unitSize = $request->get('dimensionproduct');
        }

        $data->dimension = $unitSize;
        $data->image_url = 'products/' . $imgName;

        $data->type_id = $request->get('typesproduct');
        $data->save();

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
        return view('admin.product.edit', compact('product', 'categories', 'types'));
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
                'urlproduct' => 'mimes:jpg,png|required|file'
            ],
            ['nameproduct.required' => 'Nama produk tidak boleh kosong.'],
            ['brandproduct.required' => 'Brand produk tidak boleh kosong.'],
            ['priceproduct.required' => 'Harga produk tidak boleh kosong.', 'priceproduct.numeric' => 'Harga produk harus ditulis nominalnya dalam angka.'],
            ['urlproduct.required' => 'Upload gambar produk.'],
            ['urlproduct.mimes:jpg,png' => 'Format gambar yang diterima hanya .jpg dan .png.'],
        );

        $product = new Product();
        $product->categories()->detach();
        $product->name = $request->get('nameproduct');
        $product->brand = $request->get('brandproduct');
        $product->price = $request->get('priceproduct');

        $unitSize = "";

        $typeUnit = Type::select('unit')->where('id', $request->get('typesproduct'))->get();
        if ($typeUnit[0]['unit'] == 'pcs') {
            $arrSize = $request->get('dimensionproduct');
            foreach ($arrSize as $size) {
                $unitSize .= $size . ",";
            }
            $unitSize = rtrim($unitSize, ',');
        } else {
            $unitSize = $request->get('dimensionproduct');
        }

        $product->dimension = $unitSize;

        $file = $request->file('urlproduct');
        $imgFolder = 'products';
        $imgName = $request->get('nameproduct') . '.' . $file->getClientOriginalExtension();
        $file->move($imgFolder, $imgName);

        $product->image_url = 'products/' . $imgName;

        $product->type_id = $request->get('typesproduct');
        $product->save();

        $categoryArr = $request->get('categoryproduct');
        foreach ($categoryArr as $cat) {
            $product->categories()->attach($cat);
        }
        return redirect()->route('products.index')->with('status', 'Data produk berhasil diubah.');
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

    public function updateStock(Product $product)
    {
    }

    public function getUnit(Request $request)
    {
        $typeUnit = Type::select('unit')->where('id', $request->get('idType'))->get();
        return response()->json(array(
            'msg' => $typeUnit[0]['unit']
        ));
    }

    public function getDimension(Request $request){
        $idProduct = $request->get('idProduct');
        $product = Product::find($idProduct);
        $dimensions = $product->variants;

        return response()->json(array('status'=>'ok','msg'=>view('admin.product.dimensionoptions', compact('dimensions'))->render()));
    }
}
