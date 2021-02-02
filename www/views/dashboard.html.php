<?php 
set('id', 0);
set('title', 'Dashboard');
?>

<div class="content">
    <div class="container-fluid">
       <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Master controller</h4>
                        <p class="card-category">Open a door directly<br>
                            <a class="btn btn-info btn-large" href="/?/door/1">Open Door 1</a>
                            <a class="btn btn-info btn-large" href="/?/door/2">Open Door 2</a>
                        </p>
                    </div>
                    <div class="card-body">
                                This controller has
                        <div class="typography-line">
                            <p>
                                <span>Hardware</span>

                                <ul>
                                    <li>2 relays outputs - to connect to doorlocks</li>
                                    <li>2 wiegand inputs - to connect to keypad or NFC reader</li>
                                    <li>UTP connector - to connect to an LAN</li>
                                    <li>A voltage in - to connect 8-24VDC</li>
                                </ul>

                            </p>
                        </div>
                        <div class="typography-line">
                            <span>Configuration</span>
                            <blockquote>
                                <p class="blockquote blockquote-primary">
                                    <ol>
                                    <li>Add doors from this Master controller, or from other Slave controllers</li>
                                    <li>Add timezones (24h and working hours are predefined)</li>
                                    <li>Create groups with timezones</li>
                                    <li>Create users and assign them to a group</li>
                                    <li>Add keypad code or NFC token to the user</li>
                                </ol>
                                    <br>
                                    <br>
                                    <small>
                                         <a href="https://docs.google.com/document/d/1ZOc3w04Ov9EECDrhrmd3qmBAxG5lbiUyGuRfasSbtHw/edit" target="docs">Here</a> you can find extra documentation
                                    </small>
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>

