function MessageDialogViewModel() {
  var self = this;

  self.message = ko.observable();

  self.messageError = ko.observable(false);
  self.messageErrorMessage = ko.observable('');
  self.isDialogOpen = false;

  $('#messageDialog').on('show.bs.modal', function(e) {
    self.isDialogOpen = true;
  });

  $('#messageDialog').on('hide.bs.modal', function(e) {
    self.isDialogOpen = false;
  });

  self.openDialog = function(onSend) {
    self.message('');
    self.onSend = onSend;
    $('#messageDialog').modal('show');
  };

  self.send = function() {
    if (self.verifyValues()) {
      $('#messageDialog').modal('hide');
      self.onSend(self.message())
    }
  };

  self.verifyValues = function() {
    if (self.message().length == 0) {
      self.messageError(true);
      self.messageErrorMessage('Message must not be empty');
    } else {
      self.messageError(false);
    }

    return !self.messageError();
  }
};
