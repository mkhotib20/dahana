@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">List Kategori</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body p-0">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-kat"><i class="fe fe-plus"></i> Kategori</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <th>#</th>
                                                <th>Nama Kategori</th>
                                                <th>CC</th>
                                                <th>Konstanta</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->kat_nama}}</td>
                                                    <td>{{$value->kat_cc}}</td>
                                                    <td>{{$value->kat_kons}}</td>
                                                    <td>
                                                    <a href="javascript:void(0)" id="edit-kat" data-id="{{ $value->kat_id }}" class="btn btn-light">Edit</a> 
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
                    <div class="modal fade" id="katModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="katCrud"></h4>
                                </div>
                                <div class="modal-body">
                                {{  Form::open(['route'=>'kategori.store', 'method'=>'POST', 'id' => 'bbmForm']) }}    
                                    <input type="text" hidden name="kat_id" id="kat_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Nama Kategori</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kat_nama" name="kat_nama" placeholder="Masukan Nama Kategori" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-4 control-label">Kategori CC</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kat_cc" name="kat_cc" placeholder="Masukkan CC " value="" maxlength="50" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-4 control-label">Konstanta</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="kat_kons" name="kat_kons" value="10" maxlength="50" required="">
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
