<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Redirect,Response;
use Session;
class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kategori::all();
        return view('main.kat-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kat_id = $request->kat_id;
        Kategori::updateOrCreate(['kat_id' => $kat_id],
                    ['kat_nama' => $request->kat_nama, 'kat_cc' => $request->kat_cc, 'kat_kons' => $request->kat_kons]);
        Session::flash('sukses','Menyimpan data berhasil');
        return redirect()->route('kategori.index')->with('success', 'Post tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('kat_id' => $id);
        $driver  = Kategori::where($where)->first();
 
        return Response::json($driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kategori::find($id)->delete();
        Session::flash('sukses','Data Terhapus');
        return redirect()->route('kategori.index')->with('success', 'Post tersimpan');
    }
}
