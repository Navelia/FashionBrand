<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Type::all();
        return view('admin.type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $request->validate(['name'=>'required','description'=>'required','unit'=>'required'],['name.required'=>'Nama tipe tidak boleh kosong','description.required'=>'Deskripsi tipe tidak boleh kosong.', 'unit.required'=>'Unit tidak boleh kosong.']);
        $data = new Type();
        $data->name = $request->get('name');
        $data->description = $request->get('description');
        $data->unit = $request->get('unit');
        $data->save();

        return redirect()->route('type.index')->with('status', 'Berhasil menambahkan data baru.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        $data = $type;
        return view('admin.type.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $request->validate(['description'=>'required','unit'=>'required'],['description.required'=>'Deskripsi tipe tidak boleh kosong.', 'unit.required'=>'Unit tidak boleh kosong.']);
        $type->description = $request->get('description');
        $type->unit = $request->get('unit');
        $type->save();

        return redirect()->route('type.index')->with('status', 'Tipe produk berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        try {
            $type->delete();
            return redirect()->route('type.index')->with('status', 'Data berhasil dihapus.');
        } catch (\PDOException $ex) {
            $msg = "Gagal untuk menghapus data, pastikan data yang dihapus tidak berelasi dengan data dari kolom lain.";
            return redirect()->route('type.index')->with('status', $msg);
        }
    }
}
