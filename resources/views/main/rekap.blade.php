
<style>
@media print{@page {size: A4 landscape; margin:1cm}}
  *{
      font-size: 9.5pt;
  }
.header img{
    height: 40px;
  }

  .right{
    float: right;
  }
  table {
    border-collapse: collapse;
    width: 100%;
  }
  p{
      height: 20px;
  }

    table, th, td {
    border: 1px solid black;
    padding-left: 7px;
    }
.ttd-left{
    width: 30%;
}
.spacer{
    width: 50%;
}
.form-ttd td, .form-ttd{
    border: none;
}
.form-ttd{
    margin-top: 50px;
}
.form-ttd p{
    line-height: 5px;
}
.form-ttd hr{
    margin: 0px;
    border: 1px solid black;
}
.spacer{
    margin-top: 45px;
}
.float-left{
    float: left;
}
</style>

<div>
    <div class="header">
        <img class="left" src="{{url('public/icons/logor.png')}} " alt="">
        <img class="right" src="{{url('public/icons/iso.png')}} " alt="">
    </div>
    <center><b><p>LAPORAN PERJALANAN DINAS</p></b>
    <p>Tanggal : {{$range}} <br>Departemen : {{$dep}} </p>
    </center>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2" >Nomor Surat</th>
                <th style="width: 6%" rowspan="2">Tgl Invoice</th>
                <th rowspan="2">Tgl Perjalanan</th>
                <th style="width: 6%" rowspan="2">Departemen</th>
                <th rowspan="2">Kota Tujuan </th>
                <th rowspan="2">Melayani</th> 
                <th rowspan="2">Kendaraan </th>
                <th rowspan="2">Pengemudi</th>
                <th rowspan="2">Biaya BBM</th>
                <th colspan="2">Biaya Tol</th>
                <th rowspan="2">Biaya Parkir</th>
                <th rowspan="2">Biaya Tambahan</th>
                <th rowspan="2">Jumlah</th>
            </tr>
            <tr>
                <th>Dalam</th>
                <th>Luar</th>
            </tr>
        </thead>
        <tbody>
        <?php $no =1; $ct = count($perjalanan);
            for ($i=0; $i < $ct; $i++) {
                if ($ct==0) {
                    echo '<tr><td>kosong</td></tr>';
                }
                $value = $perjalanan[$i];
                $val_kota = $biayaTambahan[$i];
        ?>
            <tr>
                <td>{{$no++}} </td>
                <td>{{$value['per_no']}} </td>
                <td> {{$value['per_tgl_start']}}</td>
                <td>{{$tgl_per[$i]}}</td>
                <td> {{$value['uk_nama']}}</td>
               <td>
				{{$dari[$i]}}
				<?php
				for($j=0; $j < count($tujuan_per[$i]); $j++)
				{
					$tmp = ($j>0 ? $tujuan_per[$i][$j] : '');
					if($tujuan_per[$i][$j] != '' || $tujuan_per[$i][$j] != $tmp){
						echo ' - '.$tujuan_per[$i][$j];
						
							
					}
					
				}?>

				
				</td>
                <td>{{$value['kar_nama']}}</td> 
                <td><b>{{$value['ken_merk']}}</b> <br> <small>{{$value['ken_nopol']}}</small></td>
                <td>{{$value['dr_nama']}}</td>
                <td>{{number_format($biaya[$i][0]['pen'], '0', ',', '.')}} </td>
                <td>{{number_format($biaya[$i][1]['pen'], '0', ',', '.')}} </td>
                <td>{{number_format($biaya[$i][2]['pen'], '0', ',', '.')}} </td>
                <td>{{number_format($biaya[$i][3]['pen'], '0', ',', '.')}} </td>
                <td><?php
                    for ($j=0; $j < count($val_kota); $j++) { 
                        echo '<b>'. $val_kota[$j]['nama'].'</b>';
                        echo '<br>';
                        echo number_format($val_kota[$j]['pen'], '0', ',', '.');
                        echo '<br>';
                        
                    }
                ?></td>
                <td style="text-align: right" ><span class="float-left" ></span> <span>{{number_format(($value['per_biaya']-$value['per_pengembalian']), '0', ',', '.') }}</span></td>
            </tr>
            <?php } ?>
            <tr style="padding: 10px">
                <td style="text-align: center" colspan="12"><b>Total</b></td>
                <td  style="text-align: right; padding: 10px" colspan="2"><span class="float-left">Rp. </span> {{number_format($sumtotal, '0', ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <table class="form-ttd">
        <td class="ttd-left">
            <center>
                <p>Mengetahui, </p>
                <div class="spacer"></div>
                <span>{{$ttdpk->nama}}</span>
                <hr>
                <p>{{$ttdpk->jabatan}}</p>
            </center>
        </td>
        <td class="spacer">
        </td>
        <td class="ttd-left">
                <p>Subang,______________</p>
            <center>
                <p>Menyetujui, </p>
                <div class="spacer"></div>
                <span>{{$ttdsk->nama}}</span>
                <hr>
                <p>{{$ttdsk->jabatan}}</p>
            </center>
        </td>
    </table>
</div>
<script>
    window.print();
    setTimeout(function(){
        window.close()
    }, 900)
</script>