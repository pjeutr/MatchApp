<?php 
set('id', 5);
set('title', 'Reports');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
              
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table">
                            <thead>
                                <th>ID</th>
                                <th>User</th>
                                <th>Door</th>  
                                <th>Time</th>
                            </thead>
                            <tbody>
<?php foreach (array_reverse($reports) as $row) { ?>
<tr>
    <td><?= $row->id ?></td>
    <td><?= $row->user ?></td>
    <td><?= $row->door ?></td>
    <td><?= $row->created_at ?></td>
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
