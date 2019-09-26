
<style>
@media print{@page {size: A4 landscape; margin: 0; }}
  *{
    font-size: 9.5pt;
  }
  .konten {
    width: 100%; /* This guarantees there will be enough room for 2 badges side-by-side */
    margin-top: 30px;
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
  .badang {
    vertical-align: top;
    box-sizing: border-box; /* You only need this if you add padding or borders */
    display: inline-block;
    width: 49.81%;
    height: 100%;
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
    font-size: 11pt;
    font-weight: bold;
    border-bottom: 2px solid black;
  }
  .spd .judul{
    width: 60%;
  }
  .inv .judul{
    width: 75%;
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

<div>
  <table class="konten">
    <tr>
      <td  class="badang spd">
        <div class="header">
          <img class="left" src="{{url('public/icons/logo-sm.png')}} " alt="">
          <img class="right" src="{{url('public/icons/iso.png')}} " alt="">
        </div>
        <center><p class="judul" >SURAT PERJALANAN DINAS</p>
        <p>Nomor : SPD/{{$query[0]['per_no']}}</p>
        </center>

        <table class="spd-tb">
          <tr>
            <td>
              <b>Diperintahkan kepada</b>
            </td>
          </tr>
          <tr>
            <td>
              Nama Pengemudi
            </td>
            <td>
              {{$dr_nama}}
            </td>
          </tr>
          <tr>
            <td>
              <b>Melayani</b>
            </td>
          </tr>
          <tr>
            <td>
              Nama
            </td>
            <td>
              {{$kar_nama}}
            </td>
          </tr>
          <tr>
            <td>
              Departemen
            </td>
            <td>
              {{$uk_nama}}
            </td>
          </tr>
          <tr>
            <td>
              Tujuan
            </td>
            <td>
            <?php 
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
              ?> 
          </tr>
          <tr>
            <td>
              Keperluan
            </td>
            <td>
              {{$kep}}
            </td>
          </tr>
          <tr>
            <td>
              Kendaraan
            </td>
            <td>
              {{$mobil}}
            </td>
          </tr>
          <tr>
            <td>
              Berangkat TGL
            </td>
            <td>
              {{$tgl_start}}
            </td>
          </tr>
          <tr>
            <td>
              Kembali TGL
            </td>
            <td>
              {{$tgl_kembali}}
            </td>
          </tr>
          <tr>
            <td>
              KM Awal 
            </td>
            <td>
              {{$query[0]['per_km_start']}}
            </td>
          </tr>
        </table>
        <div class="form-ttd right">
          <br><br>
          <p>Dikeluarkan Di : </p>
          <p>Pada Tanggal : </p>
          <div class="ttd">
          <center>{{$ttd->nama}}</center>
            <hr>
            <center><p>{{$ttd->jabatan}}</p></center>
          </div>
        </div>
      </td>
      <td class="badang inv">
        <div class="header">
          <img class="left" src="{{url('public/icons/logo-sm.png')}} " alt="">
          <img class="right" src="{{url('public/icons/iso.png')}} " alt="">
        </div>
        <center><p class="judul" >PERINCIAN BIAYA PERJALANAN DINAS</p>
        <p>Nomor Surat : PK/{{$query[0]['per_no']}}</p></center>
        <table class="inv-tb">
          <tr>
            <td>Nama</td>
            <td>{{$dr_nama}} </td>
          </tr>
          <tr>
            <td>Melayani</td>
            <td>{{$kar_nama}} </td>
          </tr>
          <tr>
            <td>Keperluan</td>
            <td>{{$kep}}</td>
          </tr>
          <tr>
            <td>Tujuan</td>
            <td> <?php 
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
              ?>      </td>
          </tr>
          <tr>
            <td>Dari</td>
            <td>{{$dari}} </td>
          </tr>
          <tr>
            <td>Tanggal Berangkat</td>
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
        </table>
        <table class="table">
            <thead>
              <th style="width: auto; text-align: left">No</th>
                <th style="width: 60%; text-align: left" >Nama Biaya</th>
                <th style="text-align: left" >Nominal</th>
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
                  </tr>
                  @endforeach
                 
                  <tr>
                      <td></td>
                      <td>
                           Total Biaya :  <br/>
                      </td>
                      <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($query[0]['per_biaya'], '2', ',', '.'); ?></td>
                  </tr>
                  <tr  style="font-weight: bold">
                    <td></td>
                    <td>
                      Biaya yang diterima
                    </td>
                    <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($bulatan, '2', ',', '.'); ?></td>
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
              <span><center>{{$ttd->nama}}</center></span>
              <hr align="left">
              <center><p>{{$ttd->jabatan}}</p></center>
            </div>
          </td>
        </table>
      </td>
    </tr>
  </table>
</div>
<script>
       window.print();
    setTimeout(function(){
        window.close()
    }, 900)
</script>