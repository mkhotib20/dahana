@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Data Departemen</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body p-0">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-uk"><i class="fe fe-plus"></i> Departemen</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <th>#</th>
                                                <th>Nama Departemen</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->uk_nama}}</td>
                                                    <td> 
                                                    <div class="btn-group dropdown">
                                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)" id="edit-uk" data-id="{{ $value->uk_id }}" ><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                            {!!  Form::open( ['method'=>'DELETE', 'route'=>['unit-kerja.destroy', $value->uk_id], 'id' => 'delete-uk', 'style'=>'display:inline-block']) !!}
                                                                <button type="submit" style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
                                                            {!!  Form::close()  !!}
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
                    <div class="modal fade" id="ukModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ukCrud"></h4>
                    </div>
                    <div class="modal-body">
                    {{  Form::open(['route'=>'unit-kerja.store', 'method'=>'POST', 'id' => 'ukForm']) }}    
                        <input type="text" hidden name="bbm_id" id="bbm_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Nama Departemen</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="uk_nama" name="uk_nama" placeholder="Masukan Nama Departemen" value="" maxlength="50" required="">
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
