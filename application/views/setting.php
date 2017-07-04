<?php //var_dump($setting); ?>
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Setting</h2>
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
                <form id="formsearch" data-parsley-validate action="<?php echo base_url(); ?>setting/save" method="POST" class="form-horizontal form-label-left">
                  <span class="section">Range Similiarity</span>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Range Size<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="rangesize" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->rangesize) ? $setting->rangesize : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Range Camera<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="rangecamera" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->rangecamera) ? $setting->rangecamera : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Range Ram<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="rangeram" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->rangeram) ? $setting->rangeram : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Range Battery<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="rangebattery" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->rangebattery) ? $setting->rangebattery : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Range Sensor<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="rangesensor" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->rangesensor) ? $setting->rangesensor : 0; ?>" />
                      </div>
                  </div>
                  <span class="section">Bobot Rangking</span>

                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bobot Positif<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="bobotpositif" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->bobotpositif) ? $setting->bobotpositif : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bobot Negatif<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="bobotnegatif" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->bobotnegatif) ? $setting->bobotnegatif : 0; ?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bobot Netral<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  name="bobotnetral" required class="form-control col-md-7 col-xs-12" value="<?php echo (@$setting->bobotnetral) ? $setting->bobotnetral : 0; ?>" />
                      </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                      <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-6">
                          <button id="search" type="submit" class="btn btn-success btnsearch">Simpan</button>
                      </div>
                  </div>

              </form>
              <div id="loading"></div>
            </div>
        </div>
    </div>
</div>