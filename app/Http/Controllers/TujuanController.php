<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tujuan;
use App\Kota;
use App\TujuanPerjalanan;
use Redirect,Response;
use Session;
use App\Http\Controllers\LogController;
class TujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tujuan::where('tj_kota_1', 0)->orWhere('tj_kota_1', 2)->join('kota', 'tujuan.tj_kota_2', '=', 'kota.kt_id')->get();
        return view('main.tujuan', compact('data'));
    }
    public function getJarak($kota)
    {
        $jarak = 200;
        echo json_encode($jarak);
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
    public function getIdKota($nama)
    {
        $kota = Kota::where('kt_nama', ucfirst($nama));
        if ($kota->count()==0) {
            return Kota::max('kt_id')+1;
        }
        else{
            $koko =$kota->get()->toArray(); 
            return $koko[0]['kt_id'];
        }
    }
    public function getTjId($kt_1,$id)
    {
        $tj = Tujuan::where([
            ['tj_kota_1', '=', $kt_1],
            ['tj_kota_2', '=', $id],
        ]);
        if ($tj->count()==0) {
            return Tujuan::max('tj_id')+1;
        }
        else{
            $koko =$tj->get()->toArray(); 
            return $koko[0]['tj_id'];
        }
    }
    public function store(Request $request)
    {
        $tj_kota_1 = $request->tj_kota_1;
        $tj_kota_2_nama = ucfirst($request->tj_kota);
        $tj_kota_2 = $this->getIdKota($tj_kota_2_nama);
        echo $tj_id = $this->getTjId($tj_kota_1, $tj_kota_2);
        $tj_jarak = $request->tj_jarak;
        $tj_ex_tol = str_replace(' ','',str_replace('Rp','', $request->tj_ex_tol));
        $tj_tol = str_replace(' ','',str_replace('Rp','', $request->tj_tol));
        $tj_parkir = str_replace(' ','',str_replace('Rp','', $request->tj_parkir));

        Tujuan::updateOrCreate(['tj_id' => $tj_id],
                    ['tj_kota_1' => $tj_kota_1, 'tj_kota_2' => $tj_kota_2, 'tj_jarak' => $tj_jarak, 'tj_tol' => $tj_ex_tol]);
        Kota::updateOrCreate(['kt_id' => $tj_kota_2],
                    ['kt_nama' => $tj_kota_2_nama, 'kt_tol' => $tj_tol, 'kt_parkir' => $tj_parkir]);
        Session::flash('sukses','Menyimpan data berhasil');
        LogController::storeLog("Perubahan data kota tujuan ");
        return redirect()->route('tujuan.index')->with('success', 'Post tersimpan');
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
        $where = array('tj_id' => $id);
        $driver  = Tujuan::where($where)->join('kota', 'tujuan.tj_kota_2', '=', 'kota.kt_id')->first();
         
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
        // $karper = TujuanPerjalanan::where('tp_tj',$id)->get()->toArray();
        // if (count($karper)) {            
        //     for ($i=0; $i < count($karper); $i++) { 
        //         Driver::find($karper[$i]['per_driver'])->update(['dr_stock' => 1]);  
        //         Kendaraan::find($karper[$i]['per_mobil'])->update(['ken_stock' => 1]);  
        //         Perjalanan::find($karper[$i]['tp_per'])->delete();
        //         TujuanPerjalanan::find($karper[$i]['tp_id'])->delete();
        //     }
        // }
        // Tujuan::find($id)->delete();
        // Session::flash('sukses','Data Terhapus');
        // return redirect()->route('tujuan.index')->with('success', 'Post tersimpan');
    }
}
