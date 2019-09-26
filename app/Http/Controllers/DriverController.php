<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\Perjalanan;
use Redirect,Response;
use Session;

use App\Biaya;
use App\Saku;
use App\TujuanPerjalanan;
use App\Http\Controllers\LogController;

use App\PerKota;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saku(Request $req)
    {
        $saku = str_replace(' ','',str_replace('Rp','', $req->saku));
        $awal = Saku::find(1)->saku;
        Saku::updateOrCreate(['id' => 1],
                    ['saku' => $saku]);
        LogController::storeLog('Perbarui data saku driver '.$awal.' -> '.$saku);
        Session::flash('sukses','Menyimpan data berhasil');
        return redirect()->route('driver.index')->with('success', 'Post tersimpan');
    }
    public function saku_json()
    {
        return Saku::find(1)->saku;
    }
    public function index()
    {
        $saku = Saku::find(1)->saku;
        $data = Driver::where('status', 1)->get();
        $kirim = array('data' => $data, 'saku' => $saku );
        return view('main.driver-list')->with($kirim);
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
        $drId = $request->dr_id;
        $awal = Driver::find($drId);
        Driver::updateOrCreate(['dr_id' => $drId],
                    ['dr_stock' => 1, 'dr_nama' => $request->dr_nama, 'dr_alamat' => $request->dr_alamat, 'dr_hp' => $request->dr_hp, 'status' => 1]);
        Session::flash('sukses','Menyimpan data berhasil');
        if ($drId!='') {
            $msg = "Update data driver Data : ".$awal;
        }
        else{
            $msg = "Tambah data driver ".$request->dr_nama;
        }
        LogController::storeLog($msg);
        return redirect()->route('driver.index')->with('success', 'Post tersimpan');
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
        $where = array('dr_id' => $id);
        $driver  = Driver::where($where)->first();
 
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
        /*$karper = Perjalanan::where('per_driver',$id)->get()->toArray();
        if (count($karper)) {            
            for ($i=0; $i < count($karper); $i++) { 
                Kendaraan::find($karper[$i]['per_mobil'])->update(['ken_stock' => 1]);  
                Perjalanan::find($karper[$i]['per_id'])->delete();
                TujuanPerjalanan::where('tp_per',$karper[$i]['per_id'])->delete();
                Biaya::where('b_tp',$karper[$i]['per_id'])->delete();
                PerKota::where('pk_per',$karper[$i]['per_id'])->delete();   
            }
        }*/
        $dr = Driver::find($id);
        $msg = "Hapus data driver ".$dr;
        $dr->status = 0;
        $dr->save();
        Session::flash('sukses','Data Terhapus');
        LogController::storeLog($msg);
        return redirect()->route('driver.index')->with('success', 'Post tersimpan');
    }
}
