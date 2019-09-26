@extends('main.template')

@section('content')
        <style>
            .date{
                background-color: white!important;
                cursor: pointer;
            }
        </style>
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
                                    <div class="card-body row">
                                        <div class="col-md-12">
                                        <form action=" {{url('perjalanan/cetak-rekap')}} " target="_blank" method="POST">    
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group row">    
                                                <div class="col-sm-3">
                                                    <select name="uk" class="form-control select2" data-toggle="select2">
                                                            <option value="0">Semua departemen</option>
                                                        @foreach ($uk as $key => $value)
                                                            <option value=" {{$value->uk_id}} "> {{$value->uk_nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>   
                                                <div class="col-sm-3">
                                                    <input type="text" readonly class="form-control date" id="singledaterange" data-toggle="date-picker" data-cancel-class="btn-warning" name="range">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-success"><span class="fe fe-print"></span> Print Rekap</button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>    
                                        <div class="col-md-12">
                                           <div class="table-responsive">
                                           <table id="basic-datatable" class="table table-striped nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>#</th>
                                                        <th>Nomor Surat</th>
                                                        <th>Kendaraan </th>
                                                        <th>Status Perjalanan</th>
                                                        <th>Melayani</th>
                                                        <th>Departemen</th>
                                                        <th>Keberangkatan</th>
                                                        <th>Kota Tujuan </th>
                                                        <th>Tarif Perjalanan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no =1; 
                                                    for ($i=0; $i < count($perjalanan); $i++) {
                                                        if(!empty($perjalanan[$i])){
														$value = $perjalanan[$i];
                                                        $val_kota = (empty($kota[$i])) ? array('') : $val_kota = $kota[$i] ;
                                                ?>
                                                    <tr>
                                                    <td>
                                                            <div class="btn-group dropdown">
                                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <?php
                                                                        if ($value['per_status']==0) {
                                                                            ?>
                                                                            <a class="dropdown-item" href="{{route('perjalanan.edit', $value['per_id'])}}"><i class="mdi mdi-pencil mr-1 text-muted"></i>Tambah Rute/Hari</a>
                                                                            <a class="dropdown-item" href="{{url('perjalanan/editBiaya/'.$value['per_id'])}} "><i class="mdi mdi-pencil mr-1 text-muted"></i>Tambah Biaya</a>      
                                                                    <a class="dropdown-item" data-id=" {{$value['per_id']}} " href="{{url('perjalanan/selesai/'.$value['per_no'])}}"><i class=" mdi mdi-check-all mr-1 text-muted"></i>Perjalanan Selesai</a>  
                                                                            <?php
                                                                        }

                                                                    ?>
                                                                    
                                                                    {!!  Form::open( ['method'=>'DELETE', 'route'=>['perjalanan.destroy', $value['per_id']], 'id' => 'delete-per', 'style'=>'display:inline-block']) !!}
                                                                        <button type="submit" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
                                                                    {!!  Form::close()  !!}
                                                                    <?php
                                                                        if ($value['per_status']==1) {
                                                                            ?><a class="dropdown-item" href="{{url('perjalanan/adjusment/'.$value['per_no'])}}" target="_blank"><i class="mdi mdi-printer mr-1 text-muted"></i>Cetak Adjustment</a><?php
                                                                        }
                                                                        
                                                                    ?>
                                                                    <a class="dropdown-item" href="{{url('perjalanan/invoice/'.$value['per_no'])}}" target="_blank"><i class="mdi mdi-printer mr-1 text-muted"></i>Cetak invoice</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{$no++}} </td>
                                                        <td>{{$value['per_no']}} </td>
                                                        <td><b>{{$value['ken_merk']}}</b> <br> <small>{{$value['ken_nopol']}}</small></td>
                                                        <td>
                                                            <?php
                                                                if ($value['per_status']==1) {
                                                                    echo 'Selesai';
                                                                }else{
                                                                    echo 'Dalam perjalanan';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>{{$value['kar_nama']}}</td>
                                                        <td>{{$value['uk_nama']}}</td>
                                                        <td> <b>{{$value['per_tgl_start']}}</b> <br> <small>{{$value['per_jam']}}</small></td>
                                                        <td><?php
                                                           $tmp = '';
                                                            for ($j=0; $j < count($val_kota)-1; $j++) { 
                                                                if(!empty($val_kota) && $val_kota[$j] != $tmp){
																		echo $val_kota[$j];
																		echo ' <br> ';																		
																	}
                                                                //$tmp = $val_kota[$j];
                                                            }
                                                        ?></td>
                                                        <td style="text-align: right" ><span class="float-left" >Rp</span> <span>{{number_format($value['per_biaya'], '2', ',', '.') }}</span></td>
                                                        
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                           </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>                    
                    </div>
                    
                    <div class="modal fade" id="kembalian" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Masukkan kelebihan biaya</h4>
                                </div>
                                <div class="modal-body">
                               <form action=" {{url('perjalanan/selesai')}} " method="POST">    
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" id="per_id" name="per_id" >
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-4 control-label">Jumlah kembalian</label>
                                            <div class="col-sm-12">
                                                <input type="text" value="0" class="form-control rupiah" name="kembalian" placeholder="Masukkan harga BBM" maxlength="50">
                                                    <small>Masukkan kelebihan biaya, biarkan kosong pabila tidak ada</small>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (Session::get('print'))
                    <script>
                    msg = "{{Session::get('print')}}"
                    url = "{{url('perjalanan/invoice/')}}/"+msg
                    window.open(url, '_blank')
                    </script>
                    @endif()
                    
                    
@endsection
