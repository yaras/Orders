function ConfirmDialogViewModel() {
  var self = this;

  self.dialogTitle = ko.observable();
  self.content = ko.observable();
  self.confirmText = ko.observable();
  self.isDialogOpen = false;

  $('#confirmDialog').on('show.bs.modal', function(e) {
    self.isDialogOpen = true;
  });

  $('#confirmDialog').on('hide.bs.modal', function(e) {
    self.isDialogOpen = false;
  });

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
