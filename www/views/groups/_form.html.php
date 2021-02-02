<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                      <h4>Edit group</h4>
                    </div>
                    <div class="card-body table-responsive">


<form method="POST" action="<?php echo $action ?>">
  <input type="hidden" name="_method" id="_method" value="<?php echo $method ?>" />

  <div class="form-group">
    <label>Group name:</label>
    <input type="text" class="form-control" name="group[name]" id="name" value="<?php echo h($group->name) ?>" placeholder="Enter a name"/>
  </div>

    <?php echo buttonLink_to('Cancel', 'groups'), "\n" ?>
    <input type="submit" class="btn btn-secondary" value="Save" />
</form>

                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>