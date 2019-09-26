@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Kendaraan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">

                                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-ken"><i class="fe fe-plus"></i> Kendaraan</a> 
                                        <table id="basic-datatable" class="table nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Merk Kendaraan</th>
                                                    <th>Nopol Kendaraan</th>
                                                    <th>CC Kendaraan</th>
                                                    <th>Kategori Kendaraan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no =1; ?>
                                                @foreach ($kend as $key => $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$value->ken_merk}}</td>
                                                    <td>{{$value->ken_nopol}}</td>
                                                    <td>{{$value->kat_cc}}</td>
                                                    <td>{{$value->kat_nama}}</td>
                                                    <td>
                                                    <div class="btn-group dropdown">
                                                            <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)" id="edit-ken" data-id="{{ $value->ken_id }}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit</a>
                                                                @if($value->ken_id != 5) 
                                                                {!!  Form::open( ['method'=>'DELETE', 'route'=>['kendaraan.destroy', $value->ken_id], 'id' => 'delete-ken', 'style'=>'display:inline-block']) !!}
                                                                    <button type="submit" style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
                                                                {!!  Form::close()  !!}
                                                                @endif
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
                    <div class="modal fade" id="kenModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="kenModelT"></h4>
                    </div>
                    <div class="modal-body">
                    {{  Form::open(['route'=>'kendaraan.store', 'method'=>'POST', 'id' => 'kenForm']) }}    
                        <input type="text" hidden name="ken_id" id="ken_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Merk Kendaraan</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="ken_merk" name="ken_merk" placeholder="Masukan Merk Kendaraan" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-4 control-label">Nopol Kendaraan</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="ken_nopol" name="ken_nopol" placeholder="Masukkan nopool kendaraan" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">CC Kendaraan</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="ken_kat" name="ken_kat" >
                                    @foreach ($kat as $key => $value)
                                        <option value="{{$value->kat_id}}">{{$value->kat_nama}} || CC : {{$value->kat_cc}} </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp" class="col-sm-4 control-label">BBM kendaraan</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="ken_bbm" name="ken_bbm" >
                                    @foreach ($bbm as $key => $value)
                                        <option value="{{$value->bbm_id}}">{{$value->bbm_nama}} </option>
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
