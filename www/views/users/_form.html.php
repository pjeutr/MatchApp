
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                      <h4>Edit user</h4>
                    </div>
                    <div class="card-body table-responsive">
<form method="POST" action="<?php echo $action ?>">
  <input type="hidden" name="_method" id="_method" value="<?php echo $method ?>" />
  <div class="form-group">
    <label>Name:</label>
    <input type="text" class="form-control" name="user[name]" id="name" value="<?php echo h($user->name) ?>" placeholder="Enter a name"/>
  </div>
  <div class="form-group">
    <label>Keycode:</label>
    <input type="text" class="form-control" name="user[keycode]" id="user_keycode" value="<?php echo h($user->keycode) ?>" placeholder="Enter a code"/>
    <small id="emailHelp" class="form-text text-muted">The code to type on the codetableau or code of a keytag</small>
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
    <div class="form-group">
    <label>Remarks:</label>
    <!-- TODO https://stackoverflow.com/questions/37629860/automatically-resizing-textarea-in-bootstrap -->
    <textarea type="text" class="form-control" name="user[remarks]" id="user_remarks" placeholder="Space for some notations" 
     style="height:100%;" rows="3"><?php echo h($user->remarks) ?></textarea>
  </div>
    <?php echo buttonLink_to('Cancel', 'users'), "\n" ?>
    <input type="submit" class="btn btn-secondary" value="Save" />
</form>

                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>

