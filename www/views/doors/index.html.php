<?php 
set('id', 3);
set('title', 'Users');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                    	<?= iconLink_to('New door', 'doors/new', 'btn-outline', 'nc-icon nc-bank') ?>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
<?php foreach ($doors as $row) { ?>
<tr>
	<td><?= $row->id ?></td>
    <td><?= $row->name ?></td>
    <td><?= $row->created_at ?></td>
    <td><?= iconLink_to("Edit", 'doors/'.$row->id.'/edit', 'btn-link', null) ?>
    	&nbsp;
    	<?= deleteLink_to('Delete', 'doors', $row->id) ?>
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

