function OrderPositionViewModel() {
  var self = this;

  self.dialogTitle = ko.observable();
  self.meal = ko.observable();
  self.cost = ko.observable();

  self.mealError = ko.observable(false);
  self.mealErrorMessage = ko.observable('');

  self.costError = ko.observable(false);
  self.costErrorMessage = ko.observable('');

  self.isDialogOpen = false;

  $('#orderPositionDialog').on('show.bs.modal', function(e) {
    self.isDialogOpen = true;
  });

  $('#orderPositionDialog').on('hide.bs.modal', function(e) {
    self.isDialogOpen = false;
  });

  self.openDialog = function(orderViewModel, dialogTitle, onSave) {
    self.dialogTitle(dialogTitle);
    self.orderViewModel = orderViewModel;
    self.onSave = onSave;

    self.meal('');
    self.cost('');

    $('#orderPositionDialog').modal('show');
  };

  self.verifyValues = function() {
    if (self.meal().length == 0) {
      self.mealError(true);
      self.mealErrorMessage('Meal name must not be empty');
    } else {
      self.mealError(false);
    }

    var reCost = new RegExp("^[0-9]+(,[0-9]{2})?$");

    if (!reCost.test(self.cost())) {
      self.costError(true);
      self.costErrorMessage('Invalid cost format, expectd: 9,99');
    } else {
      self.costError(false);
    }

    return !self.mealError() && !self.costError();
  }

  self.openEditDialog = function(orderViewModel, dialogTitle, position, onSave) {
    self.dialogTitle(dialogTitle);
    self.orderViewModel = orderViewModel;
    self.onSave = onSave;

    self.meal(position.meal());
    self.cost(position.cost().toString().replace('.', ','));

    $('#orderPositionDialog').modal('show');
  };

  self.closeDialog = function() {
    $('#orderPositionDialog').modal('hide');
  };

  self.savePosition = function() {
    if (self.verifyValues()) {
      self.closeDialog();

      var positionViewModel = new PositionViewModel(self.orderViewModel);

      positionViewModel.deserialize({
        'meal': self.meal(),
        'cost': self.cost()
      });

      self.onSave(positionViewModel);
    }
  };
};
