<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-body table-responsive">


<form method="POST" action="<?php echo $action ?>">
  <input type="hidden" name="_method" id="_method" value="<?php echo $method ?>" />

  <div class="form-group">
    <label>Rule name:</label>
    <input type="text" class="form-control" name="rule[name]" id="rule_name" value="<?php echo h($rule->name) ?>" placeholder="Enter a name"/>
  </div>

  <div class="form-group">
    <label>Group:</label>
      <select name="user[group_id]" class="form-control" id="user_group_id">
        <option id="0"></option>
<?php
    foreach ($groups as $row) {
        echo option_tag($row->id, $row->name, $user->group_id), "\n";
    }
?>
      </select>    
  </div>


    <?php echo buttonLink_to('Cancel', 'rules'), "\n" ?>
    <input type="submit" class="btn btn-secondary" value="Save" />
</form>

                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>