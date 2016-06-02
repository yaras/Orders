var notifications = new function() {
  var self = this;

  self.url = '/orders/notifications/';

  self.isAnyDialogOpen = function() {
    return confirmDialogViewModel.isDialogOpen
      || messageDialogViewModel.isDialogOpen
      || orderDialogViewModel.isDialogOpen
      || orderPositionViewModel.isDialogOpen;
  };

  self.start = function() {

    $.post(self.url + 'dismiss', function(data) {
      setInterval(function() {
        self.tick();
      }, 10000);
    }, 'json');
  };

  self.tick = function() {

    if (self.isAnyDialogOpen()) {
      return;
    }

    $.getJSON(self.url + 'all', function(data) {
      var reloadAll = false;
      var ordersToReload = [];

      if (data.notifications.length > 0) {
        console.log('Received notifications: ' + data.notifications.length);
      }

      var i = 1;

      $.each(data.notifications, function(key, value) {
        if (value.reload_orders == 1) {
            reloadAll = true;
        }

        if (value.reload_order == 1) {
          if ($.inArray(value.order_id, ordersToReload) == -1) {
            ordersToReload.push(value.order_id);
          }
        }

        if (!value.silent) {
          setTimeout(function () {
            self.showNotification(value.id, value.title, value.message);
          }, i * 200);

          i += 1;
        }
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
    Notification.requestPermission(function() {
      console.log('Show notification: #' + id + ' <' + title + '> ' + '(' + body + ')');

      var n = new Notification(title, {
         body: body,
         icon: '/orders/img/bread32.png'
      });
   });
  }
}
