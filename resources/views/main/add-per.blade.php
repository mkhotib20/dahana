@extends('main.template')

@section('content')
        <style>
            .datePick{
                background-color: white!important;
                cursor: pointer!important;
            }
            .ui-menu .ui-menu-item a{
                height:20px;
            }
            .kota-box{
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                margin: 10px;
                margin-left: 15px;
                padding-bottom: 50px!important;
            }
            .perj-box{
                margin-bottom: 90px;
                margin-top: 50px;
            }
            .btn{
                color: white!important;
            }
            .help-block{
                color: red;
            }
            .ada-error{
                border: 2px solid red!important;
            }
 
        </style>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                <br>
                                    <h4 >Tambah Perjalanan</h4>
                                    <p>Nomor : {{$per_no}} </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-pills navtab-bg nav-justified mb-3">
                                                    <li class="nav-item">
                                                        <a href="#dataper" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                                            Data perjalanan
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#dataken" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                                            Keberangkatan
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#datatj" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                                            Kota Tujuan
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#databiaya" id="btamb" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                            Biaya Tambahan
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#datatotal" id="genTarif" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                            Total Biaya
                                                        </a>
                                                    </li>
                                                </ul>
                                                {{  Form::open(['route'=>'perjalanan.store', 'method'=>'POST', 'id'=>'formval']) }}
                                                <input type="text" value="{{$per_id}} " hidden name="per_id" id="per_id">
                                                <input type="text" value="{{$tj_kota_1}} " name="tj_kota_1" hidden id="kota_1">
                                                <input type="text" value="{{$per_no}}" name="per_no" hidden>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="dataper">
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Pilih tipe perjalanan</label>
                                                            <div class="col-sm-12">
                                                                <select required name="per_pengaju" id="tipe_per" class="form-control">
                                                                    <option value="reg" >Perjalanan Reguler</option>
                                                                    <option value="dir" >Perjalanan Direksi</option>
                                                                </select>
                                                                <small>Berpengaruh pada uang saku driver</small>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Masukkan Nama Yang Mengajukan</label>
                                                            <div class="col-sm-12">
                                                                <select required name="per_pengaju" class="form-control select2" data-toggle="select2">
                                                                    <option selected disabled>--pilih pengaju--</option>
                                                                    @foreach ($karyawan as $key => $value)
                                                                        <option value=" {{$value->kar_nama}} "> {{$value->kar_nama}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="help-block" >{{  $errors->first('per_pengaju', ':message')  }}</p>                                                               
                                                            
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Masukkan keperluan</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="per_kep" placeholder="Keperluan" class="form-control">
                                                                <p class="help-block" >{{  $errors->first('per_kep', ':message')  }}</p>                                                               
                                                            
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Masukkan Nama Yang DIlayani</label>
                                                            <div class="col-sm-12">
                                                                <select required class="form-control select2" name="per_karyawan" data-toggle="select2">
                                                                    <option selected disabled>--pilih karyawan--</option>
                                                                    @foreach ($karyawan as $key => $value)
                                                                        <option value=" {{$value->kar_id}} "> {{$value->kar_nama}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <p class="help-block" >{{  $errors->first('per_karyawan', ':message')  }}</p>
                                                            
                                                            </div>
                                                        </div>    
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Pilih Mobil</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control select2" name="per_kendaraan" data-toggle="select2" id="per_kendaraan" name="per_kendaraan">
                                                                    <option value="null" disabled selected>--pilih mobil--</option>
                                                                @foreach ($kendaraan as $key => $value)
                                                                    <option value=" {{$value->ken_id}} "> {{$value->ken_merk}} || {{$value->ken_nopol}}</option>
                                                                @endforeach
                                                                </select>
                                                                <p class="help-block" >{{  $errors->first('per_kendaraan', ':message')  }}</p>
                                                            </div>
                                                        </div>       
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Pilih Driver</label>
                                                            <div class="col-sm-12" >
                                                                <select required name="per_driver" class="form-control select2 " data-toggle="select2" id="per_driver" name="per_driver">
                                                                    <option disabled selected>--pilih driver--</option>
                                                                @foreach ($driver as $key => $value)
                                                                    <option data-status="{{$value->status}}" value=" {{$value->dr_id}} "> {{$value->dr_nama}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>     
                                                    </div>
                                                    <div class="tab-pane " id="dataken">
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Masukkan Tanggal Berangkat</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" readonly class="form-control datePick" id="per_tgl_start" name="per_tgl_start" 
                                                                value="" maxlength="50" required="">
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">Jam keberangkatan (WIB)</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" name="per_jam" data-inputmask="'mask': '99:99'" />
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="karyawan" class="col-sm-4 control-label">KM Awal</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" value="0" name="km_start" />
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="tab-pane" id="datatj">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="timeline">
                                                                    <article class="timeline-item">
                                                                        <div class="timeline-desk">
                                                                            <div class="timeline-box kota-box">
                                                                                <span class="timeline-icon"><i class=" mdi mdi-hospital-building"></i></span>
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <h5 class="text-danger mb-1">Kantor PT. Dahana</h5>
                                                                                        <div class="form-group">
                                                                                            <label for="karyawan" class="col-sm-4 control-label">Pilih Keberangkatan</label>
                                                                                            <div class="col-sm-12 switchery-demo">
                                                                                                
                                                                                                <input type="checkbox"  id="swt" data-plugin="switchery" data-color="#039cfd"/>
                                                                                                <span id="swt-val">Subang</span>
                                                                                            </div>
                                                                                        </div> 
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </article>
                                                                <div id="kota">
                                                                    <div class="newp" id="kota_1">
                                                                        <article class="timeline-item">
                                                                            <div class="timeline-desk">
                                                                                <div class="timeline-box perj-box">
                                                                                    <span class="timeline-icon"><i class="mdi mdi-car"></i></span>
                                                                                    <h5 class="text-danger mb-1">Biaya Perjalanan  </h5> <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="kt_id" hidden id="kt_id_1">
                                                                                            <input autocomplete="off" placeholder="Nama kota" id="per_tujuan_1" class="form-control per_tujuan"  name="kt_nama[]" type="text">
                                                                                            <small>Nama Kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input class="form-control jarak" placeholder="Jarak (Km)" id="per_jarak_1"  name="tj_jarak[]" type="text">
                                                                                            <small>Jarak antar kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text"  class="form-control bbm" name="per_bbm[]" placeholder="Biaya BBM" id="bbm_1"  type="text">
                                                                                            <small>Biaya BBM Antar Kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control extol" placeholder="Biaya Tol" id="extol_1" name="tj_tol[]" type="text" >
                                                                                            <small>Biaya tol antar kota</small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                        <article class="timeline-item">
                                                                            <div class="timeline-desk">
                                                                                <div class="timeline-box kota-box">
                                                                                    <span class="timeline-icon"><i class="mdi mdi-pin"></i></span>
                                                                                    <h5 class="text-danger mb-1">Biaya dalam kota </h5> <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-10">
                                                                                            <div class="row">
                                                                                                <div class="col-md-3">
                                                                                                    <input value="1" min="1" placeholder="Durasi (hari)" id="dur_1" name="pk_dur[]" class="form-control dur"type="number">
                                                                                                    <small>Durasi (hari)</small>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="text"  class="form-control bbm_old" name="pk_bbm[]" placeholder="Biaya BBM" id="bbm_dalam_1"  type="text">
                                                                                                    <small>Biaya BBM Dalam Kota</small>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="text" class="form-control tol" placeholder="Biaya Tol dalam kota" id="tol_1" name="kt_tol[]" type="text">
                                                                                                    <small>Biaya tol dalam kota</small>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input class="form-control parkir" placeholder="Biaya Parkir" name="kt_parkir[]" id="parkir_1" type="text">
                                                                                                    <small>Biaya parkir</small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <center><a id="addKota" class="btn btn-success btn-lg btn-rounded"><span class="fe fe-plus"></span></a></center>
                                                                <input hidden value="1" placeholder="Durasi (hari)" name="pk_dur[]" id="dur_n" type="text"> 
                                                                <div id="kota_n">
                                                                        <article class="timeline-item">
                                                                            <div class="timeline-desk">
                                                                                <div class="timeline-box">
                                                                                    <span class="timeline-icon"><i class="mdi mdi-car"></i></span>
                                                                                    <h5 class="text-danger mb-1">Perjalanan pulang ke PT. Dahana</h5> <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <input class="form-control" placeholder="Jarak (Km)" id="per_jarak_n" name="tj_jarak[]"  type="text">
                                                                                            <small>Jarak perjalanan pulang</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control"  placeholder="Biaya BBM" id="bbm_n" name="per_bbm[]"  type="text">
                                                                                            <small>Biaya BBM</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control" placeholder="Biaya Tol " id="extol_n" name="tj_tol[]"  type="text" >
                                                                                            <small>Biaya tol antar kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" value="0" hidden id="kt_id_n">
                                                                                            <input autocomplete="off" placeholder="Nama kota" id="per_tujuan_n" name="kt_nama[]" hidden value="Subang" class="form-control per_tujuan" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                        <article hidden class="timeline-item">
                                                                            <div class="timeline-desk">
                                                                                <div class="timeline-box">
                                                                                    <span class="timeline-icon"><i class="mdi mdi-pin"></i></span>
                                                                                    <h5 class="text-danger mb-1">Biaya di kota </h5> <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-10">
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <input value="1" placeholder="Durasi (hari)" name="pk_dur[]" id="dur_n" type="text">
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <input type="text" class="form-control tol" value="0" name="kt_tol[]" placeholder="Biaya Tol dalam" id="tol_n"  type="text">
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <input class="form-control" value="0" name="kt_parkir[]" placeholder="Biaya Parkir"  id="parkir_n" type="text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </div>                                   
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div>
                                                    </div>
                                                    <div class="tab-pane" id="databiaya">
                                                    <div id="newBiaya">
                                                        <div class="form-group newB" id="b_1">
                                                            <label for="email" class="col-sm-4 control-label">Biaya Perjalanan</label>
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <input type="text" readonly placeholder="Nama biaya" data-precision="0" data-thousands=" " data-prefix="Rp "  
                                                                        class="form-control" value="-" id="b_nama_1" name="b_nama[]" >
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="text" placeholder="Nominal" data-precision="0" data-thousands=" " data-prefix="Rp "  
                                                                        class="form-control rupiah"  name="b_nominal[]" id="b_nominal_1" >
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <a unselectable="on" style="cursor: pointer; color:white" class="btn btn-success " id="addBiaya"> <i class="fe fe-plus"></i> Biaya</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                    </div>
                                                    </div>
                                                    <div class="tab-pane" id="datatotal">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                            <label for="karyawan" class="col-sm-4 control-label">Tarif Perjalanan</label>
                                                            </div>
                                                            <div class="col-sm-6 offset-md-3">
                                                                <h2>Rincian Biaya</h2>
                                                                <hr style="border: 1px dashed #dbdbdb">
                                                                <div id="rincian">
                                                                </div>
                                                                <hr style="border: 1px dashed #dbdbdb">
                                                                <input value="{{$per_tarif}}" type="text" hidden class="form-control" id="tarif" name="per_biaya" 
                                                                maxlength="50" required="">
                                                                <h2 style="height: 60px; background-color: #dbdbdb; padding: 10px; text-align: right" id="tarif2"> @if($per_tarif!=0){{ number_format($per_tarif, '0', ',', '.')}}@else<em>tarif</em>@endif</h2>
                                                                <button value="Simpan" type="submit" id="sbmt" class="btn btn-success float-right" ><span class="fe fe-paper-plane" ></span> Simpan</button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                            </div>
                                                        </div>   
                                                        
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                
                                                            </div>
                                                        </div>   
                                                    </div>
                                                </div>   
                                                {{  Form::close()  }}                 
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->  

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>

@endsection