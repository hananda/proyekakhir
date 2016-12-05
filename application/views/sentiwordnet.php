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
                <h2>Tabel Sentiwordnet</h2>
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
                <table id="tabelsentiword" class="table table-striped responsive-utilities jambo_table">
                    <thead>
                        <tr class="headings">
                            <th>No</th>
                            <th>POS </th>
                            <th>Pos Score </th>
                            <th>Neg Score</th>
                            <th>Kata </th>
                            <th>Deskripsi </th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#tabelsentiword').DataTable({
              // "order": [[ 4, "asc" ]],
              "columns": [
                {"orderable":false },
                {"orderable":false },
                {"orderable":false },
                {"orderable":false },
                {"orderable":false },
                {"orderable":false}
              ],
              pagingType: "bootstrapPager",
              "sDom": "Rfrtlip",
              pagerSettings: {
                  searchOnEnter: true,
                  language: "Halaman ~ Dari ~"
              },
              processing: true,
              serverSide: true,
              ajax: {
                url: "<?php echo base_url(); ?>datasentiword.aspx",
                type: "POST",
                data: function (d) {
                    
                }
              },
              paginate: true
        });

        table.on('xhr.dt', function (e, settings, json) {
              setTimeout(function () {
                  //initEvent();
              }, 500);
        });
    });
</script>