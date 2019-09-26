@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">List Driver</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-header">Setting uang saku driver</div>
                                    <div class="card-body">
                                            <form action=" {{url('saku')}} " method="POST">    
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                            <label for="">Masukkan uang saku</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input value=" {{$saku}} " type="text" class="form-control rupiah" name="saku">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="submit" value="Simpan" class="btn btn-info btn-block">
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-driver"><i class="fe fe-plus"></i> Driver</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Driver</th>
                                                    <th>Alamat Driver</th>
                                                    <th>No HP Driver</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="driver-crud">
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->dr_nama}}</td>
                                                    <td>{{$value->dr_alamat}}</td>
                                                    <td>{{$value->dr_hp}}</td>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"  href="javascript:void(0)" id="edit-driver" data-id="{{ $value->dr_id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                                
                                                                {!!  Form::open( ['method'=>'DELETE', 'route'=>['driver.destroy', $value->dr_id], 'id' => 'delete-driver', 'style'=>'display:inline-block']) !!}
                                                                    <button type="submit"  style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
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
                    <div class="modal fade" id="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="userCrudModal"></h4>
                    </div>
                    <div class="modal-body">
                    {{  Form::open(['route'=>'driver.store', 'method'=>'POST', 'id' => 'driverForm']) }}    
                        <input type="text" hidden name="dr_id" id="dr_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Nama Driver</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="dr_nama" name="dr_nama" placeholder="Masukan Nama Driver" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Alamat Driver</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="dr_alamat" name="dr_alamat" placeholder="Masukkan alamat driver" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">No HP Driver</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="dr_hp" name="dr_hp" placeholder="Masukkan No HP driver" value="" maxlength="50" required="">
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
