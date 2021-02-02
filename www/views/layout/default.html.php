<!--
=========================================================

 Coded by Sloots.nu

=========================================================

-->
<?php
if(! isset($title)) {
    $title = "";
}

if(! isset($id)) {
    $id = 2;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Maasland</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/css/demo.css?1" rel="stylesheet" />
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg" data-color="green">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="./" class="simple-text">
                        Maasland
                    </a>
                </div>
                <ul class="nav">
                    <li <?php echo ($id == 0) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link active" href="./?/dash">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 1) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/users">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 2) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/groups">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Groups</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 3) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/doors">
                            <i class="nc-icon nc-bank"></i>
                            <p>Doors</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 4) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/timezones">
                            <i class="nc-icon nc-watch-time"></i>
                            <p>Timezones</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 5) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/reports">
                            <i class="nc-icon nc-ruler-pencil"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 6) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link" href="./?/events">
                            <i class="nc-icon nc-notes"></i>
                            <p>Events</p>
                        </a>
                    </li>
<!--                     <li class="nav-item active active-pro">
                        <a class="nav-link active" href="upgrade.html">
                            <i class="nc-icon nc-alien-33"></i>
                            <p>Upgrade to PRO</p>
                        </a>
                    </li> -->
                    <hr>
                    <li <?php echo ($id == 10) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link active" href="./?/gpio">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>GPIO</p>
                        </a>
                    </li>
                    <li <?php echo ($id == 11) ? 'class="nav-item active"' : '' ?>>
                        <a class="nav-link active" href="/admin/phpliteadmin.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>DB</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">



                    <a class="navbar-brand" href="#wim"><?php echo $title ?></a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav ml-auto">

                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">12:34 Main door opened by John</a>
                                    <a class="dropdown-item" href="#">06:23 Fire alarm</a>
                                    <a class="dropdown-item" href="#">06:14 Main door opened by Daenerys </a>
                                    <a class="dropdown-item" href="#">02:34 Back door opened by Arya</a>
                                </ul>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            
            <?php echo $content ?>
            
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="https://www.maaslandgroep.nl/" target="_blank">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="https://www.maaslandgroep.nl/contact" target="_blank">
                                    Contact
                                </a>
                            </li>
                            <li>
                                <a href="https://maaslandserver.com/" target="_blank">
                                    Faq
                                </a>
                            </li>
                            <li>
                                <a href="https://www.maaslandgroep.nl/nieuws" target="_blank">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="https://maaslandgroup.com/">Maasland Group</a>, Your Access To Safety. All Rights Reserved.
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<Xscript type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<Xscript src="../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/js/demo.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
            //window.setInterval(function() {
                //key_autoload();
            //}, 300);

    }); //END $(document).ready()

    var frm = $('#led_form');
    //TODO error op ander pagina's 
    // document.led_form.addEventListener('change', function(obj) {
    // //    console.log(obj.target.name + "=" + obj.target.value);
          
    //     $.ajax({
    //         type: 'GET',
    //         url: '/?/gpio/' +obj.target.name+ '/' +obj.target.value,
    //         //data: frm.serialize(),
    //         success: function(data){
    //             //$('#ledimg_content').html(data);
    //         }
    //     });
    // });

    var key_frm = $('#key_form');
    function key_autoload(){
        $.ajax({
            type: 'GET',
            url: '/?/gpio_key/',
            success: function(data){
                $('#key_content').html(data);
            }
        });
    }
</script>

</html>

