function PositionViewModel(orderViewModel) {
  var self = this;

  self.orderViewModel = orderViewModel;
  self.url = '/orders/positions/';

  self.id = -1;
  self.meal = ko.observable('');
  self.username = ko.observable('');
  self.cost = ko.observable('');
  self.paid = ko.observable(false);

  self.permission = ko.observable(true);

  self.canSetPaid = ko.computed(function() {
    //// only owner can set paid
    return self.orderViewModel != null && self.orderViewModel.permission();
  }, this);

  self.canDelete = ko.computed(function() {
    return self.orderViewModel != null
      && (self.orderViewModel.permission() || self.permission());
  }, this);

  self.canEdit = ko.computed(function() {
    if (self.orderViewModel == null) {
      return false;
    }

    return self.orderViewModel.status() == 'New' && (self.orderViewModel.permission() || self.permission());
  }, this);

  self.canDelete = ko.computed(function() {
    if (self.orderViewModel == null) {
      return false;
    }

    return self.orderViewModel.status() == 'New' && (self.orderViewModel.permission() || self.permission());
  }, this);

  self.deserialize = function(data) {
    self.id = data.id;
    self.meal(data.meal);
    self.username(data.Author ? data.Author.name : '');
    self.cost(data.cost);
    self.paid(data.paid ? (data.paid == '1') : false);
    self.permission(data.permission);
  };

  self.setPaid = function() {
    self.setStatus(true, function() {
      self.orderViewModel.reload();
    });
  };

  self.setNotPaid = function() {
    self.setStatus(false, function() {
      self.orderViewModel.reload();
    });
  };

  self.setStatus = function(status, callback) {
    self.orderViewModel.isLoading(true);

    $.post(self.url + 'setStatus/' + self.id, { 'paid': status ? 1 : 0 }, function(result) {
      if (result.status != 'success') {
        alert(result.result);
      } else {
        self.paid(status);
        self.orderViewModel.isLoading(false);
        callback();
      }
    }, 'json');
  };

  self.edit = function() {
    orderPositionViewModel.openEditDialog(self.orderViewModel, 'Edit position', self, function(position) {
      self.orderViewModel.isLoading(true);

      data = {
        'meal': position.meal(),
        'cost': position.cost()
      };

      $.post(self.url + 'edit/' + self.id, data, function(result){

        if (result.status == 'success') {
          self.meal(position.meal());
          self.cost(position.cost());
        } else {
          alert('Error updating position');
        }

        self.orderViewModel.isLoading(false);
      }, 'json');
    });
  };

  self.deletePosition = function() {
    confirmDialogViewModel.openDialog('Delete position', 'Are you sure you want to delete "' + self.meal() + '"?', 'Delete', function() {
      self.orderViewModel.isLoading(true);

      $.post(self.url + 'delete/' + self.id, function(result) {

        if (result.status == 'success') {
          self.orderViewModel.positions.remove(self);
        } else {
          alert('Error deleting position');
        }

        self.orderViewModel.isLoading(false);
      }, 'json');
    });
  }
}
