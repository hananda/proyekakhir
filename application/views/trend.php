<link href="<?php echo base_url(); ?>assets/css/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrapPager.js" type="text/javascript"></script>

<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Trend Smartphone</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><!-- <i class="fa fa-wrench"></i> --></a>
                    </li>
                    <!-- <li><a id="btnadd"><i class="fa fa-plus"></i></a>
                    </li> -->
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formsearch" data-parsley-validate action="#" method="POST" class="form-horizontal form-label-left">

                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama Produk <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php $kategorinow = ''; ?>
                          <select class="select2_group form-control" required name="q[]" multiple="multiple">
                            <?php if ($produk->num_rows() > 0): ?>
                              <?php foreach ($produk->result() as $r): ?>
                                <?php if($kategorinow == $r->m_produk_keyword) continue; ?>
                                <optgroup label="<?php echo $r->m_produk_keyword; ?>">
                                  <?php foreach ($produk->result() as $r1): ?>
                                    <?php if ($r1->m_produk_keyword == $r->m_produk_keyword): ?>
                                      <option value="<?php echo $r1->m_produk_nama; ?>"><?php echo $r1->m_produk_nama; ?></option>
                                    <?php endif ?>
                                  <?php endforeach ?>
                                </optgroup>
                                <?php $kategorinow = $r->m_produk_keyword; ?>
                              <?php endforeach ?>
                            <?php endif ?>
                        </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jumlah Komentar <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="count" required class="form-control col-md-7 col-xs-12">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tanggal" class="date-picker form-control col-md-7 col-xs-12" name="tgl" required type="text">
                      </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                      <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-6">
                          <button id="search" type="submit" class="btn btn-success btnsearch">Lihat Klasifikasi Tweeter</button>
                          <button id="search2" type="submit" class="btn btn-success btnsearch">Lihat Klasifikasi GsmArena</button>
                      </div>
                  </div>

              </form>
              <div id="loading"></div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Proses</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><!-- <i class="fa fa-wrench"></i> --></a>
                    </li>
                    <!-- <li><a id="btnadd"><i class="fa fa-plus"></i></a>
                    </li> -->
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content tableproses">
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
      $(".select2_group").select2({
        // placeholder: "Pilih Smartphone",
        allowClear: true
      });
      $('#tanggal').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4",
          format: 'YYYY-MM-DD'
      }, function (start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
      });
      var tipe = 0;

      $("#search").click(function(event) {
        event.preventDefault();
        tipe = 1;
        $("#formsearch").submit();
      });

      $("#search2").click(function(event) {
        event.preventDefault();
        tipe = 2;
        $("#formsearch").submit();
      });

      $("#formsearch").submit(function(event) {
        event.preventDefault();
        var link = 'trend/createtrend.aspx';
        if (tipe == 0) {return false;}
        // if (tipe == 1) {
        //   link = 'trend/createtrend.aspx';
        // }else{
        //   link = 'trend/search_gsmarena.aspx';
        // }

        $(".btnsearch").attr('disabled', true);
        $("#search").text('Loading...');
        $("#search2").text('Loading...');

        var data = $("#formsearch").serialize();
        $.ajax({
          url: link, //link gsmarena komentar
          type: 'POST',
          dataType: 'json',
          data: data+'&tipe='+tipe,
        })
        .done(function(resp) {
          if (resp) {
            console.info(resp);
            var thtml = '<table class="table table-striped responsive-utilities jambo_table">'
            for (var i = 0; i < resp.produk.length; i++) {
              thtml += '<tr>';
              thtml += '<td>'+(i+1)+'</td>';
              thtml += '<td>'+resp.produk[i]+'</td>';
              thtml += '<td id="row'+i+'"><center><img src="<?php echo base_url(); ?>assets/images/load_datatweet.gif" /></center></td>';
              thtml += '</tr>';
              searchdata(resp,i);
            }
            thtml+= '</table>';
            $(".tableproses").html(thtml);
          }
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
          $("#search2").text('Lihat Klasifikasi GsmArena');
          $("#search").text('Lihat Klasifikasi Tweeter');
        });
        
        return false;
      });

      function searchdata(rsp,i) {
        var link;
        var data = 'tgl='+rsp.tgl+'&count='+rsp.jmlkomen+'&q='+rsp.produk[i]+'&idtrend='+rsp.idtrend;
        if (rsp.tipe == 1) {
          link = 'klasifikasi/search.aspx';
        }else{
          link = 'klasifikasi/search_gsmarena.aspx';
        }
        $.ajax({
          url: link, //link gsmarena komentar
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(resp) {
          if (resp) {
            $("#row"+i).html('<center><img src="<?php echo base_url(); ?>assets/images/load_klasifikasitwet.gif" /></center>');
            $.post('<?php echo base_url(); ?>klasifikasi/hitungdata/'+resp.idsearch, {}, function(data, textStatus, xhr) {
              console.info(data);
              var rowhtml = data.data_search_pos+" Komentar Positif<br>";
              rowhtml+= data.data_search_neg+" Komentar Negatif<br>";
              rowhtml+= data.data_search_net+" Komentar Netral<br>";
              rowhtml+= "Kesimpulan " +data.data_search_sentiment;
              $("#row"+i).html(rowhtml);
            });
          }
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
      }

        // NotifikasiToast({
        //   type : 'success',
        //   msg : 'coba toast',
        //   title: 'Title'
        // });
  });
</script>