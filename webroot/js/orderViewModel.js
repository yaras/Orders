function OrderViewModel() {
  var self = this;

  self.isLoading = ko.observable(false);

  self.url = '/orders/orders/';
  self.messagesUrl = '/orders/messages/';
  self.positionsUrl = '/orders/positions/';

  self.id = -1;
  self.title = ko.observable('');
  self.description = ko.observable('');
  self.time = ko.observable('');
  self.progress = ko.observable('');
  self.cost = ko.observable('');
  self.created = ko.observable('');
  self.status = ko.observable('');
  self.author = ko.observable('');

  self.canAddPosition = ko.computed(function() {
    return self.status() == 'New';
  }, this);

  self.canSetNew = ko.computed(function() {
    return self.status() != 'New';
  }, this);

  self.canSetLocked = ko.computed(function() {
    return self.status() != 'Locked';
  }, this);

  self.canSetPending = ko.computed(function() {
    return self.status() != 'Pending';
  }, this);

  self.canSetDelivered = ko.computed(function() {
    return self.status() != 'Delivered';
  }, this);

  self.canSetArchived = ko.computed(function() {
    return self.status() == 'Delivered';
  }, this);

  self.positions = ko.observableArray();
  self.messages = ko.observableArray();

  self.deserialize = function(entity) {
    self.id = entity.id;
    self.title(entity.title);
    self.description(entity.description);
    self.time(entity.order_time);
    self.author(entity.Author.name);
    self.cost(entity.cost);
    self.progress(Math.round(entity.paid));

    if (entity.created) {
      self.created(entity.created.substr(0, 16).replace('T', ' '));
    } else {
      self.created('?');
    }

    self.status(entity.status);
  };

  self.addPosition = function() {
    orderPositionViewModel.openDialog(self, 'Create a position', function(position) {
      self.isLoading(true);

      data = {
        'meal': position.meal(),
        'cost': position.cost(),
        'order_id': self.id
      };

      $.post(self.positionsUrl + 'add', data, function(result) {
        if (result.status == 'success') {

          position.id = result.data.id;
          position.username(result.data.User.name);
          position.orderViewModel = self;

          self.positions.push(position);
        } else {
          alert('Error saving position')
        }

        self.isLoading(false);
      }, 'json');
    });
  };

  self.sendMessage = function() {
    messageDialogViewModel.openDialog(function(messageText) {
      self.isLoading(true);

      data = {
        'message': messageText,
        'order_id': self.id
      };

      $.post(self.messagesUrl + 'add', data, function(result) {
        if (result.status == 'success') {
          var msg = new MessageViewModel();
          msg.deserialize(result.data);

          self.messages.unshift(msg);
        } else {
          alert('Error on saving message');
        }

        self.isLoading(false);
      }, 'json');
    });
  };

  self.isLoadingMessages = false;
  self.isLoadingPositions = false;

  self.refreshIsLoading = function() {
    self.isLoading(self.isLoadingMessages || self.isLoadingPositions);
  }

  self.loadMessages = function() {
    self.isLoadingMessages = true;
    self.refreshIsLoading();
    self.messages.removeAll();

    $.getJSON(self.messagesUrl + 'all/' + self.id, function(data) {
      $.each(data.messages, function(key, value) {
        var msg = new MessageViewModel();
        msg.deserialize(value);
        self.messages.push(msg);
      });

      self.isLoadingMessages = false;
      self.refreshIsLoading();
    });
  };

  self.loadPositions = function() {
    self.isLoadingPositions = true;
    self.refreshIsLoading();
    self.positions.removeAll();

    $.getJSON(self.positionsUrl + 'all/' + self.id, function(data) {
        $.each(data.positions, function(key, value) {
          var p = new PositionViewModel(self);
          p.deserialize(value);

          self.positions.push(p);
        });

        self.isLoadingPositions = false;
        self.refreshIsLoading();
      }
    );
  };

  self.setStatus = function(status) {
    self.isLoading(true);

    $.post(self.url + 'setStatus/' + self.id, { 'status': status }, function(result) {
      if (result.status != 'success') {
        alert(result.result);
      } else {
        self.status(status);
        self.isLoading(false);
      }
    }, 'json');
  };

  self.setNew = function() {
    self.setStatus('New');
  };

  self.setLocked = function() {
    self.setStatus('Locked');
  };

  self.setPending = function() {
    self.setStatus('Pending');
  };

  self.setDelivered = function() {
    self.setStatus('Delivered');
  };

  self.edit = function() {
    orderDialogViewModel.openEditDialog('Edit order', self, function(order) {
      self.isLoading(true);

      data = {
        'title': order.title(),
        'description': order.description(),
        'order_time': order.time()
      };

      $.post(self.url + 'edit/' + self.id, data, function(result) {
        if (result.status != 'success')
        {
          alert(result.result);
        } else {
          self.title(order.title());
          self.description(order.description());
          self.time(order.time());
        }

        self.isLoading(false);
      }, 'json');
    });
  };

  self.archiveOrder = function() {
    confirmDialogViewModel.openDialog('Archive order', 'Do you want to archive ' + self.title() + '?', 'Archive', function() {
      self.isLoading(true);

      $.post(self.url + 'setArchived/' + self.id, [], function(result) {
        if (result.status != 'success')
        {
          alert(result.result);
        } else {
          ordersListViewModel.orders.remove(self);
        }
      }, 'json');
    });
  };

  self.deleteOrder = function() {
    confirmDialogViewModel.openDialog('Delete order', 'Do you want to delete ' + self.title() + '?', 'Delete', function() {
      self.isLoading(true);

      $.post(self.url + 'delete/' + self.id, function(data) {
        console.log(data);

        if (data.result) {
          ordersListViewModel.orders.remove(self);
        } else {
          alert('error deleting ' + self.id);
          self.isLoading(false);
        }
      }, 'json');
    });
  };

  self.reload = function() {
    self.isLoading(true);

    $.getJSON(self.url + 'get/' + self.id, function(data) {
      self.deserialize(data.order);
      self.loadMessages();
      self.loadPositions();
    })
  }
}
