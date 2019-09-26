<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Limit;
use App\Saldo;
use Redirect,Response;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Controllers\LogController;

class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deltrans($id)
    {
        echo $id;
        $saldo = Saldo::find($id);
        $old = $saldo->nominal;
        $saldo->delete();
        LogController::storeLog("Pembatalan topup ".number_format($old*-1,0,",","."));
        Session::flash('sukses','Menyimpan data berhasil');
        return redirect()->route('limit.index')->with('success', 'Post tersimpan');

    }
    public function index()
    {
        $data = Limit::find(1);
        $kirim = array('limit' => $data->lim_nom, 'topup' => Saldo::where('label', 1)->orderBy('created_at', 'desc')->get());
        return view('main.limit')->with($kirim);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topup(Request $request)
    {
        $nominal = str_replace(' ','',str_replace('Rp','', $request->nominal));
        $jumlah = DB::select("select sum(`nominal`) as aggregate from `saldo`");
        $jumlah = array_map(function ($value) {
            return (array)$value;
        }, $jumlah);
        if ($nominal >= $jumlah[0]['aggregate'] || $nominal == 0) {
            $pesan = "Topup tidak boleh melebihi biaya anggaran";
            $kat = 'error';
        }
        else{
            $kat = 'sukses';
            $pesan = "Berhasil melakukan topup";
            Saldo::create(['nominal' => ($nominal*-1), 'label' => 1]);
        }

        Session::flash($kat,$pesan);
        LogController::storeLog("Melakukan topup sebesar ".number_format($nominal,0,",","."));
        return redirect()->route('limit.index')->with('success', 'Post tersimpan');
    }
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
        $old = Limit::find(1);
        $nom_lim = str_replace(' ','',str_replace('Rp','', $request->limit));
        Limit::updateOrCreate(['lim_id' => 1],
                    ['lim_nom' => $nom_lim]);
        Session::flash('sukses','Menyimpan data berhasil');
        LogController::storeLog("Perubahan anggaran biaya ".number_format($old->lim_nom,0,",",".")." menjadi : ".number_format($nom_lim,0,",","."));
        return redirect()->route('limit.index')->with('success', 'Post tersimpan');
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
        //
    }
}
