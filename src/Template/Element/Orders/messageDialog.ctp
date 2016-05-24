<div class="modal fade" tabindex="-1" role="dialog" id="messageDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Send a message</h4>
      </div>
      <div class="modal-body">
        <div style="padding: 5px;">
          <div class="form-group">
            <textarea data-bind="value: message" class="form-control" id="message" rows="3"></textarea>
          </div>

          <p class="bg-danger" data-bind="visible: messageError, text: messageErrorMessage"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-bind="click: send">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
