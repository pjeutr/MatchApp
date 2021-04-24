<?php 
set('id', 3);
set('title', 'Doors');

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                    	<!-- <?= iconLink_to('New door', 'doors/new', 'btn-outline') ?> -->
                    </div>
                    <div class="card-body table-responsive">
                        <div class="container-fluid border rounded">
                            <div class="row border">
                                <div class="col-sm-4 custom-header border-left-0">
                                        Master Controller                                
                                </div>
                                <?php 

                                $switches = ["Reader 1","Reader 2","Button 1","Button 2"];

                                foreach ($doors as $row) { 

                                ?>
                                <div class="col-sm-4 custom-header">
                                    <div class="float-left">
                                        <?= $row->name ?>
<!--                                         <?= $row->reader_1 ?>-<?= $row->reader_2 ?>_
                                        <?= $row->button_1 ?>-<?= $row->button_2 ?> -->
                                    </div>
                                    <div class="float-right">
                                        <?= iconLink_to("Change name", 'doors/'.$row->id.'/edit', 'btn-link text-success', null) ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <form class="doorForm" id="row" action="<?= url_for('controller', 1) ?>" method="POST">
                            <input type="hidden" name="_method" id="_method" value="PUT">

                            <?php foreach ($switches as $key=>$value) { ?>
                            <div class="row border border-top-0">
                                <div class="col-sm-4 p-3 bg-custom">
                                    <?= $value ?> 
                                </div>
                                <div class="col-sm-4 custom-cell">
                                    <input class="form-check-input" checked type="radio" name="switch_<?= $key ?>" value="door_1">
                                </div>
                                <div class="col-sm-4 custom-cell">
                                    <input class="form-check-input" type="radio" name="switch_<?= $key ?>" value="door_2">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row border border-top-0">
                                <div class="col-sm-4 p-3 custom-header"></div>
                                <div class="col-sm-8 p-3 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-outline">
                                      <i class="fa fa-edit"></i> Save
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>               
        </div>
    </div>
</div>

