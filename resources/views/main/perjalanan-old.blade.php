@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">List Perjalanan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <table id="datatable-buttons" class="table table-striped nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nomor Surat</th>
                                                        <th>Kendaraan </th>
                                                        <th>Driver</th>
                                                        <th>Melayani</th>

                                                        <th>Tarif Perjalanan</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no =1; ?>
                                                @foreach ($perjalanan as $key => $value)
                                                    <tr>
                                                        <td>{{$no++}} </td>
                                                        <td>{{$value->per_no}} </td>
                                                        <td>{{$value->ken_merk}} </td>
                                                        <td>{{$value->dr_nama}}</td>
                                                        <td>{{$value->per_karyawan}}</td>
                                                        <td style="text-align: right" ><span class="float-left" >Rp</span> <span>{{number_format($value->per_biaya, '2', ',', '.') }}</span></td>
                                                        <td><a href="{{route('perjalanan.edit', $value->per_id)}}" class="btn btn-success">Ubah Perjalanan</a>
                                                        <a href="{{url('perjalanan/invoice/'.$value->per_no)}}" target="_blank" class="btn btn-warning">Cetak Invoice</a>  
                                                        {!!  Form::open( ['method'=>'DELETE', 'route'=>['perjalanan.destroy', $value->per_id], 'id' => 'delete-per', 'style'=>'display:inline-block']) !!}
                                                            <button type="submit" class="btn btn-danger" >Hapus</button>
                                                        {!!  Form::close()  !!}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group dropdown">
                                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#"><i class="mdi mdi-pencil mr-1 text-muted"></i>Edit Contact</a>
                                                                    <a class="dropdown-item" href="#"><i class="mdi mdi-delete mr-1 text-muted"></i>Remove</a>
                                                                    <a class="dropdown-item" href="#"><i class="mdi mdi-email mr-1 text-muted"></i>Send Email</a>
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
@endsection
