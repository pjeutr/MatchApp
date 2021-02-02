<?php 
set('id', 2);
set('title', 'Groups');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                    	<?= iconLink_to('New group', 'groups/new', 'btn-round', 'nc-icon nc-circle-09') ?>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created</th>
                            </thead>
                            <tbody>
<?php foreach ($groups as $row) { ?>
<tr>
	<td><?= $row->id ?></td>
    <td><?= $row->name ?></td>
    <td>
<table class="table table-hover">
<thead>
    <th>Door</th>
    <th>Timezone</th>
</thead>
<tbody>
<?php foreach ($doors as $row2) { ?>
<tr>
    <td><?= $row2->name ?></td>
    <td>24 hours</td>
    <td><?= iconLink_to("Edit", 'access/'.$row2->id.'/edit', 'btn-sm', null) ?>
</tr>
<?php } ?>
    </tbody>
</table> 
    </td>
    <td><?= iconLink_to("Edit", 'groups/'.$row->id.'/edit', 'btn-sm', null) ?>
    	&nbsp;
    	<?= deleteLink_to('Delete', 'groups', $row->id) ?>
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

