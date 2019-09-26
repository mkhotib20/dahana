@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Karyawan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-karyawan"><i class="fe fe-plus"></i> Karyawan</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Alamat Email</th>
                                                    <th>Unit Kerja</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="karyawan-crud">
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->kar_nama}}</td>
                                                    <td>{{$value->kar_email}}</td>
                                                    <td>{{$value->uk_nama}}</td>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)" id="edit-karyawan" data-id="{{ $value->kar_id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                                {{-- {!!  Form::open( ['method'=>'DELETE', 'route'=>['karyawan.destroy', $value->kar_id], 'id' => 'delete-kar']) !!} --}}
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
                    <div class="modal fade" id="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="userCrudModal"></h4>
                    </div>
                    <div class="modal-body">
                    {{  Form::open(['route'=>'karyawan.store', 'method'=>'POST', 'id' => 'karyawanForm']) }}    
                        <input type="text" hidden name="kar_id" id="kar_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Nama Karyawan</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="kar_nama" name="kar_nama" placeholder="Masukan Nama karyawan" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Alamat Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="kar_email" name="kar_email" placeholder="Masukkan alamat Email" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">Unit Kerja</label>
                                <div class="col-sm-12">
                                    <select style="width: 100%" required name="kar_uk" id="kar_uk" class="form-control">
                                        <option selected disabled>--pilih unit kerja--</option>
                                        @foreach ($uk as $key => $value)
                                            <option value="{{$value->uk_id}}"> {{$value->uk_nama}}</option>
                                        @endforeach
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
