@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Anggaran Biaya</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                    <form action=" {{url('perjalanan/selesai')}} " method="POST">    
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="text" hidden name="pen_per" value="{{$per_id}} ">
                                        <div class="row">
                                                <div class="col-md-6">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>KM Awal</th>
                                                                    <th>KM Akhir</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" id="km_start" name="km_start" class="form-control" value="{{$per_km_start}}">
                                                                    </td>
                                                                    <td>
                                                                        <input id="km_end" data-kons="{{$kons}}" data-bbm="{{$bbm_hrg}}" required type="text" name="km_end" class="form-control" >
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tarif BBM Sesuai KM</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="bbm_pasti" class="text-left"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                        </div>
                                    <table class="table">
                                        <thead>
                                        <th style="width: auto; text-align: left">No</th>
                                            <th style="width: 60%; text-align: left" >Nama Biaya</th>
                                            <th style="text-align: left" >Uang Muka</th>
                                            <th>Biaya yang digunakan</th>
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
                                                <td>
                                                    <input type="hidden" name="nama_biaya[]" value="{{$val['nama']}}">
                                                    <input type="text" name="nominal[]" class="form-control rupiah" value="{{$val['nominal']}}">
                                                </td>
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
                                                <td>
                                                    <input type="hidden" name="nama_biaya[]" value="{{$val['nama']}}">
                                                    <input type="text" name="nominal[]" class="form-control rupiah" value="{{$val['nominal']}}">
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        
                                            <tr>
                                                <td></td>
                                                <td>
                                                    Total :  <br/>
                                                </td>
                                                <td class="text-right"><span class="float-left" >Rp </span><?php echo number_format($query[0]['per_biaya'], '2', ',', '.'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="submit" value="Selesai" class="btn btn-success float-right">
                                </form>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>                    
                    </div>
@endsection
