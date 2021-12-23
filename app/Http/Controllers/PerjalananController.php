<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Perjalanan;
use App\Kendaraan;
use App\Driver;
use App\Limit;
use App\Penyelarasan;
use App\UnitKerja;
use App\Tujuan;
use App\Kategori;
use App\Karyawan;
use App\Bbm;
use App\Saku;
use App\Saldo;
use App\Biaya;
use Auth;
use App\TujuanPerjalanan;
use App\Kota;
use App\Log;
use App\PerKota;
use App\Ttd;
use Redirect,Response;
use Session;
use App\Http\Controllers\LogController;
use App\NotifEmail;
use Illuminate\Support\Facades\Mail;

class PerjalananController extends Controller
{
    public $log;
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = new LogController();
        $inv = new InvoiceController();
        $kota = array();
        $page = request()->get("page");
        $queryperj = DB::table('perjalanan')
        ->join('kendaraan', 'perjalanan.per_mobil', '=', 'kendaraan.ken_id')
        ->join('karyawan', 'perjalanan.per_karyawan', '=', 'karyawan.kar_id')
        ->join('unit_kerja', 'karyawan.kar_uk', '=', 'unit_kerja.uk_id')
        ->join('drivers', 'perjalanan.per_driver', '=', 'drivers.dr_id')
        ->select('perjalanan.*','kendaraan.*', 'drivers.*', 'karyawan.*', 'unit_kerja.uk_nama')
        ->limit(10)
        ->orderBy('perjalanan.created_at','desc');
        if ($page) {
            $queryperj = $queryperj->offset(($page-1)*10);
        }
        if (request()->get("search")) {
            $queryperj = $queryperj
                    ->where("perjalanan.per_no",'like',"%".$_GET['search']."%")
                    ->orWhere('unit_kerja.uk_nama','like',"%".$_GET['search']."%")
                    ->orWhere('karyawan.kar_nama','like',"%".$_GET['search']."%");
        }
        $paginatedPerj = $queryperj->simplePaginate(10)->toArray();
        
        $perjalanan = $paginatedPerj['data'];
        $perjalanan = array_map(function ($value) {
            return (array)$value;
        }, $perjalanan);
        for ($i=0; $i < count($perjalanan); $i++) { 
            $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
            LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$perjalanan[$i]['per_no']);
            $query = array_map(function ($value) {
                return (array)$value;
            }, $query);
            
            for ($j=0; $j <count($query) ; $j++) { 
                $kota[$i][$j] = $inv->getKota($query[$j]['tj_kota_2']);    
            }
        }
        // dd($paginatedPerj);
        return view('main.perjalanan')->with([
            "uk"=>UnitKerja::all(),
            "perjalanan" => $perjalanan,
            'kota' => $kota,
            "search"=> request()->get("search"),
            "pagination" => $paginatedPerj
        ]);
    }
	
    public function getPerNo()
    {
        $old_no = Perjalanan::max('per_no');
        $max_year = substr($old_no, 0, 4);
        $year = date('Y');
        $no = substr($old_no, 4, 4)+1;
        if ($max_year!=$year) {
            $per_no = date('Y').'0000'.'1';
        }
        else{
            $per_no = date('Y').'0000'."$no";
        }
        return $per_no;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json_jarak()
    {
        $kota_1 = $_GET['kota_1'];
        $kota_2 = $_GET['kota_2'];
        $tj = Tujuan::where([
            ['tj_kota_1', '=', $kota_1],
            ['tj_kota_2', '=', $kota_2],
        ]);
        $idxH = $tj->count();
        if ($idxH==0) {
            $kota_1 = $_GET['kota_2'];
            $kota_2 = $_GET['kota_1'];
            $tj = Tujuan::where([
                ['tj_kota_1', '=', $kota_1],
                ['tj_kota_2', '=', $kota_2],
            ]);
        }
        echo json_encode($tj->get());
    }
    public function json()
    {
        //$nm = '%'.$_GET['term'].'%';
        $per = Kota::orderBy('kt_nama', 'ASC')->get();
        for ($i=0; $i < count($per) ; $i++) { 
            $arr[$i] = array(
                'value' => $per[$i]['kt_nama'],
                'kt_id' => $per[$i]['kt_id'],
                'kt_parkir' => $per[$i]['kt_parkir'],
                'kt_tol' => $per[$i]['kt_tol'],
            );
        }
        if (isset($arr)) {
            $arr = $arr;
        }
        else{
            $arr[0] = array(
                'value' => '',
                'data' => ''
            );
        }
        echo json_encode($arr);
    }
    public function tambah()
    {
        /*$max_no = Perjalanan::max('per_no');
        $no = substr($max_no, 4, 4)+1;
        $max_year = substr($max_no, 0, 4);
        $year = date('Y');
        if ($max_year!=$year) {
            $per_no = date('Y').'0000'+1;
        }
        else{
            $per_no = date('Y').'0000'+$no;
        }*/
		$per_no = $this->getPerNo();
        

        $data = array(
            'tj_kota_1' => '0',
            'per_id' => '',
            'per_no' => $per_no,
            'per_tarif' => '0',
        );
        $data['kendaraan'] = Kendaraan::where('ken_stock', '!=' , '0')->get();
        $data['driver'] = Driver::where([['dr_stock', '=' , '1'], ['status', '!=', 0]])->get();
        $data['karyawan'] = Karyawan::all();
        $data['kota'] = Kota::all();
        return view('main.add-per')->with($data);
    }
    public function json_bbm()
    {
        $mobil = $_GET['mobil'];
        $bbm_id = Kendaraan::find($mobil)->ken_bbm;
        $kat_id = Kendaraan::find($mobil)->ken_kat;
        $bbm = Bbm::find($bbm_id)->bbm_harga;
        $kons = Kategori::find($kat_id)->kat_kons;
        $arr = array('bbm' => $bbm, 'kons' =>$kons);
        echo json_encode($arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail($tj, $email, $mobil, $nama, $jam, $tgl, $driver, $kep, $nopol, $asal)
    {
        $to_name = $nama;
        $to_email = $email;
        $data = array('nama'=>$nama, "mobil" => $mobil, "driver" => $driver, "tgl" => $tgl, "jam" => $jam, "tj" =>$tj, 'kep' => $kep, 'asal' => $asal, 'nopol' => $nopol);
        $template= 'mail.tm'; // resources/views/mail/xyz.blade.php
        Mail::send($template, $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Detail Perjalanan Dinas');
            $message->from('pelayanankorporasi@dahana.id','Pelayanan Korporasi PT. Dahana');
        });
    }
    public function convDate($tgl)
	{
        
        $time = strtotime($tgl);
        $hari = date("D", $time);
 
		switch($hari){
			case 'Sun':
				$hari_ini = "Minggu";
			break;
	 
			case 'Mon':			
				$hari_ini = "Senin";
			break;
	 
			case 'Tue':
				$hari_ini = "Selasa";
			break;
	 
			case 'Wed':
				$hari_ini = "Rabu";
			break;
	 
			case 'Thu':
				$hari_ini = "Kamis";
			break;
	 
			case 'Fri':
				$hari_ini = "Jumat";
			break;
	 
			case 'Sat':
				$hari_ini = "Sabtu";
			break;
			
			default:
				$hari_ini = "Tidak di ketahui";		
			break;
		}

		$date = date('d-m-Y', $time);
		return $hari_ini.', '.$date;
    }
    public function storeKota($kt_nama, $kt_tol, $kt_parkir)
    {
        $kt_nama = ucfirst($kt_nama);
        if ($kt_parkir != 0 || $kt_tol != 0) {
            Kota::updateOrCreate(
                ['kt_nama' => $kt_nama],
                ['kt_parkir' => $kt_parkir, 'kt_tol' => $kt_tol, 'kt_nama' => $kt_nama]
            );
        }
        
    }
    public function storeTujuan($tj_kota_1, $tj_kota_2, $tj_jarak, $tj_tol)
    {
        if ($tj_tol != 0) {
            Tujuan::updateOrCreate(
                ['tj_kota_1' => $tj_kota_1, 'tj_kota_2' => $tj_kota_2],
                ['tj_jarak' => $tj_jarak,  'tj_kota_1' => $tj_kota_1, 'tj_kota_2' => $tj_kota_2, 'tj_tol' => $tj_tol]
            );
        }
        
    }
    public function storeBiayaUpd($b_nama, $b_tp, $b_nominal)
    {
        $b_nama = ucfirst($b_nama);
        // dd($b_nama);
        $by = Biaya::where([['b_tp', '=', $b_tp],['b_nama', '=',  $b_nama]]);
        if (count($by->get())>0) {
            $newSaku = $by->first();
            $newSaku->b_nominal += $b_nominal;
            $newSaku->save();
            // Biaya::updateOrCreate(
            //     ['b_tp' => $b_tp, 'b_nama' => $b_nama],
            //     ['b_tp' => $b_tp, 'b_nama' => $b_nama, 'b_nominal' => $newSaku]
            // );
        }
        else{
            Biaya::create(['b_tp' => $b_tp, 'b_nama' => $b_nama, 'b_nominal' => $b_nominal]);
        }
    }
    public function storeBiaya($b_nama, $b_tp, $b_nominal)
    {
        $b_nama = ucfirst($b_nama);
        Biaya::updateOrCreate(
            ['b_tp' => $b_tp, 'b_nama' => $b_nama],
            ['b_tp' => $b_tp, 'b_nama' => $b_nama, 'b_nominal' => $b_nominal]
        );
    }
    public function storeTP($tp_per, $tp_tj, $bbm, $cp, $tp_tol)
    {
        TujuanPerjalanan::create(
            ['tp_per'=>$tp_per, 'tp_tj'=>$tp_tj, 'tp_bbm' => $bbm, 'tp_cp' => $cp, 'tp_tol' => $tp_tol]
        );
    }
    public function storePK($pk_per, $pk_kt, $dur, $pk_pr, $pk_tol, $pk_bbm)
    {
        $saku = Saku::find(1)->saku;
        $saku = ($pk_kt!=0)?$dur*$saku:0;
        PerKota::create(
            ['pk_per'=>$pk_per, 'pk_kt'=>$pk_kt, 'pk_dur' => $dur, 'pk_saku' => $saku, 'pk_parkir' =>$pk_pr, 'pk_tol' => $pk_tol, 'pk_bbm' =>$pk_bbm]
        );
    }
    public function getKtId($kt_nama)
    {
        $kk = Kota::where('kt_nama', $kt_nama)->get()->toArray();
        return $kk[0]['kt_id'];
    }
    public function getTjId($tj_kota_1, $tj_kota_2)
    {
        $kk = Tujuan::where([
            ['tj_kota_1', '=', $tj_kota_1],
            ['tj_kota_2', '=', $tj_kota_2],
        ])->first();
        if (!$kk) {
            $kk = Tujuan::where([
                ['tj_kota_1', '=', $tj_kota_2],
                ['tj_kota_2', '=', $tj_kota_1],
            ])->first();
            return $kk->tj_id;
        }
        else{
            return $kk->tj_id;
        }
    }
    public function selesai(Request $request)
    {
       
        $nominal = $_POST['nominal'];
        $nama = $_POST['nama_biaya'];
        $pen_per = $_POST['pen_per'];
        $total_kembalian = 0 ;
        for ($i=0; $i < count($nominal); $i++) { 
            echo $nominal[$i];
            echo '<br>';
            Penyelarasan::create(['pen_per'=> $pen_per, 'nama_biaya' => $nama[$i], 'nominal' => str_replace(' ','',str_replace('Rp','', $nominal[$i]))]);
            $total_kembalian += str_replace(' ','',str_replace('Rp','', $nominal[$i]));
        }
        $per_biaya = Perjalanan::find($pen_per)->per_biaya;
        $kembalian = $per_biaya-$total_kembalian;
        
        if ($kembalian=='') {
            $kembalian = 0;
        }
        $per_id = $pen_per;
        $mobil = Perjalanan::find($per_id)->per_mobil;
        $driver = Perjalanan::find($per_id)->per_driver;
        DB::update("UPDATE perjalanan set per_pengembalian = ".$kembalian." WHERE per_id = ".$per_id);
        Driver::find($driver)->update(['dr_stock' => 1]);
        $kd = Kendaraan::find($mobil);
        if ($mobil!=5) {
            $kd->update(['ken_stock' => 1]);
        }
        $pr = Perjalanan::find($per_id);
        $nomorp = $pr->per_no;
        $pr->per_status = 1;
        $pr->per_km_end = $request->km_end;
        $pr->per_km_start = $request->km_start;
        $pr->save();
        Saldo::create(['nominal' => ($kembalian*-1)]);
        Session::flash('sukses','Perjalanan telah diselesaikan');
        LogController::storeLog("Penyelsaian  perjalanan no : ".$nomorp);
        return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');
    }
    public function remLastTP($per_id)
    {
        $lastTP = TujuanPerjalanan::where('tp_per', $per_id);
        $cp = $lastTP->max('tp_cp');
        $curTP = TujuanPerjalanan::where([['tp_per','=', $per_id], ['tp_cp','=', $cp]]);
        $lastTpCp = $curTP->first();
        $curPer = Perjalanan::find($per_id); 
        $bbm = $lastTpCp->tp_bbm;
        $extol = $lastTpCp->tp_tol;
        $biaya_baru = ($curPer->per_biaya)-$bbm-$extol;
        $curPer->per_biaya= $biaya_baru;
        // dd($biaya_baru, $curPer->per_biaya, $lastTpCp);

        Saldo::create(['nominal' => ($curPer->per_biaya*-1)]);        
        $curPer->save();
        $curTP->delete();
        // return $newBiaya = $biaya_baru;
    }
    public function saveBiaya($per_id, $b_nama, $b_nominal, $request)
    {
        $perj = Perjalanan::find($per_id);
        $per_no = $perj->per_no;
        for ($i=0; $i <count($b_nama) ; $i++) { 
            $b_uang = str_replace(' ','',str_replace('Rp','', $b_nominal[$i]));
            if ($b_uang!='' || $b_nama[$i] != '-') {
                $this->storeBiayaUpd($b_nama[$i], $per_id, $b_uang);
            }
        }
        $bAwal = $perj->per_biaya;
        $per_biaya = $bAwal+$request->per_biaya;
        $perj->per_biaya = $per_biaya;
        // dd($per_biaya, $request->per_biaya);
        if ($perj->save()) {
            Saldo::create(['nominal' => ($per_biaya)]);
            Session::flash('sukses','Menyimpan data berhasil');
            Session::flash('print',$per_no);
            $per_biaya = $request->per_biaya;
            $this->sendNotif($per_biaya);
             LogController::storeLog("Tambah biaya perjalanan no perjalanan : ".$per_no);
            return true; 
        }
        else{
            dd($per_biaya);
            return false;
        }
    }
    public function updateBiaya(Request $request)
    {
        $per_id = $request->per_id;
        // $perj = Perjalanan::find($per_id);
        // $per_no = $perj->per_no;
        // dd($per_id);
        $b_nama = $_POST['b_nama'];
        $b_nominal = $_POST['b_nominal'];
        if ($this->saveBiaya($per_id, $b_nama, $b_nominal, $request)) {
            return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');
        }
        else{
            Session::flash('error','Gagal menyimpan');
            return  redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');

        }
    }
    public function editBiaya($id)
    {
        $per_no = $id;
        $perj = Perjalanan::find($id);
        $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$perj->per_no);
        $query = array_map(function ($value) {
                    return (array)$value;
                }, $query);
        for ($i=0; $i <count($query) ; $i++) { 
            $kota[$i] = $this->getKota($query[$i]['tj_kota_2']);
            
        }
        $tj_kota_1 = $query[count($query)-2]['tj_kota_2'];
        $tj_kota_n = $query[0]['tj_kota_1'];
        
        $data = array(
            'per_id' => $perj->per_id,
            'tj_kota_1' => $tj_kota_1,
            'tj_kota_n' => $tj_kota_n,
            'per_no' => $perj->per_no,
            'per_kota_n' => $tj_kota_n,
            'per_mobil' => $perj->per_mobil,
            'per_tarif' => '0',
            'kendaraan' =>  Kendaraan::all(),
            'kota' =>  $kota,
            'kotawal' => Kota::find($tj_kota_n)->kt_nama,
        );
        return view('main.edit-biaya')->with($data);
        
        
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'tj_jarak' => 'required',
            'per_bbm' => 'required',
            'kt_parkir' => 'required',
            'tj_tol' => 'required',
            'kt_nama' => 'required',
            'kt_tol' => 'required',
        ]);
        $kt_nama = $_POST['kt_nama'];
        $kt_tol = $_POST['kt_tol'];
        $tj_tol = $_POST['tj_tol'];
        $kt_parkir = $_POST['kt_parkir'];
        $pk_bbm = $_POST['pk_bbm'];
        $per_bbm = $_POST['per_bbm'];
        $tj_jarak = $_POST['tj_jarak'];
        $dur = $_POST['pk_dur'];
        $per_biaya = 0;
        $tj_kota_1 = $request->tj_kota_1;
       if ($request->per_id!='') {
            $per_id = $request->per_id;
            $per_biaya = $request->per_biaya;
            // dd($per_no);
            $this->remLastTP($per_id, $per_biaya);

            $perj = Perjalanan::find($per_id);
            $per_no = $perj->per_no;
            for ($i=0; $i < count($kt_nama); $i++) { 
                if ($kt_nama[$i]!='' || $kt_nama[$i]!='0') {
                    $tol = $kt_tol[$i]/$dur[$i];
                    $parkir = $kt_parkir[$i]/$dur[$i];
                    $pkBbm = $pk_bbm[$i]/$dur[$i];
                    $this->storeKota($kt_nama[$i], $tol, $parkir);
                    $kt_id = $this->getKtId($kt_nama[$i]);
                    $this->storeTujuan($tj_kota_1, $kt_id, $tj_jarak[$i], $tj_tol[$i]);
                    if ($tj_kota_1 != $kt_id) {
                        $tj_id = $this->getTjId($tj_kota_1, $kt_id);
                        $cpF = TujuanPerjalanan::where('tp_per', $per_id)->max('tp_cp');
                        $cp = $i+1+$cpF;
                        $this->storeTP($per_id, $tj_id, $per_bbm[$i], $cp, $tj_tol[$i]);
                    }
                    $this->storePK($per_id, $kt_id, $dur[$i], $parkir, $tol, $pkBbm);
                    $tj_kota_1 = $kt_id;
                }
            }
            $b_nama = $_POST['b_nama'];
            $b_nominal = $_POST['b_nominal'];
            if (!$this->saveBiaya($per_id, $b_nama, $b_nominal, $request)) {
                Session::flash('error','Gagal menyimpan');
                return redirect()->back()->getTargetUrl();
            }

            LogController::storeLog("Edit perjalanan no perjalanan : ".$per_no);
            
        }
        else{
            $this->validate($request,[
                'per_pengaju' => 'required',
                'per_karyawan' => 'required',
                'per_kendaraan' => 'required',
                'per_tgl_start' => 'required',
                'per_driver' => 'required',
                'per_jam' => 'required',
            ]);
            $per_id = Perjalanan::max('per_id')+1;
                
            for ($i=0; $i < count($kt_nama); $i++) { 
                $tol = $kt_tol[$i]/$dur[$i];
                $parkir = $kt_parkir[$i]/$dur[$i];
                $pkBbm = $pk_bbm[$i]/$dur[$i];
                $this->storeKota($kt_nama[$i], $tol, $parkir);
                $kt_id = $this->getKtId($kt_nama[$i]);
                $this->storeTujuan($tj_kota_1, $kt_id, $tj_jarak[$i], $tj_tol[$i]);
                $tj_id = $this->getTjId($tj_kota_1, $kt_id);
                $cp = $i+1;
                $this->storeTP($per_id, $tj_id, $per_bbm[$i], $cp, $tj_tol[$i]);
                $lastDur = ($i==count($kt_nama)-1) ? 0 : $dur[$i] ;
                $this->storePK($per_id, $kt_id, $lastDur, $parkir, $tol, $pkBbm);
                if ($i != count($kt_nama)-1) {
                    $per_tujuan[$i] = $kt_nama[$i];
                }
                $tj_kota_1 = $kt_id;
            }

            $per_tujuan = implode(' - ', $per_tujuan);
            $b_nama = $_POST['b_nama'];
            $b_nominal = $_POST['b_nominal'];
            for ($i=0; $i <count($b_nama) ; $i++) { 
                $b_uang = str_replace(' ','',str_replace('Rp','', $b_nominal[$i]));
                if ($b_uang!='') {
                    $this->storeBiaya($b_nama[$i], $per_id, $b_uang);
                }
            }
            //$per_no = $request->per_no;
			$per_no = $this->getPerNo();
            $per_mobil = Kendaraan::find($request->per_kendaraan)->ken_merk;
            $ken_nopol = Kendaraan::find($request->per_kendaraan)->ken_nopol;
            $kar_id = Karyawan::find($request->per_karyawan);
            $kar_nama = $kar_id->kar_nama;
            $kar_email = $kar_id->kar_email;

            $per_jam = $request->per_jam;
            $per_tgl_start = $request->per_tgl_start;
            $per_karyawan = $request->per_karyawan;
            $per_pengaju = $request->per_pengaju;
            $per_biaya = $request->per_biaya;
            $per_kep = $request->per_kep;
            $drd = Driver::find($request->per_driver);
            $per_driver = $drd->dr_nama;
			if($drd->status != 2){
				$drd->update(['dr_stock' => 0]);
			}
            $kd = Kendaraan::find($request->per_kendaraan);
            if ($request->per_kendaraan!=5) {
                $kd->update(['ken_stock' => 0]);
            }
            $km_start = $request->km_start;
            $km_end = 0;
            Perjalanan::updateOrCreate(
                ['per_id' =>$per_id],
                [
                    'per_no' => $per_no, 
                    'per_id' => $per_id, 
                    'per_karyawan' => $per_karyawan, 
                    'per_pengaju' => $per_pengaju, 
                    'per_biaya' => $per_biaya, 
                    'per_tgl_start' => $per_tgl_start, 
                    'per_kep' => $per_kep, 
                    'per_jam' => $per_jam, 
                    'per_km_start' => $km_start,
                    'per_km_end' => $km_end,
                    'per_tgl_end' => $request->per_tgl_end, 
                    'per_mobil' => $request->per_kendaraan, 
                    'per_driver' => $request->per_driver, 
                ]);
                $asal = Kota::find($tj_kota_1)->kt_nama;
                try {
                    if ($kar_email!='') {
                        // $this->sendEmail($per_tujuan, $kar_email, $per_mobil, $kar_nama, $per_jam, $this->convDate($per_tgl_start), $per_driver, $per_kep, $ken_nopol, $asal);
                    }
                } catch (\Throwable $th) {
                    Session::flash('sukses','Menyimpan data berhasil');
                    return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');   
                }
                 LogController::storeLog("Tambah perjalanan no perjalanan : ".$per_no);
        }
        if (isset($per_biaya)) {
            Saldo::create(['nominal' => ($per_biaya)]);
        }
        Session::flash('sukses','Menyimpan data berhasil');
        Session::flash('print',$per_no);
        try {
            $this->sendNotif($per_biaya);
        } catch (\Throwable $th) {
            return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan'); 
        }
        return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');        
    }
    public function sendNotif($per_biaya)
    {
        $limit = Limit::find(1)->lim_nom;
        $jumlah = DB::select("select sum(`nominal`) as aggregate from `saldo`");
        $jumlah = array_map(function ($value) {
            return (array)$value;
        }, $jumlah);
        $saldo = $jumlah[0]['aggregate'];
        
        
        $percent0 = (($saldo-$per_biaya)/$limit)*100;
        $percent1 = (($saldo)/$limit)*100;
        if ($percent0<80) {
            if ($percent1>=80) {
                $email = NotifEmail::all();
                foreach ($email as $key => $value) {
                    $to_name = '';
                    $to_email = $value->email;
                    $data = array('limit'=>$limit, "biaya" => $saldo);
                    $template= 'mail.notif'; // resources/views/mail/xyz.blade.php
                    Mail::send($template, $data, function($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                                ->subject('Biaya perjalanan hampir mencapai batas anggaaran');
                        $message->from('pelayanankorporasi@dahana.id','Pelayanan Korporasi PT. Dahana');
                    });
                }
                
            }
        }
        //echo $percent0 = (($saldo-$per_biaya)/$limit)*100;
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

    public function editPerjalanan($no)
    {
        $tp = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$no);
        $tp = array_map(function ($value) {
                    return (array)$value;
                }, $tp);

        $perj = Perjalanan::where('per_no', $no)->firstOrFail();

        $max_no = Perjalanan::max('per_no');
        //$no = substr($max_no, 4, 4)+1;
        $max_year = substr($max_no, 0, 4);
        $year = date('Y');
        if ($max_year!=$year) {
            $per_no = date('Y').'0000'.'1';
        }
        else{
            $per_no = date('Y').'0000'."$no";
        }
        

        $data = array(
            'tj_kota_1' => '0',
            'per_id' => $perj->per_id,
            'per_no' => $per_no,
            'per_tarif' => '0',
            'perj' => $perj,
        );
        $data['kendaraan'] = Kendaraan::all();
        $data['driver'] = Driver::where('status', 1)->get();
        $data['karyawan'] = Karyawan::all();
        $data['kota'] = Kota::all();
        return view('main.ubah-data')->with($data);
    }
    
    public function getKota($kt_id)
    {
        return Kota::find($kt_id)->kt_nama;
    }
    public function edit($id)
    {
        $perj = Perjalanan::find($id);
        $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$perj->per_no);
        $query = array_map(function ($value) {
                    return (array)$value;
                }, $query);
        for ($i=0; $i <count($query) ; $i++) { 
            $kota[$i] = $this->getKota($query[$i]['tj_kota_2']);
            
        }
        $tj_kota_1 = $query[count($query)-2]['tj_kota_2'];
        $tj_kota_n = $query[0]['tj_kota_1'];
        
        $data = array(
            'per_id' => $perj->per_id,
            'tj_kota_1' => $tj_kota_1,
            'tj_kota_n' => $tj_kota_n,
            'per_no' => $perj->per_no,
            'per_kota_n' => $tj_kota_n,
            'per_mobil' => $perj->per_mobil,
            'per_tarif' => '0',
            'kendaraan' =>  Kendaraan::all(),
            'kota' =>  $kota,
            'kotawal' => Kota::find($tj_kota_n)->kt_nama,
        );
        return view('main.edit-per')->with($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perj = Perjalanan::find($id);
        $mobil = $perj->per_mobil;
        $driver = $perj->per_driver;
        Penyelarasan::where('pen_per', $id)->delete();
        
        LogController::storeLog("Hapus perjalanan. Data : ".$perj);
        $perj->delete();
        TujuanPerjalanan::where('tp_per',$id)->delete();
        Biaya::where('b_tp',$id)->delete();
        PerKota::where('pk_per',$id)->delete();
        Session::flash('sukses','Data Terhapus');
        Saldo::create(['nominal' => (($perj->per_biaya)-($perj->per_pengembalian))*-1]);
        
        Driver::find($driver)->update(['dr_stock' => 1]);
        $kd = Kendaraan::find($mobil);
        if ($mobil!=5) {
            $kd->update(['ken_stock' => 1]);
        }
        return redirect()->route('perjalanan.index')->with('success', 'Post tersimpan');
    }
}
