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
    <input type="text" class="form-control" name="timezone[name]" id="timezone_name" value="<?php echo h($timezone->name) ?>" placeholder="Enter a name"/>
  </div>
  <div class="form-group">
    <label>Door start:</label>
    <input type="text" class="form-control timepicker" name="timezone[start]" id="datetimepicker" value="<?php echo h($timezone->start) ?>" placeholder="Enter a start"/>
  </div>
  <div class="form-group">
    <label>Door end:</label>
    <input type="text" class="form-control timepicker" name="timezone[end]" id="datetimepicker" value="<?php echo h($timezone->end) ?>" placeholder="Enter a end"/>
  </div>

  <?php echo buttonLink_to('Cancel', 'timezones'), "\n" ?>
  <input type="submit" class="btn btn-secondary" value="Save" />
</form>

                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>

