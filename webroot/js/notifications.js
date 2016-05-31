var notifications = new function() {
  var self = this;

  self.url = '/orders/notifications/';

  self.start = function() {
    setInterval(function() {
      self.tick();
    }, 10000);
  };

  self.tick = function() {
    $.getJSON(self.url + 'all', function(data) {
      var reloadAll = false;
      var ordersToReload = [];

      if (data.notifications.length > 0) {
        console.log('Received notifications: ' + data.notifications.length);
      }

      $.each(data.notifications, function(key, value) {
        if (value.reload_orders == 1) {
            reloadAll = true;
        }

        if (value.reload_order == 1) {
          if ($.inArray(value.order_id, ordersToReload) == -1) {
            ordersToReload.push(value.order_id);
          }
        }

        self.showNotification(value.id, value.title, value.message);
      });

      if (reloadAll) {
          self.reloadAll();
      } else {
        $.each(ordersToReload, function(idx, orderId) {
          self.reloadOrder(orderId);
        });
      }
    })
  };

  self.reloadAll = function() {
    console.log('Reloading all orders');
    ordersListViewModel.loadOrders();
  };

  self.reloadOrder = function(orderId) {
    $.each(ordersListViewModel.orders(), function(key, value) {
      if (value.id == orderId) {
        value.reload();
      }
    });
  };

  self.showNotification = function(id, title, body) {
    console.log('Show notification: #' + id + ' <' + title + '> ' + '(' + body + ')');

    Notification.requestPermission(function() {

      options = {
         body: body,
         icon: '/orders/img/bread32.png'
      }

      setTimeout(function() {
        var notification = new Notification(title, options);
      }, 200);
   });
  }
}
