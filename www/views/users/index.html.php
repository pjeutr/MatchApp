<?php 
set('id', 1);
set('title', 'Users');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                    	<?= iconLink_to('New user', 'users/new', 'btn-round', 'fa-user') ?>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Group</th>
                                <th>Last seen</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
<?php foreach ($users as $row) { ?>
<tr>
	<td><?= $row->id ?></td>
    <td><?= $row->name ?></td>
    <td><?= $row->group_name ?></td>
    <td><?= $row->last_seen ?></td>
    <td><?= iconLink_to("Edit", 'users/'.$row->id.'/edit', 'btn-sm') ?>
    	&nbsp;
    	<?= deleteLink_to('Delete', 'users', $row->id) ?>
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

