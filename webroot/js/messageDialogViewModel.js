function MessageDialogViewModel() {
  var self = this;

  self.message = ko.observable();

  self.messageError = ko.observable(false);
  self.messageErrorMessage = ko.observable('');

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
