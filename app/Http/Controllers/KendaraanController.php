<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Kendaraan;
use App\Kategori;
use App\Bbm;
use App\Driver;
use App\Perjalanan;
use Redirect,Response;
use Session;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kendaraan = DB::table('kendaraan')
            ->join('kategori', 'kendaraan.ken_kat', '=', 'kategori.kat_id')
            ->join('bbm', 'kendaraan.ken_bbm', '=', 'bbm.bbm_id')
            ->select('kendaraan.*', 'kategori.*')
            ->get();
        $data['kend'] = $kendaraan;

        $data['kat'] = Kategori::all();
        $data['bbm'] = Bbm::all();
        return view('main.kendaraan')->with($data);
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
        $ken_id = $request->ken_id;
        Kendaraan::updateOrCreate(['ken_id' => $ken_id],
                    ['ken_stock' => 1,'ken_merk' => $request->ken_merk, 'ken_nopol' => $request->ken_nopol, 'ken_kat' => $request->ken_kat, 'ken_bbm' => $request->ken_bbm]);
        Session::flash('sukses','Menyimpan data berhasil');
        return redirect()->route('kendaraan.index')->with('success', 'Post tersimpan');
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
        $where = array('ken_id' => $id);
        $driver  = Kendaraan::where($where)->first();
 
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
        $karper = Perjalanan::where('per_mobil',$id)->get()->toArray();
        if (count($karper)) {            
            for ($i=0; $i < count($karper); $i++) { 
                Driver::find($karper[$i]['per_driver'])->update(['dr_stock' => 1]);  
                Perjalanan::find($karper[$i]['per_id'])->delete();
                TujuanPerjalanan::where('tp_per',$karper[$i]['per_id'])->delete();
                Biaya::where('b_tp',$karper[$i]['per_id'])->delete();
                PerKota::where('pk_per',$karper[$i]['per_id'])->delete(); 
            }
        }
        Kendaraan::find($id)->delete();
        Session::flash('sukses','Data Terhapus');
        return redirect()->route('kendaraan.index')->with('success', 'Post tersimpan');
    }
}
