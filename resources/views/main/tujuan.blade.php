@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Profil Kota Tujuan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-tj"><i class="fe fe-plus"></i> Kota tujuan</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Dari </th>
                                                    <th>Ke</th>
                                                    <th>Jarak</th>
                                                    <th>Tarif Tol</th>
                                                    <th>Tarif Parkir</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="driver-crud">
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>@if($value->tj_kota_1==0){{'Subang'}} @else{{'Jakarta'}} @endif</td>
                                                    <td>{{$value->kt_nama}}</td>
                                                    <td>{{$value->tj_jarak}} Km</td>
                                                    <td>{{ 'Rp ' . number_format( $value->kt_tol, '2', ',', '.')}}</td>
                                                    <td>{{'Rp ' . number_format($value->kt_parkir, '2', ',', '.')}}</td>
                                                    <td>
                                                    <div class="btn-group dropdown">
                                                            <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)" id="edit-tj" data-id="{{ $value->tj_id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                    {{-- {!!  Form::open( ['method'=>'DELETE', 'route'=>['tujuan.destroy', $value->tj_id], 'id' => 'delete-tj', 'style'=>'display:inline-block']) !!} --}}
                                                                    {{-- <button type="submit" style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button> --}}
                                                                {{-- {!!  Form::close()  !!} --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>                    
                    </div>
                    <div class="modal fade" id="tjModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="tjCrud"></h4>
                    </div>
                    <div class="modal-body">
                    {{  Form::open(['route'=>'tujuan.store', 'method'=>'POST', 'id' => 'tjForm']) }}    
                        <input type="text" hidden name="tj_id" id="tj_id">
                                    <input type="text" id="kota_1" value="0" hidden name="tj_kota_1">
                            <div class="col-sm-12 switchery-demo">             
                                <label for="">Dari</label> <br>                                                 
                                <input type="checkbox" id="tjs" class="js-switch js-check-click" data-plugin="switchery" data-color="#039cfd"/>
                                <span id="swt-val">Subang</span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Nama Kota Tujuan</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="tj_kota" name="tj_kota" placeholder="Masukan Nama Kota" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Jarak Kota Tujuan</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="tj_jarak" name="tj_jarak" placeholder="Jarak dari kantor dahana (Km)" value="" onkeypress="return hanyaAngka(event)" maxlength="50" required="">
                                <!--<a id="genTj" href="#">Generate Jarak</a>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">Tarif Tol dari Subang</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control rupiah" id="tj_ex_tol" name="tj_ex_tol" placeholder="Masukkan tarif tol" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">Tarif Tol Dalam Kota</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control rupiah" id="tj_tol" name="tj_tol" placeholder="Masukkan tarif tol" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">Tarif Parkir</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control rupiah" id="tj_parkir" name="tj_parkir" placeholder="Masukkan tarif parkir" value="" maxlength="50" required="">
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan
                        </button>
                    </div>
                    {{  Form::close()  }}
                </div>
            </div>
        </div>
@endsection
