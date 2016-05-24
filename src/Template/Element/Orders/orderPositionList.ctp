<table class="table table-hover">
  <thead>
    <tr>
      <th style="width: 300px" >Meal</th>
      <th style="width: 200px" >Username</th>
      <th style="width: 100px" >Cost</th>
      <th style="width: 100px" >Paid</th>
      <th style="width: 100px" >Edit</th>
      <th style="width: 100px" >Delete</th>
    </tr>
  </thead>
  <tbody data-bind="foreach: positions">
    <tr>
      <td data-bind="text: meal"></td>
      <td data-bind="text: username"></td>
      <td style="text-align: right"><span data-bind="text: cost"></span> zł</td>
      <td>
        <button type="button" class="btn btn-default btn-xs" data-bind="click: setPaid, visible: !paid()">Set paid</button>
        <button type="button" class="btn btn-default btn-xs" data-bind="click: setNotPaid, visible: paid">Set not paid</button>
      </td>
      <td>
        <button type="button" class="btn btn-primary btn-xs" data-bind="click: edit, enable: canEdit">Edit</button>
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-xs" data-bind="click: deletePosition, enable: canDelete">Delete</button>
      </td>
    </tr>
  </tbody>
</table>
