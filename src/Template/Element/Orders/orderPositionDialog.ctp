<div class="modal fade" tabindex="-1" role="dialog" id="orderPositionDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" data-bind="text: dialogTitle"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Meal</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" placeholder="Meal name" data-bind="value: meal">

              <p class="bg-danger" data-bind="visible: mealError, text: mealErrorMessage"></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Cost</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" placeholder="Cost of this meal, eg. 2,59" data-bind="value: cost">

              <p class="bg-danger" data-bind="visible: costError, text: costErrorMessage"></p>
            </div>


          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bind="click: savePosition">Save</button>
      </div>
    </div>
  </div>
</div>
