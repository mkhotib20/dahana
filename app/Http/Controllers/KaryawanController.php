<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use App\UnitKerja;
use Redirect,Response;
use Session;
use App\Biaya;
use App\TujuanPerjalanan;
use App\Perjalanan;

use App\PerKota;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogController;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = DB::table('karyawan')
        ->join('unit_kerja', 'karyawan.kar_uk', '=', 'unit_kerja.uk_id')
        ->select('karyawan.*', 'unit_kerja.uk_nama')
        ->get();
        $data['uk'] = UnitKerja::all();
        return view('main.karyawan')->with($data);
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
        $kar_id = $request->kar_id;
        $old = Karyawan::find($kar_id);
        Karyawan::updateOrCreate(['kar_id' => $kar_id],
                    ['kar_nama' => $request->kar_nama, 'kar_email' => $request->kar_email, 'kar_uk' => $request->kar_uk]);
        Session::flash('sukses','Menyimpan data berhasil');
        if ($kar_id!='') {
            $msg = "Update data karyawan Data :".$old;
        }
        else{
            $msg = "Tambah data karyawan ".$request->kar_nama;
        }
        LogController::storeLog($msg);
        return redirect()->route('karyawan.index')->with('success', 'Post tersimpan');
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
        $where = array('kar_id' => $id);
        $driver  = Karyawan::where($where)->first();
 
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
        // $karper = Perjalanan::where('per_karyawan',$id)->get()->toArray();
        // if (count($karper)) {            
        //     for ($i=0; $i < count($karper); $i++) { 
        //         Perjalanan::find($karper[$i]['per_id'])->delete();
        //         TujuanPerjalanan::where('tp_per',$karper[$i]['per_id'])->delete();
        //         Biaya::where('b_tp',$karper[$i]['per_id'])->delete();
        //         PerKota::where('pk_per',$karper[$i]['per_id'])->delete();    
        //     }
        // }
        // Karyawan::find($id)->delete();
        // Session::flash('sukses','Data Terhapus');
        // LogController::storeLog($msg);
        // return redirect()->route('karyawan.index')->with('success', 'Post tersimpan');
    }
}
