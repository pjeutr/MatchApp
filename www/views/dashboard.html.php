<?php 
set('id', 0);
set('title', 'Dashboard');

$door_open = 2 * 1000;

//poll input, push
$count_reports = 23;
$count_events = 63;
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="icon-mid text-center icon-warning">
                                                <i class="nc-icon nc-vector text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            Control output
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <button class="btn btn-info btn-large" type="button" 
                                        onclick="app.timerAlert('Door 1 is open', <?= $door_open ?>, 1)">Open Door 1</button>
                                    <button class="btn btn-info btn-large" type="button" 
                                        onclick="app.timerAlert('Door 2 is open', <?= $door_open ?>, 2)">Open Door 2</button>
                                    <button class="btn btn-warning btn-large" type="button" 
                                        onclick="app.timerAlert('Alarm 1 is on for 2 seconds', <?= $door_open ?>, 3)">Test Alarm 1</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-mid text-center icon-warning">
                                                <i class="nc-icon nc-tap-01 text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            View input 
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                        <button class="btn btn-warning btn-large" type="button">Reader 1</button>
                                        <button class="btn btn-warning btn-large" type="button">Reader 2</button>
                                        <button class="btn btn-warning btn-large" type="button">Monitor 1</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-tag-content text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="numbers">
                                                <p class="card-category">Door counter</p>
                                                <h4 class="card-title"><?= $count_reports ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> In the last hour
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-tv-2 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="numbers">
                                                <p class="card-category">Reader usage</p>
                                                <h4 class="card-title"><?= $count_events ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-refresh"></i> Today
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
       <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Maasland controller</h4>
                    </div>
                    <div class="card-body">
                                This controller has
                        <div class="typography-line">
                            <p>
                                <span>Hardware</span>

                                <ul>
                                    <li>2 relays outputs - to connect to doorlocks</li>
                                    <li>2 wiegand inputs - to connect to keypad or NFC reader</li>
                                    <li>2 alarm outputs - to connect to alarms</li>
                                    <li>2 monitor inputs - to connect to door monitors</li>
                                    <li>UTP connector - to connect to an LAN</li>
                                    <li>A voltage in - to connect 8-24VDC</li>
                                </ul>

                            </p>
                        </div>
                        <div class="typography-line">
                            <span>Configuration</span>

                                    <ol>
                                    <li>Add doors from this Master controller, or from other Slave controllers</li>
                                    <li>Add timezones (24h and working hours are predefined)</li>
                                    <li>Create groups with timezones</li>
                                    <li>Create users and assign them to a group</li>
                                    <li>Add keypad code or NFC token to the user</li>
                                </ol>
                        </div>
                        <small>
                             <a href="https://docs.google.com/document/d/1ZOc3w04Ov9EECDrhrmd3qmBAxG5lbiUyGuRfasSbtHw/edit" target="docs">Here</a> you can find extra documentation
                        </small>
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>

