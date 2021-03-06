<button type="button" class="btn btn-default btn-sm" data-bind="click: addPosition, enable: canAddPosition">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add position
</button>

<button type="button" class="btn btn-default btn-sm" data-bind="click: sendMessage">
  <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Send message
</button>

<button type="button" class="btn btn-info btn-sm" data-bind="click: setNew, visible: canSetNew">
  <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Set new
</button>

<button type="button" class="btn btn-info btn-sm" data-bind="click: setLocked, visible: canSetLocked">
  <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Set locked
</button>

<button type="button" class="btn btn-info btn-sm" data-bind="click: setPending, visible: canSetPending">
  <span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Set pending
</button>

<button type="button" class="btn btn-info btn-sm" data-bind="click: setDelivered, visible: canSetDelivered">
  <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Set delivered
</button>

<button type="button" class="btn btn-warning btn-sm" data-bind="click: edit, visible: canEdit">
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
</button>

<button type="button" class="btn btn-warning btn-sm" data-bind="click: archiveOrder, visible: canSetArchived">
  <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Archive
</button>

<button type="button" class="btn btn-danger btn-sm" data-bind="click: deleteOrder, visible: canDelete">
  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
</button>
