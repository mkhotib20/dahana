<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bbm;
use Redirect,Response;
use Session;
use App\Http\Controllers\LogController;
class BbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Bbm::all();
        return view('main.bbm-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bbm_id = $request->bbm_id;
        $datum = Bbm::find($bbm_id);
        Bbm::updateOrCreate(['bbm_id' => $bbm_id],
                    ['bbm_nama' => $request->bbm_nama, 'bbm_harga' => str_replace(' ','',str_replace('Rp','', $request->bbm_harga))]);
        Session::flash('sukses','Menyimpan data berhasil');
        if ($bbm_id!='') {
            $msg = "Perbarui Data BBM ".$datum;
        }
        else{
            $msg = "Tambah Data BBM ".$request->bbm_nama;
        }
        LogController::storeLog($msg);
        return redirect()->route('bbm.index')->with('success', 'Post tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('bbm_id' => $id);
        $driver  = Bbm::where($where)->first();
 
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
        $bbm = Bbm::find($id);
        $msg = "Hapus data BBM ".$bbm;
        $bbm->delete();
        Session::flash('sukses','Data Terhapus');
        LogController::storeLog($msg);
        return redirect()->route('bbm.index')->with('success', 'Post tersimpan');
    }
}
