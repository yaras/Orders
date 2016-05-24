function OrderDialogViewModel() {
  var self = this;

  self.dialogTitle = ko.observable('');
  self.title = ko.observable('');
  self.description = ko.observable('');
  self.time = ko.observable('');

  self.titleError = ko.observable(false);
  self.titleErrorMessage = ko.observable('');

  self.timeError = ko.observable(false);
  self.timeErrorMessage = ko.observable(false);

  self.openCreateDialog = function(dialogTitle, onSaveAction) {
    self.openEditDialog(dialogTitle, new OrderViewModel(), onSaveAction);
  };

  self.verifyValues = function() {
    if (self.title().length == 0) {
      self.titleError(true);
      self.titleErrorMessage('Title must not be empty');
    } else {
      self.titleError(false);
    }

    var reTime = new RegExp("[0-9]{2}:[0-9]{2}");

    if (!reTime.test(self.time())) {
      self.timeError(true);
      self.timeErrorMessage('Invalid time format, expectd: HH:MM');
    } else {
      self.timeError(false);
    }

    return !self.titleError() && !self.timeError();
  }

  self.openEditDialog = function(dialogTitle, order, onSaveAction) {
    self.dialogTitle(dialogTitle);

    self.title(order.title());
    self.description(order.description());
    self.time(order.time());

    self.onSaveAction = onSaveAction;

    $('#createOrderDialog').modal('show');
  };

  self.onSave = function() {
    if (self.verifyValues()) {
      var order = new OrderViewModel();

      order.title(orderDialogViewModel.title());
      order.description(orderDialogViewModel.description());
      order.time(orderDialogViewModel.time());

      self.onSaveAction(order);
      $('#createOrderDialog').modal('hide');
    }
  };
};
