var orderDialogViewModel = new OrderDialogViewModel();
var orderPositionViewModel = new OrderPositionViewModel();
var ordersListViewModel = new OrdersListViewModel();
var confirmDialogViewModel = new ConfirmDialogViewModel();
var messageDialogViewModel = new MessageDialogViewModel();

ko.applyBindings(orderDialogViewModel, document.getElementById("createOrderDialog"));

ko.applyBindings(ordersListViewModel, document.getElementById("ordersList"));
ko.applyBindings(ordersListViewModel, document.getElementById("actionButtons"));

ko.applyBindings(orderPositionViewModel, document.getElementById("orderPositionDialog"));
ko.applyBindings(confirmDialogViewModel, document.getElementById("confirmDialog"));

ko.applyBindings(messageDialogViewModel, document.getElementById("messageDialog"));

ordersListViewModel.loadOrders();
notifications.start();
