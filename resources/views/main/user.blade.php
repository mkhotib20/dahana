@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Manajemen User</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-user"><i class="fe fe-plus"></i> User</a> 
                                        <div class="table-responsive">
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama user</th>
                                                    <th>Username</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="user-crud">
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->username}}</td>
                                                    <td>{{$value->role}}</td>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)" id="edit-user" data-id="{{ $value->id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" id="edit-pass" data-id="{{ $value->id }}"><i class="mdi mdi-key mr-1 text-muted"></i>Reset Password</a>
                                                                {!!  Form::open( ['method'=>'DELETE', 'route'=>['manajemen-user.destroy', $value->id], 'id' => 'delete-user']) !!}
                                                                    <button type="submit" style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
                                                                {!!  Form::close()  !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
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
                    {{  Form::open(['route'=>'manajemen-user.store', 'method'=>'POST', 'id' => 'userForm']) }}    
                        <input type="text" hidden name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Nama user</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama user" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Kata sandi</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">Pilih Role</label>
                                <div class="col-sm-12">
                                    <select style="width: 100%" required name="role" id="role" class="form-control">
                                        <option value="1" > 1 | Admin | Mendapat hak akses penuh</option>
                                        <option value="2" > 2 | User reguler | Hanya bisa melihat rekap</option>
                                    </select>
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
