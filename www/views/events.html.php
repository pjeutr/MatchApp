<?php 
set('id', 6);
set('title', 'Events');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>Nr</th>
                                <th>Reader</th>
                                <th>Keycode</th>   
                                <th>Timestamp</th>                                        
                            </thead>
                            <tbody>
<?php foreach (array_reverse($events) as $row) { ?>
<tr>
    <td><?= $row->nr ?></td>
    <td><?= $row->reader ?></td>
    <td><?= $row->keycode ?></td>
    <td><?= print_date($row->created_at) ?></td>
</tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>
