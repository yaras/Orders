<div class="modal fade" tabindex="-1" role="dialog" id="createOrderDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" data-bind="text: dialogTitle"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="inputEmail3" placeholder="Title" data-bind="value: title">

              <p class="bg-danger" data-bind="visible: titleError, text: titleErrorMessage"></p>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="inputEmail3" placeholder="Optional description for this order" data-bind="value: description">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Order time</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="inputEmail3" placeholder="Planned order time in format HH:MM" data-bind="value: time">

              <p class="bg-danger" data-bind="visible: timeError, text: timeErrorMessage"></p>  
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bind="click: onSave">Save</button>
      </div>
    </div>
  </div>
</div>
