function ConfirmDialogViewModel() {
  var self = this;

  self.dialogTitle = ko.observable();
  self.content = ko.observable();
  self.confirmText = ko.observable();

  self.openDialog = function(title, content, confirmText, confirmAction) {
    self.dialogTitle(title);
    self.content(content);
    self.confirmText(confirmText);
    self.action = confirmAction;

    $('#confirmDialog').modal('show');
  }

  self.confirm = function() {
    self.action();
    $('#confirmDialog').modal('hide');
  };
};
