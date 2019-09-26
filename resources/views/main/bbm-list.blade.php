@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Profil BBM</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body p-0">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-bbm"><i class="fe fe-plus"></i> BBM</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <th>#</th>
                                                <th>Nama BBM</th>
                                                <th>Harga</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $no =1; ?>
                                                @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->bbm_nama}}</td>
                                                    <td class="text-left">{{'Rp ' . number_format($value->bbm_harga, '2', ',', '.')}}</td>
                                                    <td>
                                                    
                                                    <div class="btn-group dropdown">
                                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"  href="javascript:void(0)" id="edit-bbm" data-id="{{ $value->bbm_id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                            
                                                            {!!  Form::open( ['method'=>'DELETE', 'route'=>['bbm.destroy', $value->bbm_id], 'id' => 'delete-bbm', 'style'=>'display:inline-block']) !!}
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
                    <div class="modal fade" id="bbmModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="bbmCrudModal"></h4>
                                </div>
                                <div class="modal-body">
                                {{  Form::open(['route'=>'bbm.store', 'method'=>'POST', 'id' => 'bbmForm']) }}    
                                    <input type="text" hidden name="bbm_id" id="bbm_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Nama BBM</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="bbm_nama" name="bbm_nama" placeholder="Masukan Nama BBM" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-4 control-label">Harga BBM</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control rupiah" id="bbm_harga" name="bbm_harga" placeholder="Masukkan harga BBM" value="" maxlength="50" required="">
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
