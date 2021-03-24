<?php 
set('id', 7);
set('title', 'Settings');
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">

                    <table class="table table-hover table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
<?php foreach ($settings as $row) { ?>
<tr>
    <td><?= $row->id ?></td>
    <td><?= $row->name ?></td>
    <td>
        <input type="text" name="<?= $row->id ?>" value="<?= $row->value ?> " >
                   
    </td>
    <td><?= iconLink_to("Change", 'settings/'.$row->id.'/update', 'btn-sm', null) ?>
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
