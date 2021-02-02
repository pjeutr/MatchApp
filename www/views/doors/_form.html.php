<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-body table-responsive">


<form method="POST" action="<?php echo $action ?>">
  <input type="hidden" name="_method" id="_method" value="<?php echo $method ?>" />

  <div class="form-group">
    <label>Door name:</label>
    <input type="text" class="form-control" name="door[name]" id="name" value="<?php echo h($door->name) ?>" placeholder="Enter a name"/>
  </div>

    <?php echo buttonLink_to('Cancel', 'doors'), "\n" ?>
    <input type="submit" class="btn btn-secondary" value="Save" />
</form>

                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>