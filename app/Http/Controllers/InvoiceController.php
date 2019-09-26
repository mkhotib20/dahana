<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Perjalanan;
use App\Kendaraan;
use App\Penyelarasan;
use App\Driver;
use App\UnitKerja;
use App\Tujuan;
use App\Kategori;
use App\Karyawan;
use App\Ttd;
use App\Bbm;
use App\Biaya;
use App\TujuanPerjalanan;
use App\Kota;
use App\PerKota;
use Redirect,Response;
use Session;

class InvoiceController extends Controller
{
    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
    }
    public function genExtol($kt1, $kt2)
    {
        $kota_1 = $kt1;
        $kota_2 = $kt2;
        $tj = Tujuan::where([
            ['tj_kota_1', '=', $kota_1],
            ['tj_kota_2', '=', $kota_2],
        ]);
        $idxH = $tj->count();
        if ($idxH==0) {
            $kota_1 = $kt2;
            $kota_2 = $kt1;
            $tj = Tujuan::where([
                ['tj_kota_1', '=', $kota_1],
                ['tj_kota_2', '=', $kota_2],
            ]);
        }
        $ada = $tj->get();
        return $ada[0]['tj_tol'];
    }
    public function selesai($id)
    {
        $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$id);
        $per_id = Perjalanan::where('per_no', $id)->first();
        $idPerjalanan = $per_id->per_id;
        $per_kota = PerKota::where('pk_per', $idPerjalanan)->get();
        $perjalanan = Perjalanan::find($idPerjalanan);
        $driver = $perjalanan->per_driver;
        $karyawan = $perjalanan->per_karyawan;
        $karq = Karyawan::find($karyawan);
        $kar_uk = $karq->kar_uk;
        
        $biayaPerjalanan = Biaya::where('b_tp', $idPerjalanan)->get()->toArray();
        $query = array_map(function ($value) {
            return (array)$value;
        }, $query);
        
        for ($i=0; $i <count($per_kota) ; $i++) {
            $tol[$i] = $per_kota[$i]['pk_tol'];//$this->getTol( $idPerjalanan, $query[$i]['tj_kota_2']);
            $parkir[$i] = $per_kota[$i]['pk_parkir'];
        }

        for ($i=0; $i <count($query) ; $i++) { 
            $extol[$i] = $query[$i]['tp_tol'];
            $bbm[$i] = $query[$i]['tp_bbm'];
            $kota[$i] = $this->getKota($query[$i]['tj_kota_2']);            
        }
        $dari = $this->getKota($query[0]['tj_kota_1']);
        
        $biaya_tol = array_sum($tol);
        $biaya_extol = array_sum($extol);
        $biaya_bbm = array_sum($bbm);
        $biaya_parkir = array_sum($parkir);
        $biaya = array(
            array('nama' => 'Biaya BBM', 'nominal' => $biaya_bbm),
            array('nama' => 'Biaya Tol dalam kota', 'nominal' => $biaya_tol),
            array('nama' => 'Biaya Tol Antar Kota', 'nominal' => $biaya_extol),
            array('nama' => 'Biaya Parkir', 'nominal' => $biaya_parkir),
        );
        $biayaTambahan = array();
        for ($i=0; $i < count($biayaPerjalanan); $i++) { 
            $biayaTambahan[$i] = array('nama' => $biayaPerjalanan[$i]['b_nama'], 'nominal' => $biayaPerjalanan[$i]['b_nominal']);
        }
        $query[0]['per_biaya'] = $query[0]['per_biaya']-$query[0]['per_pengembalian'];
        $terbilang = $this->terbilang($query[0]['per_biaya']);
        $data = array('query' => $query, 'biaya'=> $biaya, 'biayaTambahan' => $biayaTambahan , 'kota' => $kota, 'no_inv' => $id, 'terbilang' => $terbilang);
        $data['dr_nama'] = Driver::find($driver)->dr_nama;
        $data['kar_nama'] = $karq->kar_nama;
        $data['uk_nama'] = UnitKerja::find($kar_uk)->uk_nama;
        $data['kep'] = $perjalanan->per_kep;
        $mobil = $perjalanan->per_mobil;
        $data['mobil'] = Kendaraan::find($mobil)->ken_merk;
        $mob_kat = Kendaraan::find($mobil)->ken_kat;
        $bbm_pakai = Kendaraan::find($mobil)->ken_bbm;
        $data['bbm_hrg'] = Bbm::find($bbm_pakai)->bbm_harga;
        $data['kons'] = Kategori::find($mob_kat)->kat_kons;
        $data['mob_kat'] = Kategori::find($mob_kat)->kat_nama;
        $data['tgl_start'] = $this->convMonth($perjalanan->per_tgl_start);
        $data['tgl_kembali'] = $this->convMonth($this->getTglKemb($idPerjalanan, $perjalanan->per_tgl_start));
        $data['dari'] = $dari;
        $data['per_id'] = $idPerjalanan;
        $data['ttd'] = Ttd::find(1);
        $data['per_km_start'] = $perjalanan->per_km_start;
        $data['per_km_end'] = $perjalanan->per_km_end;
         
        return view('main.selesai')->with($data);
    }
    public function adjusment($id)
    {
        $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$id);
         $per_id = Perjalanan::where('per_no', $id)->first();
        $idPerjalanan = $per_id->per_id;
        $per_kota = PerKota::where('pk_per', $idPerjalanan)->get();
        $perjalanan = Perjalanan::find($idPerjalanan);
        $driver = $perjalanan->per_driver;
        $karyawan = $perjalanan->per_karyawan;
        $karq = Karyawan::find($karyawan);
        $kar_uk = $karq->kar_uk;
        
        $biayaPerjalanan = Biaya::where('b_tp', $idPerjalanan)->get()->toArray();
        $query = array_map(function ($value) {
            return (array)$value;
        }, $query);
        
        for ($i=0; $i <count($per_kota) ; $i++) {
            $tol[$i] = $per_kota[$i]['pk_tol'];//$this->getTol( $idPerjalanan, $query[$i]['tj_kota_2']);
            $parkir[$i] = $per_kota[$i]['pk_parkir'];
        }

        for ($i=0; $i <count($query) ; $i++) { 
            $extol[$i] = $query[$i]['tp_tol'];
            $bbm[$i] = $query[$i]['tp_bbm'];
            $kota[$i] = $this->getKota($query[$i]['tj_kota_2']);            
        }
        $dari = $this->getKota($query[0]['tj_kota_1']);
        
        $biaya_tol = array_sum($tol);
        $biaya_extol = array_sum($extol);
        $biaya_bbm = array_sum($bbm);
        $biaya_parkir = array_sum($parkir);
        $biaya = array(
            array('nama' => 'Biaya BBM', 'nominal' => $biaya_bbm, 
            'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=', 'Biaya BBM']])->get()[0]['nominal']),
            array('nama' => 'Biaya Tol dalam kota', 'nominal' => $biaya_tol, 
            'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=', 'Biaya Tol dalam kota']])->get()[0]['nominal']),
            array('nama' => 'Biaya Tol Antar Kota', 'nominal' => $biaya_extol, 
            'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=', 'Biaya Tol Antar Kota']])->get()[0]['nominal']),
            array('nama' => 'Biaya Parkir', 'nominal' => $biaya_parkir, 
            'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=', 'Biaya Parkir']])->get()[0]['nominal']),
        );
        $biayaTambahan = array();
        for ($i=0; $i < count($biayaPerjalanan); $i++) { 
            $biayaTambahan[$i] = array('nama' => $biayaPerjalanan[$i]['b_nama'], 'nominal' => $biayaPerjalanan[$i]['b_nominal'],
            'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=', $biayaPerjalanan[$i]['b_nama']]])->get()[0]['nominal']);
        }
        $pembulatan = ceil($query[0]['per_biaya']/50000)*50000;
        $selisihPem = $pembulatan - $query[0]['per_biaya'];
        $terbilang = $this->terbilang($query[0]['per_biaya']);
        $data = array('query' => $query, 'biaya'=> $biaya, 'biayaTambahan' => $biayaTambahan , 'kota' => $kota, 'no_inv' => $id);
        $data['dr_nama'] = Driver::find($driver)->dr_nama;
        $data['kar_nama'] = $karq->kar_nama;
        $data['uk_nama'] = UnitKerja::find($kar_uk)->uk_nama;
        $data['kep'] = $perjalanan->per_kep;
        $mobil = $perjalanan->per_mobil;
        $data['mobil'] = Kendaraan::find($mobil)->ken_merk;
        $mob_kat = Kendaraan::find($mobil)->ken_kat;
        $data['mob_kat'] = Kategori::find($mob_kat)->kat_nama;
        $data['tgl_start'] = $this->convMonth($perjalanan->per_tgl_start);
        $data['tgl_kembali'] = $this->convMonth($this->getTglKemb($idPerjalanan, $perjalanan->per_tgl_start));
        $data['dari'] = $dari;
        $data['ttd'] = Ttd::find(1);
        $data['pembulatan'] = $pembulatan;
        $data['selisihPem'] = $selisihPem;
        $selisihKembali = $query[0]['per_biaya'] - $query[0]['per_pengembalian'];
        $data['selisihKembali'] = $selisihKembali;
        $terbilang = $this->terbilang($selisihKembali);
        $data['terbilang'] = $terbilang;
        $data['km_s'] = $query[0]['per_km_start'];
        $data['km_e'] = $query[0]['per_km_end'];
        return view('main.adj')->with($data);
    }
    public function index($id)
    {
        $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
        LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$id);
        $per_id = Perjalanan::where('per_no', $id)->first();
        $idPerjalanan = $per_id->per_id;
        $per_kota = PerKota::where('pk_per', $idPerjalanan)->get();
        $perjalanan = Perjalanan::find($idPerjalanan);
        $driver = $perjalanan->per_driver;
        $karyawan = $perjalanan->per_karyawan;
        $karq = Karyawan::find($karyawan);
        $kar_uk = $karq->kar_uk;
        
        $biayaPerjalanan = Biaya::where('b_tp', $idPerjalanan)->get()->toArray();
        $query = array_map(function ($value) {
            return (array)$value;
        }, $query);
        
        for ($i=0; $i <count($per_kota) ; $i++) {
            $tol[$i] = $per_kota[$i]['pk_tol'];//$this->getTol( $idPerjalanan, $query[$i]['tj_kota_2']);
            $parkir[$i] = $per_kota[$i]['pk_parkir'];
        }

        for ($i=0; $i <count($query) ; $i++) { 
            $extol[$i] = $query[$i]['tp_tol'];
            $bbm[$i] = $query[$i]['tp_bbm'];
            $kota[$i] = $this->getKota($query[$i]['tj_kota_2']);            
        }
        $dari = $this->getKota($query[0]['tj_kota_1']);
        
        $biaya_tol = array_sum($tol);
        $biaya_extol = array_sum($extol);
        $biaya_bbm = array_sum($bbm);
        $biaya_parkir = array_sum($parkir);
        $biaya = array(
            array('nama' => 'Biaya BBM', 'nominal' => $biaya_bbm),
            array('nama' => 'Biaya Tol dalam kota', 'nominal' => $biaya_tol),
            array('nama' => 'Biaya Tol Antar Kota', 'nominal' => $biaya_extol),
            array('nama' => 'Biaya Parkir', 'nominal' => $biaya_parkir),
        );
        $biayaTambahan = array();
        for ($i=0; $i < count($biayaPerjalanan); $i++) { 
            $biayaTambahan[$i] = array('nama' => $biayaPerjalanan[$i]['b_nama'], 'nominal' => $biayaPerjalanan[$i]['b_nominal']);
        }
        $pembulatan = ceil($query[0]['per_biaya']/50000)*50000;
        $selisihPem = $pembulatan - $query[0]['per_biaya'];
        $data = array('query' => $query, 'biaya'=> $biaya, 'biayaTambahan' => $biayaTambahan , 'kota' => $kota, 'no_inv' => $id);
        $data['dr_nama'] = Driver::find($driver)->dr_nama;
        $data['kar_nama'] = $karq->kar_nama;
        $data['uk_nama'] = UnitKerja::find($kar_uk)->uk_nama;
        $data['kep'] = $perjalanan->per_kep;
        $mobil = $perjalanan->per_mobil;
        $data['mobil'] = Kendaraan::find($mobil)->ken_merk.' | '.Kendaraan::find($mobil)->ken_nopol;
        $mob_kat = Kendaraan::find($mobil)->ken_kat;
        $data['mob_kat'] = Kategori::find($mob_kat)->kat_nama;
        $data['tgl_start'] = $this->convMonth($perjalanan->per_tgl_start);
        $data['tgl_kembali'] = $this->convMonth($this->getTglKemb($idPerjalanan, $perjalanan->per_tgl_start));
        $data['dari'] = $dari;
        $data['ttd'] = Ttd::find(1);
        $data['pembulatan'] = $pembulatan;
        $data['selisihPem'] = $selisihPem;
        $selisihKembali = $query[0]['per_biaya'] - $query[0]['per_pengembalian'];
        $data['selisihKembali'] = $selisihKembali;
        $data['bulatan'] = ceil($query[0]['per_biaya']/50000)*50000;
        $data['terbilang'] = $this->terbilang( $data['bulatan']);
        
        return view('main.print')->with($data);
    }
    public function getParkir($per_id, $kt_id)
    {
        $pk = PerKota::where([
            ['pk_per','=', $per_id],  
            ['pk_kt','=', $kt_id]
        ])->get()->toArray();
        $dur = $pk[0]['pk_dur'];
        $dur = ($dur==0) ? 1 : $dur ;
        $parkir = Kota::find($kt_id)->kt_parkir;
        return $parkir*$dur;
    }
    public function getTglKemb($per_id, $tgl_start)
    {
        $arr = explode('-', $tgl_start);
        $dur = PerKota::where('pk_per', $per_id)->get();
		$durasi = array();
        for ($i=0; $i <count($dur) ; $i++) {
            if($i!= count($dur)-1){
                $durasi[$i] = $dur[$i]['pk_dur'];
			}
        }
        $dure = array_sum($durasi);
		$pengur = $dure-1;
		if($pengur<0){
			$pengur=0;
		}
        $arr[0] = $arr[0]+$pengur;
        if ($arr[0]>31) {
            $arr[1] = $arr[1]+1;
            $arr[0] = ($arr[0]-31); 
        }
        $arr[0] = str_pad($arr[0], 2, "0", STR_PAD_LEFT);
        $arr = implode('-', $arr);
        return $arr;
    }
    public function getTol($per_id, $kt_id)
    {
        $pk = PerKota::where([['pk_per','=', $per_id],  ['pk_kt','=', $kt_id]])->firstOrFail();
        $dur = ($pk->pk_dur==0) ? 1 : $pk->pk_dur;
        $tol = Kota::find($kt_id)->kt_tol;
        return $tol*$dur;
    }
    public function getKota($kt_id)
    {
        return Kota::find($kt_id)->kt_nama;
    }
    public function rekap(Request $requst)
    {
        $perjalanan = array();
        $biaya = array();
        $biayaTambahan = array();
        $kota = array();
        $db = array();
        $per = new PerjalananController();
        $fulldate = str_replace('/', '-', $requst->range);
        $uk = $requst->uk;
        $from = substr($fulldate, 0,10);
        $to = substr($fulldate, 13,10);
        if ($uk=='0') {
            $perjalanan = DB::select("select * from `perjalanan`, `kendaraan`, `drivers`, `karyawan`, `unit_kerja` where 
                                        perjalanan.per_mobil = kendaraan.ken_id AND 
                                        perjalanan.per_karyawan = karyawan.kar_id AND
                                        karyawan.kar_uk = unit_kerja.uk_id AND 
                                        per_status = 1 AND
                                        perjalanan.per_driver = drivers.dr_id AND
                                        date_format(str_to_date(perjalanan.per_tgl_start, '%d-%m-%Y'), '%m-%d-%Y') BETWEEN '".$from."' AND '".$to."' ORDER BY date_format(str_to_date(perjalanan.per_tgl_start, '%d-%m-%Y'), '%m-%d-%Y') ASC");
        }
        else{
            $perjalanan = DB::select("select * from `perjalanan`, `kendaraan`, `drivers`, `karyawan`, `unit_kerja` where 
                                        perjalanan.per_mobil = kendaraan.ken_id AND 
                                        perjalanan.per_karyawan = karyawan.kar_id AND
                                        per_status = 1 AND
                                        karyawan.kar_uk = unit_kerja.uk_id AND
                                        karyawan.kar_uk = ".$uk." AND
                                        perjalanan.per_driver = drivers.dr_id AND
                                        date_format(str_to_date(perjalanan.per_tgl_start, '%d-%m-%Y'), '%m-%d-%Y') BETWEEN '".$from."' AND '".$to."' ORDER BY date_format(str_to_date(perjalanan.per_tgl_start, '%d-%m-%Y'), '%m-%d-%Y') ASC" );
        }
        
        $perjalanan = array_map(function ($value) {
            return (array)$value;
        }, $perjalanan);
        /*echo "<pre>";
        print_r($perjalanan);
        echo "</pre>";*/
        //echo $from;
        $sumtotal = 0;
        for ($i=0; $i < count($perjalanan); $i++) { 
            $query = DB::select("SELECT * FROM tujuan_perjalanan LEFT OUTER JOIN perjalanan ON tujuan_perjalanan.tp_per = perjalanan.per_id 
            LEFT OUTER JOIN tujuan ON tujuan_perjalanan.tp_tj = tujuan.tj_id WHERE per_no = ".$perjalanan[$i]['per_no']);
            $query = array_map(function ($value) {
                return (array)$value;
            }, $query);
            //$perjalanan[$i]['per_tgl_start'] = $this->convMonth($perjalanan[$i]['per_tgl_start']);
            $perjalanan[$i]['per_jam'] = $perjalanan[$i]['per_jam'].' WIB';
            for ($j=0; $j <count($query) ; $j++) { 
                $kota[$i][$j] = $this->getKota($query[$j]['tj_kota_2']);    
            }
            $idPerjalanan = $perjalanan[$i]['per_id'];
            $per_kota = PerKota::where('pk_per', $idPerjalanan)->get();
            $biayaPerjalanan = Biaya::where('b_tp', $idPerjalanan)->get()->toArray();
            
            for ($j=0; $j <count($per_kota) ; $j++) {
                $tol[$i][$j] = $per_kota[$j]['pk_tol'];//$this->getTol( $idPerjalanan, $query[$i]['tj_kota_2']);
                $parkir[$i][$j] = $per_kota[$j]['pk_parkir'];
            }
    
            for ($j=0; $j <count($query) ; $j++) { 
                $extol[$i][$j] = $query[$j]['tp_tol'];
                $bbm[$i][$j] = $query[$j]['tp_bbm'];
                $kota[$i][$j] = $this->getKota($query[$j]['tj_kota_2']); 
				$kota[$i][$j] = $this->getSingkatan($kota[$i][$j]);
            }
			$dari[$i] = $this->getKota($query[0]['tj_kota_1']);
			$dari[$i] = $this->getSingkatan($dari[$i]);
			//$tujuan_per[$i] = $dari.' - '.$kota[$i];
            $biaya_tol = array_sum($tol[$i]);
            $biaya_extol = array_sum($extol[$i]);
            $biaya_parkir = array_sum($parkir[$i]);
            $biaya_bbm = array_sum($bbm[$i]);
            $biaya[$i] = array(
                array('nama' => 'Biaya BBM', 'nominal' => $biaya_bbm,
                'pen' => $this->getFin($idPerjalanan, 'Biaya BBM')),
                array('nama' => 'Biaya Tol dalam kota', 'nominal' => $biaya_tol, 
                'pen' => $this->getFin($idPerjalanan, 'Biaya Tol dalam kota')),
                array('nama' => 'Biaya Tol Antar Kota', 'nominal' => $biaya_extol,
                'pen' => $this->getFin($idPerjalanan, 'Biaya Tol Antar Kota')),
                array('nama' => 'Biaya Parkir', 'nominal' => $biaya_parkir,
                'pen' => $this->getFin($idPerjalanan, 'Biaya Parkir')),
            );
            $biayaTambahan[$i] = array();
            for ($j=0; $j < count($biayaPerjalanan); $j++) { 
                $biayaTambahan[$i][$j] = array('nama' => $biayaPerjalanan[$j]['b_nama'], 'nominal' => $biayaPerjalanan[$j]['b_nominal'], 
                'pen' => Penyelarasan::where([['pen_per','=', $idPerjalanan], ['nama_biaya','=',  $biayaPerjalanan[$j]['b_nama']]])->get()[0]['nominal']);
                $bt[$j] = $biayaTambahan[$i][$j]['nominal'];
            } 
            //$perjalanan[$i]['per_biaya'] = $perjalanan[$i]['per_biaya']-$perjalanan[$i]['per_pengembalian']; 
            $sumtotal += $perjalanan[$i]['per_biaya']-$perjalanan[$i]['per_pengembalian'];
			$tglStart = $perjalanan[$i]['per_tgl_start'];
			$tglKembali = $this->getTglKemb($idPerjalanan, $perjalanan[$i]['per_tgl_start']);
			$tgl_per[$i] = $tglStart.' - '.$tglKembali;
        }
        $from = $this->swap($from);
        $to = $this->swap($to);
        //$from = $this->convMonth($from);
        //$to = $this->convMonth($to);
        $rang = $from.' hingga '.$to;
        $data = array('perjalanan' => $perjalanan, 'kota' => $kota, 'range' => $rang, 'biaya'=> $biaya, 'biayaTambahan' => $biayaTambahan);
        if ($uk!='0') {
            $data['dep'] = UnitKerja::find($uk)->uk_nama;
        }
        else{
            $data['dep'] = "Semua departemen";
        }
        //echo print_r($biaya[0]);
		
        $data['ttdpk'] = Ttd::find(2);
        $data['ttdsk'] = Ttd::find(1);
        $data['sumtotal'] = $sumtotal;
		$data['tgl_per'] = (isset($tgl_per)) ? $tgl_per : '';
		$data['tujuan_per'] = $kota;
		$data['dari'] = (isset($dari)) ? $dari : '';
		
        return view('main.rekap')->with($data);
    }
	public function getSingkatan($kota)
    {
        // persiapkan curl
		$ch = curl_init(); 
		$singkatan = $kota;

		// set url 
		curl_setopt($ch, CURLOPT_URL, url('')."/singkatan_kota_id.json");

		// return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		// $output contains the output string 
		$output = curl_exec($ch); 

		// tutup curl 
		curl_close($ch);
		$output = json_decode($output, true);
		for($i=0; $i<count($output); $i++){
			if($output[$i]['Kota']==$kota){
				$singkatan = $output[$i]['Singkatan'];
			}
		}
		return $singkatan;
    }
    public function getFin($id_per, $nama)
    {
        return Penyelarasan::where([['pen_per','=', $id_per], ['nama_biaya','=', $nama]])->get()[0]['nominal'];
    }
    public function swap($var)
    {
        $arr = explode('-', $var);
        $tmpArr =$arr[0];
        $arr[0] = $arr[1];
        $arr[1] = $tmpArr;
        return implode('-', $arr);
    }
    public function convMonth($date)
    {
        $arr = explode('-', $date);
        $tmpArr = $arr[1];
        switch ($tmpArr) {
            case '01':
                $arr[1] = 'Januari';
                break;
            
            case '02':
                $arr[1] = 'Februari';
                break;
            
            case '03':
                $arr[1] = 'Maret';
                break;
            
            case '04':
                $arr[1] = 'April';
                break;
            
            case '05':
                $arr[1] = 'Mei';
                break;
            
            case '06':
                $arr[1] = 'Juni';
                break;
            
            case '07':
                $arr[1] = 'Juli';
                break;
            
            case '08':
                $arr[1] = 'Agustus';
                break;
            
            case '09':
                $arr[1] = 'September';
                break;
            
            case '10':
                $arr[1] = 'Oktober';
                break;
            
            case '11':
                $arr[1] = 'November';
                break;
            
            case '12':
                $arr[1] = 'Desember';
                break;
            
            default:
                break;
        }
        return implode(' ', $arr);
    }
}
