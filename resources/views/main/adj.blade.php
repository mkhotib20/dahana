
<style>
@media print{@page {size: A4; margin: 2cm; }}
  *{
    font-size: 12pt;
  }
 
  
  .table{
      width: 100%;
  }
  .table thead{
    background-color: #dbdbdb;
  }
  .table th{
    padding: 10px;
  }
  .ttd-inv{
    margin-top: 20px;
    width: 100%;
  }
  hr{
    margin: 1px;
    background-color: black;}
  .ttd-inv hr{
    text-align: left;
  }
  p{
    margin: 0px;
  }
  .ttd-inv td{
    vertical-align: top;
    width: 50%;
  }
  .badang:first-child{
    padding-left: 2cm;
    padding-right: 1cm;
  }
  .badang:last-child{
    padding-left: 1cm;
    padding-right: 2cm;
  }
  .text-right{
    text-align: right;
  }
  .float-left{
    float:left;
  }
  .header img{
    height: 30px;
  }
  .right{
    float: right;
  }
  .judul{
    font-size: 12pt;
    font-weight: bold;
    border-bottom: 2px solid black;
  }
  .spd-tb td{
    width: auto;
  }
  .form-ttd{
    width: 50%;
    display: inline-block;
  }
  .ttd{
    margin-top: 90px;
  }
  .spd-tb{
    margin-top: 50px;
  }
  .table td{
      padding: 5px;
    height: 20px;
  }
  .table{
    margin-top: 10px;
  }
  .spd-tb td{
    height: 23px;
  }
  .inv-tb td{
    padding-right: 20px;
  }
  .hidden{
    display: none;
  }
</style>
    <div class="konten">
        <div class="header">
            <img class="left" src="{{url('public/icons/logo-sm.png')}} " alt="">
            <img class="right" src="{{url('public/icons/iso.png')}} " alt="">
        </div>
        <center><p class="judul" >PERINCIAN BIAYA PERJALANAN DINAS</p>
        <p>Nomor Surat : PK/{{$query[0]['per_no']}}@if($query[0]['per_status']==1){{'/ADJ'}} @endif </p></center>
        <table>
          <tr>
            <td style="width: 50%">Nama</td>
            <td>{{$dr_nama}} </td>
          </tr>
          <tr>
            <td style="width: 50%">Melayani</td>
            <td>{{$kar_nama}} </td>
          </tr>
          <tr>
            <td>Keperluan</td>
            <td>{{$kep}}</td>
          </tr>
          <tr>
            <td>Tujuan</td>
            <td><?php 
                  $tmp ='';
                  for ($i=0; $i < count($kota)-1; $i++) {  
					if($kota[$i] != $tmp){
						
						if ($i!=0 && $kota[$i] != '') {
						  echo ' - ';
						}  
						echo $kota[$i];
					}
					$tmp = $kota[$i];
                    
                  }
              ?>  </td>
          </tr>
          <tr>
            <td>Dari</td>
            <td>{{$dari}} </td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td>{{$tgl_start}} </td>
          </tr>
          <tr>
            <td>Tanggal Kembali</td>
            <td>{{$tgl_kembali}} </td>
          </tr>
          <tr>
            <td>Kategori kendaraan  </td>
            <td>{{$mob_kat}} </td>
          </tr>
          <tr>
            <td>KM Awal</td>
            <td>{{$km_s}} </td>
          </tr>
          <tr>
            <td>KM Akhir</td>
            <td>{{$km_e}} </td>
          </tr>
        </table>
        <table class="table">
            <thead>
              <th style="width: auto; text-align: left">No</th>
                <th style="width: 36%; text-align: left" >Nama Biaya</th>
                <th style="width: 20%;text-align: left" >Uang Muka</th>
                <th style="text-align: left" >Biaya yang digunakan</th>
                <th style="text-align: left" >Pengembalian</th>
            </thead>
            <tbody>
              <?php $no = 1?>
                @foreach ($biaya as $val)
                  <tr>
                      <td> <center>{{$no++}}</center> </td>
                      <td>
                           <?php echo $val['nama'] ?> <br/>
                      </td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['nominal'], '2', ',', '.'); ?></td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['pen'], '2', ',', '.'); ?></td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format(($val['nominal'])-($val['pen']), '2', ',', '.'); ?></td>
                  </tr>

                  @endforeach
                  @if($biayaTambahan)
                  <tr>
                      <td> <center>{{$no++}}</center> </td>
                      <td>
                           Biaya Tambahan :  <br/>
                      </td>
                      <td class="text-right"> </td>
                  </tr>
                  @endif
                  @foreach ($biayaTambahan as $val)
                  <tr>
                      <td> </td>
                      <td> -
                          <?php echo $val['nama'] ?> <br/>
                      </td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['nominal'], '2', ',', '.'); ?></td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['pen'], '2', ',', '.'); ?></td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format(($val['nominal'])-($val['pen']), '2', ',', '.'); ?></td>
                  </tr>
                  @endforeach
                  
                  <tr>
                      <td> <center>{{$no++}}</center> </td>
                      <td>
                           Biaya Pembulatan  <br/>
                      </td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($selisihPem, '2', ',', '.'); ?></td>
                      <td class="text-right">0</td>
                      <td class="text-right"><span class="float-left" > </span><?php echo number_format($selisihPem, '2', ',', '.'); ?></td>
                  </tr>
                  <tr style="font-weight: bold">
                      <td></td>
                      <td>
                           Total Biaya :  <br/>
                      </td>
                      <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($pembulatan, '2', ',', '.'); ?></td>
                      <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($selisihKembali, '2', ',', '.'); ?> </td>
                      <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($pembulatan-$selisihKembali, '2', ',', '.'); ?> </td>
                  </tr>
                  <tr>
                    <td  colspan="4" > TOTAL BIAYA DIGUNAKAN :  </td>
                    <td class="text-right"><span class="float-left" >Rp </span><b><?php echo number_format($selisihKembali, '2', ',', '.'); ?></b></td>
                  </tr>
                  <tr>
                      <td colspan="3" style="text-align: left"> Terbilang : <em>{{ucwords($terbilang)}} Rupiah</em></td>
                  </tr>
            </tbody>
        </table>
        <table class="ttd-inv">
          <td>
          <br>
            <p>Penerima </p>
            <div class="ttd">
              <span>{{$dr_nama}}</span>
              <hr width="75%" align="left">
            </div>
          </td>
          <td>
            <p>Dikeluarkan Di : </p>
            <p>Pada Tanggal : </p>
            <div class="ttd">
            <span>{{$ttd->nama}}</span>
              <hr align="left">
              <center><p>{{$ttd->jabatan}}</p></center>
            </div>
          </td>
        </table>
    </div>
<script>
       window.print();
    setTimeout(function(){
        window.close()
    }, 900)
</script>