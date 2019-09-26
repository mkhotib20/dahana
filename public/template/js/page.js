function getMainUrl($con,$id) {
  return '/dahana/'+$con+'/'+$id+'/edit'
}
var limit
var saldo
var gaga
var sopirReg
$.ajax({
  type: 'GET',
  url: '/dahana/json_saldo/',
  success: function(data) {
  ada = JSON.parse(data)
  limit = ada[0]
  saldo = ada[1]
  if (saldo >= limit) {
    $('#warn').html('<div class="bahaya" ><center><b>Penggunaan Biaya perjalanan dinas telah mencapai batas anggaran</b></center></div>')
  }
  else if(saldo/limit*100 >= 65 ){
    $('#warn').html('<div class="peringatan" ><center><b>Penggunaan biaya perjalanan dinas telah mencapai 65% dari anggaran</b></center></div>')
    
  }
  
  },
  error: function(){
  console.log('error')
  }
})
$(document).ready(function(){
  console.log(sopir)
  var autocomplete
  $.ajax({
    type: 'GET',
    url: '/dahana/perjalanan/json/',
    success: function(data) {
      ada = JSON.parse(data)
      autocomplete = ada
    },
    error: function(){
      console.log('error')
    }
  })
  
  $('body').on('click', '#sel_per', function () {
    per_id = $(this).data('id');
    $('#per_id').val(per_id)
    $('#kembalian').modal('show');
  })

  $('.rupiah').attr('data-precision', 0)
  $('.rupiah').attr('data-thousands', ' ')
  $('.rupiah').attr('data-prefix', 'Rp ')
  try {
    indexb = getIndex('.newB')
      var sumdur = 0
      var sopir = 0
      $.get( "/dahana/saku_json/", function( data ) {
        sopirReg = data
        sopir = sopirReg
        //alert(sopir)
      });
      for (let i = 0; i < indexb; i++) {
        var idx = parseInt(i)+1
        sumdur += parseInt($('#dur_'+idx).val()) || 0 
      } 
    
    $('#b_nama_1').val('Uang saku driver')
    $('#b_nominal_1').val(sopir*sumdur)
  } catch (error) {
    console.log(error)
  }
var parkir =0
var tol=0
var bbm=0
var dur=1
var kons=0
var bbmTar=0
var bbmDalam=10*bbm
  var selectedMobil = 0
  selectedMobil = $("#per_kendaraan").children("option:selected").val()
  if (selectedMobil!='null') {
    $('.newp').find('input').removeAttr('disabled')
    $('.newp').find('a').removeClass('disabled')
    $.ajax({
      type: 'GET',
      url: '/dahana/perjalanan/json_bbm/',
      data: {
          'mobil': selectedMobil
      },
      success: function(data) {
        ada = JSON.parse(data)
        bbm = parseInt(ada.bbm)   
        bbmDalam = 10*bbm
        $('.bbm_old').val(bbmDalam)   
        kons = parseInt(ada.kons)
        $('.jarak').trigger("input")
        console.log(bbm)
      },
      error: function(){
        console.log('error')
      }
    })
    $('#hint').remove()
  }
  $('.jarak').trigger("input")
  $('#per_kendaraan').change(function(){
    $('.newp').find('input').removeAttr('disabled')
    $('.newp').find('a').removeClass('disabled')
    $('#hint').remove()
  })
  $('#per_driver').change(function(){
	  if($(this).data('status') == 2){
		  sopir = 0
	  }else{
		  sopir = sopirReg
	  }
  })

$("#per_kendaraan").change(function(){
  selectedMobil = $("#per_kendaraan").children("option:selected").val()
  $.ajax({
    type: 'GET',
    url: '/dahana/perjalanan/json_bbm/',
    data: {
        'mobil': selectedMobil
    },
    success: function(data) {
      ada = JSON.parse(data)
      bbm = parseInt(ada.bbm)      
      bbmDalam = 10*bbm
      kons = parseInt(ada.kons)
      $('.jarak').trigger("input")
      $('#per_jarak_n').trigger("input")
      console.log(bbmDalam)
      $('#bbm_dalam_1').val(bbmDalam)
    },
    error: function(){
      console.log('error')
    }
  })
})
$(document).on('keypress', '.per_tujuan', function(){
  $('#bbm_n').val('0')
  $('#per_jarak_n').val('0')
  $('#extol_n').val('0')
  var kt_id_n = $('#kt_id_n').val()
  var id = $(this).parents('.newp').attr('id');
  var splitid = id.split('_');
  var index = splitid[1];
  if (index==1) {
    kota_1 = $('#kota_1').val()
    console.log(kota_1)
  }
  else{
    var befIn = index-1
    kota_1 = $('#kt_id_'+befIn).val()
    if (kota_1=='') {
      return
    }
  }
  try {
    $elem = $('#per_tujuan_'+index).autocomplete({
        source: function (request, response) {
          var term = $.ui.autocomplete.escapeRegex(request.term)
              , startsWithMatcher = new RegExp("^" + term, "i")
              , startsWith = $.grep(autocomplete, function(value) {
                  return startsWithMatcher.test(value.label || value.value || value);
              })
              , containsMatcher = new RegExp(term, "i")
              , contains = $.grep(autocomplete, function (value) {
                  return $.inArray(value, startsWith) < 0 &&
                      containsMatcher.test(value.label || value.value || value);
              });
  
          response(startsWith.concat(contains));
      },
        sortResults: false,
        select: function (event, ui) {
         
          $('#dur_'+index).val(1)
          dur = 1
          event.preventDefault();
          var selectedObj = ui.item
          var idktn = selectedObj['kt_id']
          $('#kt_id_'+index).val(idktn)
          $.ajax({
            type: 'GET',
            url: '/dahana/perjalanan/json_jarak/',
            data: {
                'kota_1': kota_1,
                'kota_2': selectedObj['kt_id'],
            },
            success: function(data) {
              ada = JSON.parse(data)
              var jarak = parseInt(ada[0]['tj_jarak'])
              var extol = parseInt(ada[0]['tj_tol'])
              var bbm1 = Math.round((bbm*((jarak/kons)))/1000)*1000
              bbmTar = parseInt(bbm1)
              $('#bbm_'+index).val(bbmTar).change()
              $('#per_jarak_'+index).val(jarak).change()
              $('#extol_'+index).val(extol).change()

            },
            error: function(){
              console.log('error')
            }
          })
          
          $.ajax({
            type: 'GET',
            url: '/dahana/perjalanan/json_jarak/',
            data: {
                'kota_1': idktn,
                'kota_2': kt_id_n,
            },
            success: function(data) {
              ada = JSON.parse(data)
              var jarak = parseInt(ada[0]['tj_jarak'])
              var extol = parseInt(ada[0]['tj_tol'])
              var bbm1 = Math.round((bbm*((jarak/kons)))/1000)*1000
              //bbmTar = parseInt(bbm1) + (parseInt(bbm)*10)
              
              $('#bbm_n').val(bbm1)
              $('#per_jarak_n').val(jarak)
              $('#extol_n').val(extol)

            },
            error: function(){
              console.log('error')
            }
          })
          //$('#per_jarak_'+index).val(selectedObj['data'])
          tol = selectedObj['kt_tol']
          parkir = selectedObj['kt_parkir']
          if (tol==NaN) {
            tol = 0
          }
          if (parkir==NaN) {
            parkir = 0
          }
          $(this).val(selectedObj['value']).change()
          $('#tol_'+index).val(tol).change()
          $('#parkir_'+index).val(parkir).change()
          
        }
    }),
    elemAutocomplete = $elem.data("ui-autocomplete") || $elem.data("autocomplete");
    if (elemAutocomplete) {
        elemAutocomplete._renderItem = function (ul, item) {
            var newText = String(item.value).replace(
                    new RegExp(this.term, "gi"),
                    "<span class='ui-state-highlight'>$&</span>");

            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<div> <span class='fe fe-location'></span> " + newText+"</div>")
                .appendTo(ul);
        };
    }
  } catch (error) {
    if (error instanceof TypeError) {
      console.log('gapapa')
    }
  }
})
$(document).on('change', '.dur', function(){
	if($(this).val()=='0'){
		$(this).val(1)
	}
  var id = $(this).parents('.newp').attr('id');
  var splitid = id.split('_');
  var index = splitid[1];
  dur = parseInt($(this).val()) 
  //sopir = sopir*dur
  nm = parseInt(index)-1
  befdur = parseInt($('#dur_'+nm).val()) || 0
  sumdur = dur+befdur
  console.log('sum='+sumdur)
  console.log(bbmTar)
  var newTol = dur*tol
  var newPar = dur*parkir
  bbmDalam = dur*bbmDalam
  $('#bbm_dalam_'+index).val(bbmDalam).change()
  $('#parkir_'+index).val(newPar).change()
  $('#tol_'+index).val(newTol).change()
})
// $(document).on('change', '.bbm', function(){
//   var id = $(this).parents('.newp').attr('id');
//   var splitid = id.split('_');
//   var index = splitid[1];
//   console.log(index)
//   bbmTar = parseInt($(this).val())-(10*bbm*(dur-1))
// })
$(document).on('change', '.tol', function(){
  tol = parseInt($(this).val())/dur
})
$(document).on('change', '.bbm_old', function(){
  bbmDalam = parseInt($(this).val())/dur
})

$(document).on('change', '.parkir', function(){
  parkir = parseInt($(this).val())/dur
})
$(document).on('input', '.jarak', function(){
  var id = $(this).parents('.newp').attr('id');
  var splitid = id.split('_');
  var index = splitid[1];
  console.log(index)
  jarak = parseInt($(this).val())
  bbmTar = Math.round((bbm*((jarak/kons)))) || 0
  $('#bbm_'+index).val(bbmTar)
  
})
$("#per_jarak_n").on('input', function(){
  jarak = parseInt($(this).val())
  bbmTar = Math.round(bbm*((jarak/kons))) || 0
  $('#bbm_n').val(bbmTar)
})

  $('body').on('blur', '.rupiah', function(){
    if ($(this).val()=="Rp 0") {
      $(this).val(0)
    }
  })
  $('body').on('focus', '.rupiah', function(){
    $(this).maskMoney()
  })
  $('#newBiaya').on('focus', '.rupiah', function(){
    $(this).maskMoney()
  })
  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#create-new-driver').click(function () {
            $('#btn-save').val("create-driver");
            $('#driverForm').trigger("reset");
            $('#userCrudModal').html("Tambah driver Baru");
            $('#myModal').modal('show');
        });
        $('body').on('submit', '#delete-driver', function(e){
            var form = this;
            e.preventDefault();
            swal({
              title: 'Hapus data ?',
              text: "Data driver terkait akan dihapus !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#c70616',
              confirmButtonText: 'Hapus'
            }).then((result) => {
              if (result.value) {
                return form.submit();
              }
            })
        });
        $('body').on('click', '#edit-bbm', function () {
            var bbm_id = $(this).data('id');
            var url = getMainUrl('bbm', bbm_id)
            //window.location.href = url
            $.get(url, function (data) {
                $('#userCrudModal').html("Edit Profil BBM");
                $('#bbmModal').modal('show');
                $('#bbm_id').val(data.bbm_id);
                $('#bbm_nama').val(data.bbm_nama);
                $('#bbm_harga').val(data.bbm_harga);
            })
        })


        $('#create-new-bbm').click(function () {
            $('#btn-save').val("create-bbm");
            $('#bbmForm').trigger("reset");
            $('#bbmCrudModal').html("Tambah bbm Baru");
            $('#bbmModal').modal('show');
        });
        $('body').on('submit', '#delete-bbm', function(e){
            var form = this;
            e.preventDefault();
            swal({
              title: 'Hapus data ?',
              text: "Seluruh data mobil yang terkait akan terhapus permanen !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#c70616',
              confirmButtonText: 'Hapus'
            }).then((result) => {
              if (result.value) {
                return form.submit();
              }
            })
        });
        $('body').on('click', '#edit-driver', function () {
            var dr_id = $(this).data('id');
            var url = getMainUrl('driver', dr_id)
            //window.location.href = url
            $.get(url, function (data) {
                $('#userCrudModal').html("Edit User");
                $('#myModal').modal('show');
                $('#dr_id').val(data.dr_id);
                $('#dr_nama').val(data.dr_nama);
                $('#dr_alamat').val(data.dr_alamat);
                $('#dr_hp').val(data.dr_hp);
            })
        });


        $('#create-new-ken').click(function () {
          $('#btn-save').val("create-ken");
          $('#kenForm').trigger("reset");
          $('#kenModelT').html("Tambah kendaraan Baru");
          $('#kenModel').modal('show');
      });
      $('body').on('submit', '#delete-ken', function(e){
          var form = this;
          e.preventDefault();
          swal({
            title: 'Hapus data ?',
            text: "Seluruh data perjalanan yang terkait akan dihapus permanen !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c70616',
            confirmButtonText: 'Hapus'
          }).then((result) => {
            if (result.value) {
              return form.submit();
            }
          })
      });
      $('body').on('click', '#edit-ken', function () {
          var ken_id = $(this).data('id');
          var url = getMainUrl('kendaraan', ken_id)
          //window.location.href = url
          $.get(url, function (data) {
              $('#kenModelT').html("Edit Kendaraan");
              $('#kenModel').modal('show');
              $('#ken_id').val(data.ken_id);
              $('#ken_merk').val(data.ken_merk);
              $('#ken_nopol').val(data.ken_nopol);
              $('#ken_bbm').val(data.ken_bbm)
              $('#ken_kat').val(data.ken_kat);
          })
      });


      $('body').on('click', '#edit-kat', function () {
        var kat_id = $(this).data('id');
        var url = getMainUrl('kategori', kat_id)
        //window.location.href = url
        $.get(url, function (data) {
            $('#katCrud').html("Edit Profil Kategori");
            $('#katModal').modal('show');
            $('#kat_id').val(data.kat_id);
            $('#kat_nama').val(data.kat_nama);
            $('#kat_cc').val(data.kat_cc);
            $('#kat_kons').val(data.kat_kons);
        })
    });


    $('#create-new-kat').click(function () {
        $('#btn-save').val("create-kat");
        $('#bbmForm').trigger("reset");
        $('#katCrud').html("Tambah bbm Baru");
        $('#katModal').modal('show');
    });
    $('body').on('submit', '#delete-kat', function(e){
        var form = this;
        e.preventDefault();
        swal({
          title: 'Hapus data ?',
          text: "Seluruh data mobil yang terkait akan terhapus permanene !",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#c70616',
          confirmButtonText: 'Hapus'
        }).then((result) => {
          if (result.value) {
            return form.submit();
          }
        })
    });
    $('body').on('click', '#edit-tj', function () {
        var kat_id = $(this).data('id');
        var url = getMainUrl('tujuan', kat_id)
        var switchas = document.querySelector('#tjs').checked
        $.get(url, function (data) {
            $('#katCrud').html("Edit Profil Kota Tujuan");
            $('#tjModal').modal('show');
            $('#tj_id').val(data.tj_id);
            $('#tj_kota').val(data.kt_nama);
            kota1 = data.tj_kota_1
            $('#kota_1').val(kota1);
            if (kota1=='2' && switchas == false) {
              $('#swt-val').text('Jakarta')
              $('#tjs').click()
            }
            else if (kota1=='0' && switchas == true) {
              $('#swt-val').text('Subang')
              $('#tjs').click()
            }
            $('#tj_jarak').val(data.tj_jarak);
            $('#tj_tol').val(data.kt_tol);
            $('#tj_ex_tol').val(data.tj_tol);
            $('#tj_parkir').val(data.kt_parkir);
        })
    });


    $('#create-new-tj').click(function () {
      var switchas = document.querySelector('#tjs').checked
        if (switchas==true) {
            $('#tjs').click()
        }
        $('#btn-save').val("create-tj");
        $('#tjForm').trigger("reset")
        $('#tjCrud').html("Tambah kota tujuan Baru");
        $('#tjModal').modal('show');
    });
    $('body').on('submit', '#delete-tj', function(e){
        var form = this;
        e.preventDefault();
        swal({
          title: 'Hapus data ?',
          text: "Seluruh data perjalanan yang terkait akan terhapus permanen !",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#c70616',
          confirmButtonText: 'Hapus'
        }).then((result) => {
          if (result.value) {
            return form.submit();
          }
        })
    })

    $('body').on('click', '#edit-uk', function () {
        var bbm_id = $(this).data('id');
        var url = getMainUrl('unit-kerja', bbm_id)
        //window.location.href = url
        $.get(url, function (data) {
            $('#ukCrud').html("Edit Profil Unit Kerja");
            $('#ukModal').modal('show');
            $('#uk_id').val(data.uk_id);
            $('#uk_nama').val(data.uk_nama)
        })
    })


    $('#create-new-uk').click(function () {
        $('#btn-save').val("create-uk");
        $('#ukForm').trigger("reset");
        $('#ukCrud').html("Tambah bbm Baru");
        $('#ukModal').modal('show');
    });
    $('body').on('submit', '#delete-uk', function(e){
        var form = this;
        e.preventDefault();
        swal({
          title: 'Hapus data ?',
          text: "Seluruh data karyawan yang terkait akan terhapus permanen !",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#c70616',
          confirmButtonText: 'Hapus'
        }).then((result) => {
          if (result.value) {
            return form.submit();
          }
        })
    });
  function getIndex(cls) {
    var lastname_id = $(cls).last().attr('id');
    var split_id = lastname_id.split('_');
    var index = Number(split_id[1]);
    return index
  }
  
  $('#tipe_per').change(function(){
    if ($(this).val()=='dir') {
      //$('#b_nama_1').val('-')
      //$('#b_nominal_1').val(0)
      sopir=0
    }
    else if($(this).val()=='reg'){
      sopir=sopirReg
    }
  })
  $('#printRekap').click(function(){
    $('#modal-range').modal('show');
  })
  $('#per_tgl_start').change(function(){
    if($('#tipe_per').val()=='dir'){
      date1  = $(this).datepicker('getDate')
      var day = date1.getDay()
      if(day=='0' || day=='6'){
        Swal.fire({
          type: 'info',
          title: 'Perhatian...',
          text: 'Anda memilih perjalanan direksi dan diluar hari kerja, harap masukkan uang saku driver!'
        })
        $('#b_nama_1').val("Uang saku driver direksi")
        $('#b_nominal_1').focus()
        uangsaku = 0
      }
      else{
        $('#b_nama_1').val('-')
        $('#b_nominal_1').val(0)
      }
    }
  })
  $('#b_nominal_1').change(function(){
    sopir =  parseInt($(this).val().replace('Rp ','').replace(/ /g,''))|| 0
  })
  $(document).on('change', '#tipe_per', function(){
    if ($('#tipe_per').val()=='reg') {
      $('#b_nama_1').val('Uang saku driver')
      $('#b_nominal_1').val(sopir*sumdur)
    }
    else if($('#tipe_per').val()=='dir'){
      date1  = $('#per_tgl_start').datepicker('getDate')
      var day = date1.getDay()
      if(day=='0' || day=='6'){
        Swal.fire({
          type: 'info',
          title: 'Perhatian...',
          text: 'Anda memilih perjalanan direksi dan diluar hari kerja, harap masukkan uang saku driver!'
        })
        $('#b_nama_1').val("Uang saku driver direksi")
        $('#b_nominal_1').focus()
        uangsaku = 0
      }
      else{
        $('#b_nama_1').val('-')
        $('#b_nominal_1').val(0)
      }
    }
  })
    $('#genTarif').click(function(e){
      formValidation(e)
      var sumbbm = 0
      var sumparkir = 0
      var sumtol = 0
      var sumextol = 0
      var sumb = 0
      var sumbt = 0
      var sumbbmpl = 0
      var sumextolpl = 0
      
      var rincian, isinya
      sumextolpl = parseInt($('#extol_n').val().replace('Rp ','').replace(/ /g,''))|| 0
      sumbbmpl = parseInt($('#bbm_n').val().replace('Rp ','').replace(/ /g,''))|| 0
      sumpl = sumbbmpl+sumextolpl
      indexp = getIndex('.newp')
      indexb = getIndex('.newB')
          
      var lastname_id = $('.newp').last().attr('id');
      var split_id = lastname_id.split('_');
      var index = Number(split_id[1]);
      //console.log(index)
      sumdur = 0
      for (let i = 0; i < index; i++) {
        nm = i+1  
        sumdur += parseInt($('#dur_'+nm).val())    
      }
      var sumBbmDalam = 0
      
      for (let i = 0; i < indexp; i++) {
        var idx = parseInt(i)+1
        sumbbm += parseInt($('#bbm_'+idx).val().replace('Rp ','').replace(/ /g,''))|| 0
        sumBbmDalam += parseInt($('#bbm_dalam_'+idx).val().replace('Rp ','').replace(/ /g,''))|| 0
        sumparkir += parseInt($('#parkir_'+idx).val().replace('Rp ','').replace(/ /g,''))|| 0
        sumtol += parseInt($('#tol_'+idx).val().replace('Rp ','').replace(/ /g,''))|| 0
        sumextol += parseInt($('#extol_'+idx).val().replace('Rp ','').replace(/ /g,''))|| 0
        
        /*rincian['parkir'] = sumparkir
        rincian['tol'] = sumtol*/
      } 
      $('#b_nominal_1').val(sopir*sumdur)
      rincian = [
        {nama: 'Tarif BBM Antar Kota',nominal: formatRupiah(sumbbm+sumbbmpl)}, 
        {nama: 'Tarif BBM Dalam Kota',nominal: formatRupiah(sumBbmDalam)}, 
        {nama: 'Tarif Tol', nominal: formatRupiah(sumextol+sumextolpl)},
        {nama: 'Tarif Tol Dalam Kota', nominal: formatRupiah(sumtol)},
        {nama: 'Tarif Parkir', nominal: formatRupiah(sumparkir)}, 
      ] 
      for (let i = 0; i < indexb; i++) {
        var idx = parseInt(i)+1
        sumb = parseInt($('#b_nominal_'+idx).val().replace('Rp ','').replace(/ /g,'')) || 0
        sumbt += parseInt($('#b_nominal_'+idx).val().replace('Rp ','').replace(/ /g,'')) || 0
        if (sumb!=0) {
          rincian[i+4] = {nama: $('#b_nama_'+idx).val(), nominal: formatRupiah(sumb)} 
        }
      }
     
      fullPrice = sumtol+sumbbm+sumbt+sumparkir+sumextol+sumpl
      fullPrice =  Math.round(fullPrice/1000)*1000
      
      saldo = parseInt(saldo) || 0
      fullPrice = parseInt(fullPrice) || 0
      limit = parseInt(limit) || 0
      gaga = fullPrice+saldo
      if (gaga>limit) {
        Swal.fire({
          type: 'warning',
          title: 'Error...',
          text: 'Biaya Total Perjalana anda melebihi batas anggaran '
        })
      }
      $('#tarif').val(fullPrice)
      nl = formatRupiah(fullPrice)
      $('#tarif2').text('Rp '+ nl)
      //$('#sbmt').show()
      isinya = '<table style="width: 100%" >'
      console.log(rincian)
      rincian.forEach(function(val){
        isinya += '<tr>' + '<td style="width: 60%">' +val['nama'] + '</td>' + '<td class="float-right">' +val['nominal'] + '</td>' + '<tr>'
      })
      isinya += '</table>'
      $('#rincian').html(isinya)
      /*var tarifawal = $('#per_kendaraan').val()
      var per_mobil = $('#per_kendaraan').val()
      var per_tujuan = $('#per_tujuan').val()
      var per_tgl_start = $('#per_tgl_start').val()
      var per_tgl_end = $('#per_tgl_end').val()
      var per_saku = $('#per_saku').val().replace('Rp ','').replace(',','')
      var per_hotel = $('#per_hotel').val().replace('Rp ','').replace(',','')
      var per_trans = $('#per_trans').val().replace('Rp ','').replace(',','')
      var jr = $("input[name='tjJarak\\[\\]']").map(function(){
        return $(this).val()
      }).get()
      var adt_jarak = arrSum(toInt(jr))
      //alert(adt_jarak)
      var hari = getRange(per_tgl_start, per_tgl_end)
      if (per_tgl_start=='' || per_tgl_end=='' ) {
        Swal.fire({
          type: 'error',
          title: 'Error...',
          text: 'Isi tanggal terlebih dahulu!'
        })
        return
      }
      console.log(hari)
      if (hari==null) {
        Swal.fire({
          type: 'error',
          title: 'Terjadi kesalahan...',
          text: 'Periksa kembali tanggal yang dimasukan!'
        })
      }
      else{
        $.ajax({
          type: 'GET',
          url: '/dahana/perjalanan/hitungTarif/',
          data: {
              'per_mobil': per_mobil,
              'per_tujuan': per_tujuan,
              'hari': hari,
              'adt_jarak':adt_jarak
          },
          success: function(rt) {
            var data = parseInt(rt)+parseInt(per_hotel)+parseInt(per_saku)+parseInt(per_trans)
            $('#tarif').val(data) 
            nl = formatRupiah(data)
            $('#tarif2').text(nl) 
            $('#sbmt').show()
            //alert(data)
          },
          error: function(data){
            Swal.fire({
              type: 'error',
              title: 'Error...',
              text: 'Harap lengkapi form!'
            })
          }
        })
      }*/
      
    })
    $('#addBiaya').click(function(){
      var lastname_id = $('.newB').last().attr('id');
      var split_id = lastname_id.split('_');
      var index = Number(split_id[1]) + 1;

      $('#newBiaya').append(
        '<div class="form-group newB" id="b_'+index+'">'+
            '<div class="col-sm-12">'+
                '<div class="row">'+
                    '<div class="col-md-5">'+
                        '<input type="text" placeholder="Nama biaya" id="b_nama_'+index+'" class="form-control"  name="b_nama[]" >'+
                   ' </div>'+
                   ' <div class="col-md-5">'+
                      '  <input type="text" placeholder="Nominal" data-precision="0" data-thousands=" " data-prefix="Rp "  '+
                      '  class="form-control rupiah"  name="b_nominal[]" id="b_nominal_'+index+'" >'+
               '     </div>'+
                '    <div class="col-md-2">'+
                 '    <a style="color: white" class="btn btn-danger hpsB" ><span class="fe fe-minus" ></span></a>'+
                 '   </div>'+
               ' </div>'+
          '  </div>'+
       ' </div> ')
    })
    $('body').on('submit', '#delete-per', function(e){
      var form = this;
      e.preventDefault();
      swal({
        title: 'Hapus data ?',
        text: "Data akan terhapus permanan !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c70616',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.value) {
          return form.submit();
        }
      })
  });
 
  $('body').on('click', '.hpsB', function(){
    $(this).parents('.form-group').remove()
  })
  $('body').on('click', '.hpsk', function(){
    $(this).parents('.newp').remove()
    var lastname_id = $('.newp').last().attr('id');
    var split_id = lastname_id.split('_');
    var index = Number(split_id[1]);
    console.log(index)
    $('html, body').animate({
      scrollTop: ($('#kota_'+index).offset().top)
    },500);
    idktn = $('#kt_id_'+index).val()
    console.log(idktn)
    $.ajax({
        type: 'GET',
        url: '/dahana/perjalanan/json_jarak/',
        data: {
            'kota_1': idktn,
            'kota_2': '0',
        },
        success: function(data) {
          ada = JSON.parse(data)
          var jarak = parseInt(ada[0]['tj_jarak'])
          var extol = parseInt(ada[0]['tj_tol'])
          bbmTar = Math.round(((bbm*((jarak/kons))))/1000)*1000
          
          $('#bbm_n').val(bbmTar)
          $('#per_jarak_n').val(jarak)
          $('#extol_n').val(extol)

        },
        error: function(){
          console.log('error')
        }
      })
  })
  $('#btamb').click(function(){
    var lastname_id = $('.newp').last().attr('id');
    var split_id = lastname_id.split('_');
    var index = Number(split_id[1]);
    //console.log(index)
    sumdur = 0
    for (let i = 0; i < index; i++) {
      nm = i+1  
      sumdur += parseInt($('#dur_'+nm).val())    
    }
    $('#b_nama_1').val('Uang saku driver')
    $('#b_nominal_1').val(sopir*sumdur)
    console.log(sumdur)
  })
  $('#create-new-karyawan').click(function () {
      $('#btn-save').val("create-karyawan");
      $('#karyawanForm').trigger("reset");
      $('#userCrudModal').html("Tambah karyawan Baru");
      $('#myModal').modal('show');
  });
  
  $('body').on('click', '#edit-karyawan', function () {
      var kar_id = $(this).data('id');
      var url = getMainUrl('karyawan', kar_id)
      //window.location.href = url
      $.get(url, function (data) {
          $('#userCrudModal').html("Edit Karyawan");
          $('#myModal').modal('show');
          $('#kar_id').val(data.kar_id);
          $('#kar_nama').val(data.kar_nama);
          $('#kar_email').val(data.kar_email);
          $('#kar_uk').val(data.kar_uk);
      })
  });
  
  $('body').on('submit', '#delete-kar', function(e){
    var form = this;
    e.preventDefault();
    swal({
      title: 'Hapus data ?',
      text: "Seluruh data perjalanan karyawan ini akan terhapus !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#c70616',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.value) {
        return form.submit();
      }
    })
});


$('#km_end').keyup(function(){
  var km_end = parseInt($(this).val())
  var km_start = parseInt($('#km_start').val())
  var jarak = km_end-km_start
  var kons_pasti = parseInt($(this).data('kons'))
  var bbm_pasti = parseInt($(this).data('bbm'))
  var bbm_pasti = Math.round(bbm_pasti*(jarak/kons_pasti)/1000)*1000 ||0
  if (bbm_pasti<=0) {
    bbm_pasti = 0
  }
  $('#bbm_pasti').text(formatRupiah(bbm_pasti)) 
})

  $('#create-new-user').click(function () {
    $('.form-group').show()
    $('#password').parents('.form-group').show();
    $('#btn-save').val("create-user");
    $('#userForm').trigger("reset");
    $('#userCrudModal').html("Tambah User Baru");
    $('#myModal').modal('show');
  });
  $('body').on('click', '#edit-user', function () {
    $('.form-group').show()
      var id = $(this).data('id');
      var url = getMainUrl('manajemen-user', id)
      //window.location.href = url
      $.get(url, function (data) {
          $('#userCrudModal').html("Edit User "+data.name);
          $('#myModal').modal('show');
          $('#id').val(data.id);
          $('#name').val(data.name);
          $('#password').parents('.form-group').hide();
          $('#password').removeAttr('required')
          $('#username').val(data.username);
          $('#role').val(data.role);
      })
  });
  $('body').on('click', '#edit-pass', function () {
    $('.form-group').hide()
    $('#password').parents('.form-group').show();
      var id = $(this).data('id');
      var url = getMainUrl('manajemen-user', id)
      //window.location.href = url
      $.get(url, function (data) {
        $('#userCrudModal').html("Reset password "+data.name);
          $('#myModal').modal('show');
          $('#id').val(data.id);
          $('#name').val(data.name);
          $('#username').val(data.username);
          $('#role').val(data.role);
      })
  });

  $('#formval').submit(function(e){
    e.preventDefault
    if(formValidation()== false){
      return false
    }
    if (gaga>limit) {
      
      Swal.fire({
        type: 'warning',
        title: 'Error...',
        text: 'Biaya Total Perjalana anda melebihi batas anggaran.  '
      })
      return false
    }
      
    

  })
  $(document).on('click', '.ada-error', function(){
    $(this).removeClass('ada-error')
  })
  $(document).on('change', '.ada-error', function(){
    $(this).removeClass('ada-error')
  })
  $('body').on('submit', '#delete-user', function(e){
    var form = this;
    e.preventDefault();
    swal({
      title: 'Hapus data ?',
      text: "Seluruh data user ini akan terhapus !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#c70616',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.value) {
        return form.submit();
      }
    })
});
})
function toInt(arr) {
  for (let index = 0; index < arr.length; index++) {
    arr[index] = parseInt(arr[index]);
  }
  return arr
}
function getRange(st, end) {
  hrS = st.substring(0,2)
  blS = st.substring(3,5)
  thS = st.substring(7)
  hrE = end.substring(0,2)
  blE = end.substring(3,5)
  thE = end.substring(7)
  switch (blS) {
    case '01':
      kons = 31
      break;
    case '03':
      kons = 31
      break;
    case '05':
      kons = 31
      break;
    case '07':
      kons = 31
      break;
    case '08':
      kons = 31
      break;
    case '10':
      kons = 31
      break;
    case '12':
      kons = 31
      break;
  
    default:
      kons = 30
      break;
  }
  if (thS==thE) {
    if (blS==blE) {
      var hr = hrE-hrS
    }
    else{
      bl = (blE-blS)*kons
      var hr = ((parseInt(bl)+parseInt(hrE))-hrS)
    }
  }
  if (hr<0) {
    hr=null
  }
  if (hr==0) {
    hr=1
  }
  return hr
}
function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))

    return false;
  return true;
}
function formatRupiah(angka){
  var prefix = ''
  var number_string = angka.toString(),
  split   		= number_string.split(','),
  sisa     		= split[0].length % 3,
  rupiah     		= split[0].substr(0, sisa),
  ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if(ribuan){
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}

function formValidation(){
  var retur
  var tp
  if($('#b_nominal_1').val()==''){
    $('#b_nominal_1').val(0)
  }
  $('.ada-error').removeClass('ada-error');
  $('#sbmt').show()
  $('#formval :input').each(function(){
    var input = $(this).val()
    if (input == null || input=='') {
      $('#sbmt').hide()
      Swal.fire({
        type: 'error',
        title: 'Error...',
        text: 'Harap lengkapi form!'
      })
      tp = $(this).parents('.tab-pane').attr('id') 
      $(this).addClass('ada-error')
      $(this).siblings(".select2-container").addClass('ada-error')
      retur = false
    }
    $('a[href="#'+tp+'"]').addClass('ada-error');
  })
  return retur 
}