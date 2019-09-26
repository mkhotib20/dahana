<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Perjalanan;
use App\Kendaraan;
use App\Driver;
use App\UnitKerja;
use App\Tujuan;
use App\Kategori;
use App\Karyawan;
use App\Bbm;
use App\Limit;
use App\Biaya;
use App\TujuanPerjalanan;
use App\Kota;
use App\PerKota;
use App\Saldo;
use Redirect,Response;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        $data['jumlah_dr'] = Driver::where('dr_stock', 1)->count();
        $data['jumlah_ken'] = Kendaraan::where([['ken_stock', 1],['ken_id', '!=', '5']])->count();
        $data['driver'] = Driver::where('status', 1)->get();
        $data['mobil'] = Kendaraan::where('ken_id', '!=', '5')->get();
        $data['biaya_total'] = $this->getBiayaTotal();
        $data['limit'] = Limit::find(1)->lim_nom;
        return view('main.dashboard')->with($data);
    }
    public function getBiayaTotal()
    {
        $perjalanan = DB::select("select sum(`nominal`) as aggregate from `saldo`");
        $perjalanan = array_map(function ($value) {
            return (array)$value;
        }, $perjalanan);
        if ($perjalanan[0]['aggregate'] <0) {
            $perjalanan[0]['aggregate'] = 0;
        }
        return $perjalanan[0]['aggregate'];
    }
    public function json_saldo()
    {
        $limit = Limit::find(1)->lim_nom;
        $bt = $this->getBiayaTotal();
        $mat = $bt/$limit*100;
        if ($bt>=80) {
            $status = 'hampir';
        }
        elseif($bt>=$limit){
            $status = 'penuh';
        }
        else{
            $status = 'false';
        }
        $arr = array($limit, $bt, $status);
        echo json_encode($arr);
        
    }
}
