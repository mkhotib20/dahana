<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Aplikasi Dahana - Manajemen perjalanan dinas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Website untuk manajemen perjalanan dinas PT. Dahana" name="description" />
        <meta content="PT. Dahana" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public/icons/') }}/favicon.ico">
        
        <!-- App css -->
        <link href="{{ asset('public/template/') }}/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href=" {{ asset('public/template/css/icons.min.css') }} " rel="stylesheet" type="text/css" />

        <link href=" {{ asset('public/template/') }}/css/app.min.css " rel="stylesheet" type="text/css" />
        <link href=" {{ asset('public/template/') }}/css/feathericon.min.css " rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/template/') }}/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('public/template/') }}/css/jquery-ui.min.css">
        <link href="{{ asset('public/template/') }}/css/vendor/switchery.min.css" rel="stylesheet" type="text/css" />

        <style>
            .gbstmb{
                cursor: not-allowed;
                color: #dbdbdb!important;
            }
            .bahaya{
                padding: 4px; background-color: rgba(191,44,44); height: 30px; position: relative; z-index: 99999; color: white;
            }
            .peringatan{
                padding: 4px; background-color: rgba(232,214,44); height: 30px; position: relative; z-index: 99999; color: black;
            }
        </style>

    </head>
    
    
    <body>
        <div id="warn"></div>
    
    <div id="wrapper">

            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!-- LOGO -->
                    <a href="{{url('dashboard')}} " class="logo text-center mb-4">
                        <span class="logo-lg">
                            <img src="{{ asset('public/template/') }}/assets/images/logo.png" alt="" style="height: 40px">
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('public/template/') }}/assets/images/logo-sm.png" alt="" style="width: 100%">
                        </span>
                    </a>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Anda masuk sebagai <br> <b> @if(Auth::user()->role==0){{'Super Admin'}}@elseif(Auth::user()->role==2) {{'User reguler'}}@else {{'Admin'}} @endif</b></li>
                            <li>
                                <a href="{{url('dashboard')}} ">
                                    <i class="fe fe-activity"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe fe-map"></i>
                                    <span> Data Perjalanan </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{url('perjalanan')}}">Rekap Perjalanan</a>
                                    </li>
                                    @if(Auth::user()->role==1 || Auth::user()->role==0|| Auth::user()->role==3)
                                    <li>
                                        <a href="{{url('perjalanan/tambah')}}">Tambah Perjalanan</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @if(Auth::user()->role==1 || Auth::user()->role==0 || Auth::user()->role==3)
                            <li>
                                <a href="{{url('driver')}} ">
                                    <i class="fe fe-user"></i>
                                    <span> Data Driver </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('bbm')}} ">
                                    <i class="fe fe-cart"></i>
                                    <span> Data BBM </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe fe-user"></i>
                                    <span> Data Karyawan</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{url('karyawan')}}">Profil Karyawan</a>
                                    </li>
                                    <li>
                                        <a href="{{url('unit-kerja')}}">Profil Departemen</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe fe-car"></i>
                                    <span> Data Kendaraan </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{url('kendaraan')}}">List Kendaraan</a>
                                    </li>
                                    <li>
                                        <a href="{{url('kategori')}}">List Kategori dan CC</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{url('tujuan')}} ">
                                    <i class="fe fe-location"></i>
                                    <span> Data Kota tujuan </span>
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->role==0 || Auth::user()->role==3)
                            <li>
                                <a href="{{url('manajemen-user')}} ">
                                    <i class="fe fe-cart"></i>
                                    <span> Manajemen User </span>
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->role==1 || Auth::user()->role==0 || Auth::user()->role==3)
                            <li>
                                <a href="{{url('limit')}} ">
                                    <i class="fe fe-money"></i>
                                    <span> Anggaran Perjalanan Dinas </span>
                                </a>
                            </li><li>
                                <a href="{{url('ttd')}} ">
                                    <i class="fe fe-users"></i>
                                    <span> Tandatangan </span>
                                </a>
                            </li>
                            @endif

                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                
            </div>

            <div class="content-page">
                <div class="content">

                    <!-- Topbar Start -->
                    <div style=" height: 80px" class="navbar-custom">
                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                
                            <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="{{url('public/template')}}/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                                    <small class="pro-user-name ml-1">
                                        {{Auth::user()->name}}
                                    </small>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <!-- item-->
                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                        <i class="fe fe-logout"></i>
                                        <span>Logout</span>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </a>

                                </div>    
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                   
                                    
                                    <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe fe-gear"></i>
                                        <span>Settings</span>
                                    </a> -->

                                    
                                </div>
                            </li>

                        </ul>
                        <button class="button-menu-mobile open-left disable-btn">
                            <i class="fe fe-app-menu"></i>
                        </button>
                        
                    </div>
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    @yield('content')

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                &copy; 2019 - PT. Dahana
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>    

        
        <script src="{{ asset('public/template/') }}/js/vendor.js"></script>
        <script src="{{ asset('public/template/') }}/js/app.js"></script>

        <!-- Plugins js -->
        <script src="{{ asset('public/template/') }}/js/vendor/jquery.sparkline.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/jquery.knob.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
       
        <script src="{{ asset('public/template/') }}/js/vendor/sweetalert2.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/page.js"></script>
        <script src="{{ asset('public/template/') }}/js/notify.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/jquery.dataTables.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/dataTables.bootstrap4.js"></script>

        <script src="{{ asset('public/template/') }}/js/vendor/dataTables.responsive.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/responsive.bootstrap4.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/jquery-ui.min.js" ></script>
        
        <script src="{{ asset('public/template/') }}/js/vendor/dataTables.buttons.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/buttons.bootstrap4.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/buttons.html5.min.js"></script>

        <script src="{{ asset('public/template/') }}/js/vendor/dataTables.keyTable.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/vendor/dataTables.select.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/pages/datatables.init.js"></script>
        <script src="{{ asset('public/template/') }}/js/inputmask.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/jquery.inputmask.min.js"></script>
        <script src="{{ asset('public/template/') }}/js/inputmask.binding.js"></script>
        <script src="{{ asset('public/template/') }}/js/autocomplete.min.js"></script>
        <script src="{{ asset('public/') }}/js/form.js"></script>

        <script src="{{ asset('public/template/') }}/js/jquery.maskMoney.min.js"></script>   
        <script src="{{ asset('public/template/') }}/js/vendor/switchery.min.js"></script>

            <script>
                
                var elem = document.querySelector('#swt') || document.querySelector('#tjs')
                var init = new Switchery(elem, { color: '#4287f5', secondaryColor: '#34c73b', jackColor: '#fff', jackSecondaryColor: '#fff' });
                var off = $('#swt-val').text()
                var on
                if (off == 'Subang') {
                    on = 'Jakarta'   
                }
                else{
                    on = 'Subang'
                }
                var val 
                var kota1 = 0
                $('#swt').change(function(){
                    val = on
                    on = off
                    off = val
                    $('#swt-val').text(val);
                    if (val == 'Jakarta') {
                        kota1 = 2
                    }
                    else if(val=='Subang'){
                        kota1 = 0
                    }
                    $('#kota_1').val(kota1).change()
                    $('#kota_n').find('input').val('0')
                    $('#kt_id_n').val(kota1).change()
                    $('#per_tujuan_n').val(val).change()
                    $('.tujubaru').remove()
                    $('.newp').find('input').val('')
                    Swal.fire({
                    type: 'info',
                    title: 'Perhatian...',
                    text: 'Anda mengganti keberangkatan harap isi kembali form yang ada!'
                    })
                })
                
                $('#tjs').change(function(){
                    val = on
                    on = off
                    off = val
                    $('#swt-val').text(val);
                    if (val == 'Jakarta') {
                        kota1 = 2
                    }
                    else if(val=='Subang'){
                        kota1 = 0
                    }
                    $('#kota_1').val(kota1).change()
                    
                })
                
            </script>

        <script>
            var date = $('.datePick').datepicker({ 
                hideIfNoPrevNext: true,
                dateFormat: 'dd-mm-yy',
                dayNames: ["Minggu", "Senin", "Senin", "Rabu", "Kamis", "Jumat", "Sabtu" ],
                dayNamesMin: [ "Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ],
                monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ],
                monthNames: [ "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nop", "Des" ]
            }).val();
            
 
        </script>
@if (Session::get('sukses'))
<script>
    msg = " {{Session::get('sukses')}} "
    
    $.notify(msg, 'success');
</script>
@endif
@if (Session::get('error'))
<script>
    msg = " {{Session::get('error')}} "
    Swal.fire({
        type: 'warning',
        title: 'Perhatian...',
        text: msg
    })
</script>
@endif

    </body>
</html>
