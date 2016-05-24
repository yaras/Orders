<?php
  $this->assign('title', 'Orders');
?>

<div id="actionButtons">
  <button type="button" class="btn btn-primary" data-bind="click: openCreateDialog, disable: isLoading">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new order
  </button>
</div>

<h3>Orders list</h3>

<div id="ordersList">
  <div style="text-align:center" data-bind="visible: isLoading" style="cursor: wait; z-index: 999;">
    <img src="<?= $this->Url->image('loader.gif') ?>" alt="Loading..." style="cursor: wait" />
  </div>

  <?= $this->element('Orders/ordersList') ?>
</div>

<?= $this->element('Orders/createOrderDialog') ?>
<?= $this->element('Orders/orderPositionDialog') ?>
<?= $this->element('Orders/confirmDialog') ?>
<?= $this->element('Orders/messageDialog') ?>

<?php
  $this->start('script');
  echo $this->Html->script('confirmDialogViewModel');
  echo $this->Html->script('messageDialogViewModel');
  echo $this->Html->script('messageViewModel');
  echo $this->Html->script('orderDialogViewModel');
  echo $this->Html->script('orderPositionViewModel');
  echo $this->Html->script('ordersListViewModel');
  echo $this->Html->script('orderViewModel');
  echo $this->Html->script('positionViewModel');
  echo $this->Html->script('notifications');  
  $this->end();

  $this->Html->script('orders', ['block' => 'scriptBottom']);
?>
