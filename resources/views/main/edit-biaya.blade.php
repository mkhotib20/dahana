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
 
        </style>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                <br>
                                    <h4 >Ubah Perjalanan</h4>
                                    <p>Nomor : {{$per_no}} </p>
                                    <p>Tujuan perjalanan : <?php
                                                 for ($i=0; $i < count($kota); $i++) { 
                                                    if ($i!=count($kota)-1) {
                                                        echo $kota[$i];
                                                        echo ' - ';
                                                    }
                                                }
                                            ?>
                                        </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-pills navtab-bg nav-justified mb-3">
                                                    <li class="nav-item">
                                                        <a href="#databiaya" id="btamb" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                            Biaya Tambahan
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#datatotal" id="genTarif" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                            Total Biaya
                                                        </a>
                                                    </li>
                                                </ul>
                                                <form method="POST" action="{{url('perjalanan/updateBiaya')}}">
                                                    {{ csrf_field() }}
                                                <input type="text" value="{{$per_no}}" name="per_no" hidden>
                                                <input type="text" value="{{$per_id}} " hidden name="per_id" id="per_id">
                                                <input type="text" value="{{$tj_kota_1}} " id="kota_1" hidden name="tj_kota_1">
                                                <select hidden class="form-control" id="per_kendaraan" name="per_kendaraan">
                                                    <option value="null" disabled selected>--pilih kendaraan--</option>
                                                    <option value="0">0</option>
                                        </select> 
                                                <div class="tab-content">
                                                    <div class="tab-pane " id="datatj">
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
                                                                                            <input class="form-control jarak" placeholder="Jarak (Km)" value="0" id="per_jarak_1"  name="tj_jarak[]" type="text">
                                                                                            <small>Jarak antar kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" value="0" class="form-control bbm" value="0" name="per_bbm[]" placeholder="Biaya BBM" id="bbm_1" type="text">
                                                                                            <small>Biaya BBM</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" value="0" class="form-control extol" placeholder="Biaya Tol" id="extol_1" name="tj_tol[]" type="text" >
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
                                                                                                <div class="col-md-4">
                                                                                                    <input value="1" min="1" placeholder="Durasi (hari)" id="dur_1" name="pk_dur[]" class="form-control dur"type="number">
                                                                                                    <small>Durasi (hari)</small>
                                                                                                </div>
                                                                                                <div class="col-md-4">
																								                                                                                                    <input type="text"  class="form-control bbm_old" name="pk_bbm[]" placeholder="Biaya BBM" id="bbm_dalam_1"  type="text">

                                                                                                    <input type="text" value="0" class="form-control tol" placeholder="Biaya Tol dalam kota" id="tol_1" name="kt_tol[]" type="text">
                                                                                                    <small>Biaya tol dalam kota</small>
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <input value="0" class="form-control parkir" placeholder="Biaya Parkir" name="kt_parkir[]" id="parkir_1" type="text">
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
                                                                <div id="kota_n">
                                                                        <article class="timeline-item">
                                                                            <div class="timeline-desk">
                                                                                <div class="timeline-box">
                                                                                    <span class="timeline-icon"><i class="mdi mdi-car"></i></span>
                                                                                    <h5 class="text-danger mb-1">Perjalanan pulang ke PT. Dahana</h5> <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <input class="form-control" value="0" placeholder="Jarak (Km)" id="per_jarak_n" name="tj_jarak[]" type="text">
                                                                                            <small>Jarak perjalanan pulang</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control"  placeholder="Biaya BBM" id="bbm_n" value="0" name="per_bbm[]" type="text">
                                                                                            <small>Biaya BBM</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control" placeholder="Biaya Tol " id="extol_n" value="0" name="tj_tol[]"  type="text" >
                                                                                            <small>Biaya tol antar kota</small>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" hidden value="{{$per_kota_n}}" id="kt_id_n">
                                                                                            <input autocomplete="off" placeholder="Nama kota" hidden id="per_tujuan_n" value="{{$kotawal}}" name="kt_nama[]" class="form-control per_tujuan" type="text">
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
                                                                                                    <input type="text" class="form-control tol" name="kt_tol[]" value="0" placeholder="Biaya Tol dalam" id="tol_n"  type="text">
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <input class="form-control" value="0" name="kt_parkir[]" value="0" placeholder="Biaya Parkir" id="parkir_n" type="text">
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
                                                            <!-- end timeline -->
                                                        </div> <!-- end col -->
                                                    </div>
                                                    </div>
                                                    <div class="tab-pane active" id="databiaya">
                                                    <div id="newBiaya">
                                                        <div class="form-group newB" id="b_1">
                                                            <label for="email" class="col-sm-4 control-label">Biaya Perjalanan</label>
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <input type="text" placeholder="Nama biaya" data-precision="0" data-thousands=" " data-prefix="Rp "  
                                                                        class="form-control" id="b_nama_1" name="b_nama[]" >
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
                                                                value="" maxlength="50" required="">
                                                                <h2 style="height: 60px; background-color: #dbdbdb; padding: 10px; text-align: right" id="tarif2"> @if($per_tarif!=0){{ number_format($per_tarif, '0', ',', '.')}}@else<em>tarif</em>@endif</h2>
                                                                <button type="submit" id="sbmt" style="display:none" class="btn btn-success float-right" ><span class="fe fe-paper-plane" ></span> Simpan</button>
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
                            </div> 
                        </div>
                    </div>
@endsection