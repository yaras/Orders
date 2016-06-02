function OrdersListViewModel() {
  var self = this;

  self.url = '/orders/orders/';

  self.orders = ko.observableArray();
  self.isLoading = ko.observable(false);

  self.openCreateDialog = function() {
    orderDialogViewModel.openCreateDialog('Create an order', function(order) {
      order.isLoading(true);
      self.orders.unshift(order);

      var data = {
        'title': order.title(),
        'order_time': order.time(),
        'description': order.description()
      };

      $.post(self.url + 'add', data, function(result) {
        console.log(result);

        if (result.status == 'success') {
          order.deserialize(result.data);
        } else {
          alert(result.data);
        }

        order.isLoading(false);
      }, 'json');
    });
  };

  self.loadOrders = function() {
    self.isLoading(true);

    $.getJSON(self.url + 'all', function(data) {
      self.loadData(data);
      self.isLoading(false);
    });
  };

  self.loadData = function(data) {
    console.log(data);
    self.orders.removeAll();

    if (data.orders)
    {
      $.each(data.orders, function(key, value) {
        var order = new OrderViewModel();
        order.deserialize(value);

        order.isLoading(true);
        order.loadMessages();
        order.loadPositions();

        self.orders.push(order);
      });
    }
  }
};
