@extends('main.template')

@section('content')
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Atur nama yang bertandatangan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-6 ">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                        {{  Form::open(['route'=>'ttd.store', 'method'=>'POST']) }}    
                                        <?php $i = 1 ?>    
                                        @foreach($data as $key => $val)
                                            
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Jabatan {{$i++}}</label>
                                                <input class="form-control" type="text" value="{{$val->jabatan}}" name="jabatan[]"> <br>
                                                <input type="hidden" value="{{$val->id}}" name="id[]">
                                                <select required name="nama[]" class="form-control select2" data-toggle="select2">
                                                    
                                                    @foreach ($kar as $key => $value)
                                                        <option <?php if($value->kar_nama == $val->nama){echo 'selected';} ?> value="{{$value->kar_nama}}"> {{$value->kar_nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endforeach
                                            <div class="form-group">
                                                <input type="submit" value="Simpan" class="btn btn-primary">
                                            </div>
                                        </div>
                                        {{  Form::close()  }}
                                    </div> <!-- end card-body-->
                                </div>
                                <div class="col-xl-6 ">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                    <form action=" {{url('ttd/saveEmail')}} " method="POST">    
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Email pemberitahuan mencapai anggaran akan dikirim ke :</label>
                                                <select required name="email" class="form-control select2" data-toggle="select2">
                                                    @foreach ($kar as $key => $value)
                                                        <option value="{{$value->kar_email}}"> {{$value->kar_nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Simpan" class="btn btn-primary">
                                            </div>
                                        </div>
                                       </form>
                                       <br>
                                       <table class="table table-hovered table-striped">
                                           <thead>
                                               <tr>
                                                   <th>Alamat Email</th>
                                                   <th>Action</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                           @foreach ($email as $key => $value)
                                               <tr>
                                                   <td> {{$value->email}} </td>
                                                   <td> {!!  Form::open( ['method'=>'DELETE', 'route'=>['ttd.destroy', $value->id], 'id' => 'delete-ken', 'style'=>'display:inline-block']) !!}
                                                                    <button type="submit" style="cursor: pointer" class="dropdown-item" ><i class="mdi mdi-delete mr-1 text-muted"></i>Hapus</button>
                                                                {!!  Form::close()  !!} </td>
                                               </tr>
                                            @endforeach
                                           </tbody>
                                       </table>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end card-->
                            </div>
                             <!-- end col-->
                        </div>                    
                    </div>
@endsection
