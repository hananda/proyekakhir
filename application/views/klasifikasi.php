<link href="<?php echo base_url(); ?>assets/css/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrapPager.js" type="text/javascript"></script>
<!-- <div class="page-title">
    <div class="title_left">
        <h3>
            Tabel
            <small>
                Sentiwordnet
            </small>
        </h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div> -->
<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Klasifikasi</h2>
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
                          <select class="select2_group form-control" required name="q">
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
                <h2>Summary</h2>
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
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Positif <span class="required">:</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <span id="total0">0 Komentar</span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Negatif <span class="required">:</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <span id="total1">0 Komentar</span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Netral <span class="required">:</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <span id="total2">0 Komentar</span>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Kesimpulan <span class="required">:</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <span id="total3"></span>
                      </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                      <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-8">
                          <a class="btn btn-info" id="linksumarry" href="">Detail Summary</a>
                          <!-- <button type="submit" class="btn btn-info">Detail Summary</button> -->
                      </div>
                  </div>

              </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
      $(".select2_group").select2({
        // placeholder: "Pilih Smartphone",
        // allowClear: true
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
        var link;
        if (tipe == 0) {return false;}
        if (tipe == 1) {
          link = 'klasifikasi/search.aspx';
        }else{
          link = 'klasifikasi/search_gsmarena.aspx';
        }

        $(".btnsearch").attr('disabled', true);
        if (tipe == 1) {
          $("#search").text('Loading...');
        }else{
          $("#search2").text('Loading...');
        }
        $("#loading").html('<center><img src="<?php echo base_url(); ?>assets/images/load_datatweet.gif" /></center>');
        var data = $("#formsearch").serialize();
        $.ajax({
          url: link, //link gsmarena komentar
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(resp) {
          if (resp) {
            $("#loading").html('<center><img src="<?php echo base_url(); ?>assets/images/load_klasifikasitwet.gif" /></center>');
            $.post('<?php echo base_url(); ?>klasifikasi/hitungdata/'+resp.idsearch, {}, function(data, textStatus, xhr) {
              console.info(data);
              $("#total0").text(data.data_search_pos+" Komentar");
              $("#total1").text(data.data_search_neg+" Komentar");
              $("#total2").text(data.data_search_net+" Komentar");
              $("#total3").text(data.data_search_sentiment);
              $("#loading").html('');
              $(".btnsearch").attr('disabled', false);
              if (tipe == 1) {
                $("#search").text('Lihat Klasifikasi Tweeter');
              }else{
                $("#search2").text('Lihat Klasifikasi GsmArena');
              }
              $("#linksumarry").attr('href', '<?php echo base_url(); ?>klasifikasi/detailklasifikasi/'+resp.idsearch+'.aspx');
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
        
        return false;
      });

        // NotifikasiToast({
        //   type : 'success',
        //   msg : 'coba toast',
        //   title: 'Title'
        // });
  });
</script>