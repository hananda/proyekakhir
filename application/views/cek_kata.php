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
                <h2>Input Komentar</h2>
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
                      <label class="control-label col-md-1 col-sm-1 col-xs-12">Komentar
                      </label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea name="kata" style="width:100%" required="required"></textarea>
                      </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                      <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-8">
                          <button id="search" type="submit" class="btn btn-success">Cek</button>
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
            <div class="x_content" id="contentsummary">
                
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

      $("#formsearch").submit(function(event) {
        event.preventDefault();
        $("#search").attr('disabled', true);
        $("#search").text('Loading...');
        $("#loading").html('<center><img src="<?php echo base_url(); ?>assets/images/load_klasifikasitwet.gif" /></center>');
        $("#contentsummary").html("");
        var data = $("#formsearch").serialize();
        $.ajax({
          url: 'klasifikasi/cek_kata_single.aspx',
          type: 'POST',
          dataType: 'json',
          data: data,
        })
        .done(function(resp) {
          if (resp) {
            console.info(resp);
            var html = '<table border="1" class="table table-striped responsive-utilities jambo_table"><tr><td colspan="3">Metode Sentiword</td></tr><tr><td>Kata</td><td>Index</td><td>Setiment</td></tr>';
            for(i=0;i<resp.sentiword.data.length;i++){
              html+= '<tr><td>'+resp.sentiword.data[i].kata+'</td><td>'+resp.sentiword.data[i].index+'</td><td>'+resp.sentiword.data[i].sentiment+'</td></tr>';
            }
            html+= '<tr><td colspan="2">Kesimpulan</td><td>'+resp.sentiword.kesimpulan+'</td></tr>';
            html+= '</table>';
            html+= '<br><table border="1" class="table table-striped responsive-utilities jambo_table"><tr><td colspan="3">Metode Nai\'ve Bayes</td></tr><tr><td>Kata</td><td>Index</td><td>Setiment</td></tr>';
            for(i=0;i<resp.naivebayes.data.length;i++){
              html+= '<tr><td>'+resp.naivebayes.data[i].kata+'</td><td>'+resp.naivebayes.data[i].index+'</td><td>'+resp.naivebayes.data[i].sentiment+'</td></tr>';
            }
            html+= '<tr><td colspan="2">Kesimpulan</td><td>'+resp.naivebayes.kesimpulan+'</td></tr>';
            html+= '</table>';
            $("#contentsummary").html(html);
          }
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          $("#loading").html('');
          $("#search").attr('disabled', false);
          $("#search").text('Cek');
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