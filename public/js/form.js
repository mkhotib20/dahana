$(document).ready(function () {
  var lastname_id = $('.newp').last().attr('id');
  var split_id = lastname_id.split('_');
  var index = Number(split_id[1]);
  for (let i = 0; i < index; i++) {
      $('#dur_'+i).val()      
  }
  $('#addKota').click(function(){
    var lastname_id = $('.newp').last().attr('id');
    var split_id = lastname_id.split('_');
    var index = Number(split_id[1]);

    var bbmOld = $('#bbm_dalam_1').val()
    
    index = index+1
    parkir = 0
    tol = 0
    $("#kota").append(
      '<div class="newp tujubaru" id="kota_'+index+'">'+
          '<article class="timeline-item">'+
              '<div class="timeline-desk">'+
                  '<div class="timeline-box perj-box">'+
                      '<span class="timeline-icon"><i class="mdi mdi-car"></i></span>'+
                      '<h5 class="text-danger mb-1">Biaya Perjalanan </h5> <br>'+
                      '<div class="row">'+
                          '<div class="col-md-3">'+
                          '<input type="text" hidden id="kt_id_'+index+'">'+
                              '<input autocomplete="off" placeholder="Nama kota" id="per_tujuan_'+index+'" class="form-control per_tujuan"  name="kt_nama[]" type="text">'+
                              ' <small>Nama Kota</small>'+
                          '</div>'+
                          '<div class="col-md-3">'+
                              '<input class="form-control jarak" placeholder="Jarak (Km)" id="per_jarak_'+index+'"  name="tj_jarak[]" type="text">'+
                              '<small>Jarak antar kota</small>'+
                          '</div>'+
                          '<div class="col-md-3">'+
                              '<input type="text"  class="form-control bbm" name="per_bbm[]" placeholder="Biaya BBM" id="bbm_'+index+'"  type="text">'+
                              '<small>Biaya BBM</small>'+
                          '</div>'+
                          '<div class="col-md-3">'+
                              '<input type="text" class="form-control extol" placeholder="Biaya Tol" id="extol_'+index+'" name="tj_tol[]" type="text">'+
                              '<small>Biaya tol antar kota</small>'+
                          '</div>'+
                      '</div>'+
                  '</div>'+
              '</div>'+
          '</article>'+
          '<article class="timeline-item">'+
              '<div class="timeline-desk">'+
                  '<div class="timeline-box kota-box">'+
                      '<span class="timeline-icon"><i class="mdi mdi-pin"></i></span>'+
                      '<h5 class="text-danger mb-1">Biaya dalam kota </h5> <br>'+
                      '<div class="row">'+
                          '<div class="col-md-10">'+
                              '<div class="row">'+
                                  '<div class="col-md-3">'+
                                      '<input value="1" min="1" placeholder="Durasi (hari)" id="dur_'+index+'" name="pk_dur[]" class="form-control dur"type="number">'+
                                      '<small>Durasi (hari)</small>'+
                                  '</div>'+
                                  '<div class="col-md-3">'
                                     +' <input type="text" value="'+bbmOld+'" class="form-control bbm_old" name="pk_bbm[]" placeholder="Biaya BBM" id="bbm_dalam_'+index+'"  type="text">'
                                     +' <small>Biaya BBM Dalam Kota</small>'+
                                  '</div>'+
                                  '<div class="col-md-3">'+
                                      '<input type="text" class="form-control tol" placeholder="Biaya Tol dalam kota" id="tol_'+index+'" name="kt_tol[]" type="text">'+
                                      '<small>Biaya tol dalam kota</small>'+
                                  '</div>'+
                                  '<div class="col-md-3">'+
                                      '<input class="form-control parkir" placeholder="Biaya Parkir" name="kt_parkir[]" id="parkir_'+index+'" type="text">'+
                                      '<small>Biaya parkir</small>'+
                                  '</div>'+
                              '</div>'+
                          '</div>'+
                          '<div class="col-md-2">'+
                              '<a class="btn btn-danger hpsk btn-rounded float-right del-kota"><span class="fe fe-trash"></span></a>'+
                          '</div>'+
                      '</div>'+
                  '</div>'+
              '</div>'+
          '</article>'+
      '</div>'
    )
    $('html, body').animate({
        scrollTop: ($('#kota_'+index).offset().top)
    },500);
  })




})