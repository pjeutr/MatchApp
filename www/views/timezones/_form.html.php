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
    <input type="text" class="form-control" name="timezone[name]" id="door_name" value="<?php echo h($timezone->name) ?>" placeholder="Enter a name"/>
  </div>
  <div class="form-group">
    <label>Door start:</label>
    <input type="text" class="form-control datetimepicker" name="timezone[start]" id="door_name" value="<?php echo h($timezone->start) ?>" placeholder="Enter a start"/>
  </div>
  <div class="form-group">
    <label>Door end:</label>
    <input type="text" class="form-control datetimepicker" name="timezone[end]" id="name" value="<?php echo h($timezone->end) ?>" placeholder="Enter a end"/>
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

<script type="text/javascript">

$(function () {
//https://getdatepicker.com/4/#time-only
$('.datetimepicker').datetimepicker({
    format: 'HH:mm',
    useCurrent: false,
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    }
});


});

</script>