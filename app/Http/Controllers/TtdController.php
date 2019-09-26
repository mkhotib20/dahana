<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotifEmail;
use App\Ttd;
use App\Karyawan;
use Redirect,Response;
use Session;
use App\Http\Controllers\LogController;
class TtdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ttd::all();
        $kar = Karyawan::all();
        $mk = NotifEmail::all();
        $kirim = array('data' => $data, 'kar' => $kar, 'email' => $mk);
        return view('main.ttd')->with($kirim);
    }
    public function saveEmail(Request $request)
    {
        $email = $request->email;
        $id = $request->iden;
        NotifEmail::updateOrCreate(['id' => $id], ['email' => $email]);
        echo $id;
        Session::flash('sukses','Menyimpan data berhasil');
        LogController::storeLog("Update email notifikasi ".$email);
        return redirect()->route('ttd.index')->with('success', 'Post tersimpan');
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
        $id = $_POST['id'];
        for ($i=0; $i < count($id); $i++) { 
            Ttd::updateOrCreate(['id' => $id[$i]], ['nama' => $_POST['nama'][$i], 'jabatan' => $_POST['jabatan'][$i]]);
        }
        Session::flash('sukses','Menyimpan data berhasil');
        $ada = implode(" - ", $_POST['nama']);
        LogController::storeLog("Penggantian Tanda tangan  menjadi ".$ada);
        return redirect()->route('ttd.index')->with('success', 'Post tersimpan');
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
        //
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
        NotifEmail::find($id)->delete();
        return redirect()->route('ttd.index')->with('success', 'Post tersimpan');

    }
}
