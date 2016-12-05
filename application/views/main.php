<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Analisis Sentimen | PA</title>

    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="<?php echo base_url(); ?>assets/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/floatexamples.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/js/bootstrap-toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/select/select2.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/Logo_PENS.png">

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-toastr/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/select/select2.full.js"></script>
    <script type="text/javascript">
        var NotifikasiToast = function (data) {
            if(!data)
              return;
            var type,msg,title;
            if(!data.type){type = 'success';}else{type = data.type;}
            if(!data.msg){msg = '';}else{msg = data.msg;}
            if(!data.title){title = '';}else{title = data.title;}

            toastr.options = {
              closeButton: true,
              debug: false,
              positionClass: "toast-top-full-width",
              onclick: null,
              showDuration: "1000",
              hideDuration: "1000",
              timeOut: "3000",
              extendedTimeOut: "1000",
              showEasing: "swing",
              hideEasing: "linear",
              showMethod: "fadeIn",
              hideMethod: "fadeOut"
            }

            var $toast = toastr[type](msg, title);
        }
    </script>
    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-font"></i> <span>Analisis Sentimen</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Hananda A.R</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>Menu</h3>
                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home </a></li>
                                <li><a><i class="fa fa-desktop"></i> Master <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url(); ?>sentiwordnet.aspx">Sentiwordnet</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>stopword.aspx">Stopword</a>
                                        </li>
                                        <!-- <li><a href="<?php echo base_url(); ?>prefsuffix.aspx">Preffix Suffix</a>
                                        </li> -->
                                        <li><a href="<?php echo base_url(); ?>smartphone.aspx">Smartphone</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-cubes"></i> Klasifikasi <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url(); ?>klasifikasi.aspx">Klasifikasi Smartphone </a></li>
                                        <li><a href="<?php echo base_url(); ?>klasifikasi/history.aspx">History Klasifikasi </a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-exchange"></i> Trend <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url(); ?>trend.aspx">Trend Smartphone </a></li>
                                        <li><a href="<?php echo base_url(); ?>trend/history.aspx">History Trend </a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-road"></i> Prediksi <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo base_url(); ?>prediksi.aspx">Prediksi Smartphone </a></li>
                                        <li><a href="<?php echo base_url(); ?>prediksi/history.aspx">History Prediksi</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>cek_kata.aspx"><i class="fa fa-search"></i> Cek Kata </a></li>
                                <li><a href="<?php echo base_url(); ?>text_processing.aspx"><i class="fa fa-search"></i> Text Processing</a></li>
                            </ul>
                        </div>
                        <!-- <div class="menu_section">
                            <h3>Live On</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="e_commerce.html">E-commerce</a>
                                        </li>
                                        <li><a href="projects.html">Projects</a>
                                        </li>
                                        <li><a href="project_detail.html">Project Detail</a>
                                        </li>
                                        <li><a href="contacts.html">Contacts</a>
                                        </li>
                                        <li><a href="profile.html">Profile</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="page_404.html">404 Error</a>
                                        </li>
                                        <li><a href="page_500.html">500 Error</a>
                                        </li>
                                        <li><a href="plain_page.html">Plain Page</a>
                                        </li>
                                        <li><a href="login.html">Login Page</a>
                                        </li>
                                        <li><a href="pricing_tables.html">Pricing Tables</a>
                                        </li>

                                    </ul>
                                </li>
                                <li><a><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a>
                                </li>
                            </ul>
                        </div> -->

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a> -->
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="">Hananda A.R
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="javascript:;">  Profile</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Help</a>
                                    </li>
                                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong><a href="inbox.html">See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li> -->

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->


            <!-- page content -->
            <div class="right_col" style="min-height: 730px;" role="main">

                <!-- tempat konten -->
                <?php echo $content; ?>
                <!-- footer content -->

                <footer>
                    <div class="">
                        <p class="pull-right">Analisis Sentimen<a> by </a>
                            <span class="lead"> <i class="fa fa-header"></i>ananda A.R</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
            <!-- /page content -->

        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

    <!-- daterangepicker -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

    
    <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            // var cb = function (start, end, label) {
            //     console.log(start.toISOString(), end.toISOString(), label);
            //     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //     //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            // }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };
            // $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            // $('#reportrange').daterangepicker(optionSet1, cb);
            // $('#reportrange').on('show.daterangepicker', function () {
            //     console.log("show event fired");
            // });
            // $('#reportrange').on('hide.daterangepicker', function () {
            //     console.log("hide event fired");
            // });
            // $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            //     console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            // });
            // $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
            //     console.log("cancel event fired");
            // });
            // $('#options1').click(function () {
            //     $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            // });
            // $('#options2').click(function () {
            //     $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            // });
            // $('#destroy').click(function () {
            //     $('#reportrange').data('daterangepicker').remove();
            // });
        });
    </script>
    <!-- /datepicker -->
    <!-- /footer content -->
</body>

</html>
