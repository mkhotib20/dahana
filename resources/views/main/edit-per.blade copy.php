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
                                    <h4 class="page-title">Tambah Tujuan dalam perjalanan</h4>
                                </div>
                            </div>
                        </div>     

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <p>Rute perjalanan : Subang
                                            <?php
                                                 for ($i=0; $i < count($kota); $i++) { 
                                                        
                                                    echo ' - ';
                                                    echo $kota[$i];
                                                }
                                            ?>
                                        </p>
                                        <div class="col-md-8 offset-md-2">
                                        {{  Form::open(['route'=>'perjalanan.store', 'method'=>'POST']) }}
                                        <input type="text" value="{{$per_id}} " hidden name="per_id" id="per_id">
                                        <input type="text" value="{{$tj_kota_1}} " hidden id="kota_1" name="tj_kota_1">
                                        <select hidden class="form-control" id="per_kendaraan" name="per_kendaraan">
                                                    <option value="null" disabled selected>--pilih kendaraan--</option>
                                                @foreach ($kendaraan as $key => $value)
                                                    <option @if ($per_mobil==$value->ken_id) {{"selected"}} @endif value=" {{$value->ken_id}} "> {{$value->ken_merk}}</option>
                                                @endforeach
                                        </select> 
                                        <style>
                                            .newp, .newB{
                                                box-shadow: 0px 0px 5px;
                                                padding: 10px;
                                                padding-bottom: 20px;
                                            }
                                        </style>
                                    <div id="inpKota">
                                        <div class="form-group newp" id="kota_1">
                                            <label for="kota" class="col-sm-4 control-label">Kota Tujuan</label> 
                                           <div class="col-md-12">
                                            <small id="hint" style="color:red" ><em>Pilih kendaraan terlebih dahulu</em></small>
                                              <div class="row">
                                                  <div class="col-md-8">
                                                      <input type="text" hidden id="kt_id_1">
                                                      <input disabled autocomplete="off" placeholder="Nama kota" id="per_tujuan_1" class="form-control per_tujuan"  name="kt_nama[]" type="text">
                                                      <small>Kota</small>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <input disabled value="1" min="1" placeholder="Durasi (hari)" id="dur_1" name="pk_dur[]" class="form-control dur"type="number">
                                                      <small>Durasi</small>
                                                  </div>
                                                  <div class="col-md-2">
                                                    <a unselectable="on" style="cursor: pointer; color:white" class="btn btn-success disabled" id="addTj"> <i class="fe fe-plus"></i> Tujuan</a>
                                                  </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                  <div class="col-md-3">
                                                      <input disabled class="form-control jarak" placeholder="Jarak (Km)" id="per_jarak_1"  name="tj_jarak[]" type="text">
                                                      <small>jarak (km)</small>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <input disabled class="form-control bbm" name="per_bbm[]" placeholder="Biaya BBM" id="bbm_1"  type="text">
                                                      <small>Tarif BBm</small>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <input disabled class="form-control tol" placeholder="Biaya Tol" id="tol_1" name="kt_tol[]" data-precision="0" data-thousands="." data-prefix="Rp "  type="text">
                                                      <small>Tarif tol</small>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <input disabled class="form-control parkir" placeholder="Biaya Parkir" name="kt_parkir[]" id="parkir_1" type="text">
                                                      <small>Tarif parkir</small>
                                                  </div>
                                              </div>
                                              
                                          </div>                                          
                                        </div>
                                    </div>
                                    <div id="newBiaya">
                                        <div class="form-group newB" id="b_1">
                                            <label for="email" class="col-sm-4 control-label">Biaya Perjalanan</label>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="text" placeholder="Nama biaya" data-precision="0" data-thousands="." data-prefix="Rp "  
                                                        class="form-control"  name="b_nama[]" >
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" placeholder="Nominal" data-precision="0" data-thousands="." data-prefix="Rp "  
                                                        class="form-control rupiah"  name="b_nominal[]" id="b_nominal_1" >
                                                    </div>
                                                    <div class="col-md-2">
                                                    <a unselectable="on" style="cursor: pointer; color:white" class="btn btn-success " id="addBiaya"> <i class="fe fe-plus"></i> Biaya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                        <div class="form-group">
                                            <label for="karyawan" class="col-sm-4 control-label">Tarif Perjalanan</label>
                                            <div class="col-sm-6">
                                                <input type="text" hidden class="form-control" id="tarif" name="per_biaya" 
                                                 value="" maxlength="50" required="">
                                                 <h2 style="height: 60px; background-color: #dbdbdb; padding: 10px; text-align: center" id="tarif2"> <em>tarif</em></h2>
                                            </div>
                                            <div class="col-sm-6">
                                                <p style="color:#3277e6; cursor: pointer" id="genTarif">Hitung Tarif</p>
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" id="sbmt" style="display:none" class="btn btn-success float-right" ><span class="fe fe-paper-plane" ></span> Simpan</button>
                                            </div>
                                        </div>   
                                        {{  Form::close()  }}
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>                    
                    </div>

@endsection