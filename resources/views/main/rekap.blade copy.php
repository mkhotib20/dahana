
        <link href="{{ asset('public/template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    @media print{@page {size: A4 landscape; margin: 0; }}
            *{
                font-family: 'Times New Roman';
            }
            table{
                font-size: 13px;
            }
            .date{
                background-color: white!important;
                cursor: pointer;
            }
            h4{
                font-weight: unset;
            }
        </style>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <center>
                                        <h2 class="page-title">Rekap Perjalanan PT. Dahana</h2>
                                        <h4>Rentang tanggal : {{$range}} </h4>
                                    </center>
                                </div>
                            </div>
                        </div>     

                        <div class="row">
                            <div class="col-xl-12">
                                <div>
                                    <div class="card-body row">
                                        <div class="col-md-12">
                                           <table class="table table-striped nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nomor Surat</th>
                                                        <th>Kendaraan </th>
                                                        <th>Driver</th>
                                                        <th>Melayani</th>
                                                        <th>Keberangkatan</th>
                                                        <th>Kota Tujuan </th>
                                                        <th>Tarif Perjalanan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no =1; 
                                                    for ($i=0; $i < count($perjalanan); $i++) {
                                                        $value = $perjalanan[$i];
                                                        $val_kota = $kota[$i];
                                                ?>
                                                    <tr>
                                                        <td>{{$no++}} </td>
                                                        <td>{{$value['per_no']}} </td>
                                                        <td><b>{{$value['ken_merk']}}</b> <br> <small>{{$value['ken_nopol']}}</small></td>
                                                        <td>{{$value['dr_nama']}}</td>
                                                        <td>{{$value['per_pengaju']}}</td>
                                                        <td> <b>{{$value['per_tgl_start']}}</b> <br> <small>{{$value['per_jam']}}</small></td>
                                                        <td><?php
                                                            for ($j=0; $j < count($val_kota); $j++) { 
                                                                if ($val_kota[$j]!='Subang') {
                                                                    echo $val_kota[$j];
                                                                    echo ' <br> ';
                                                                    
                                                                }
                                                                
                                                            }
                                                        ?></td>
                                                        <td style="text-align: right" ><span class="float-left" >Rp</span> <span>{{number_format($value['per_biaya'], '2', ',', '.') }}</span></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                           </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>                    
                    </div>
                    <script>
                        window.print()
                        window.close()
                    </script>