<div data-bind="visible: !isLoading() && orders().length == 0" style="text-align: center">
  No orders found. Use <em>Add new order</em> button to add an order
</div>

<div data-bind="visible: !isLoading(), foreach: orders">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title" data-bind="text: title"></h3>
    </div>
    <div class="panel-body" style="position: relative">
      <div style="text-align:center; text-align: center; position: absolute; background-color: white; opacity: 0.75; position: absolute;
                  left: 0; top: 0; background-color: white; opacity: 0.75; width: 100%; height: 100%; cursor: wait; z-index: 999;" data-bind="visible: isLoading">
        <img src="<?= $this->Url->image('loader.gif') ?>" alt="Loading..." />
      </div>

      <div>
        <div style="text-align: right">
          <?= $this->element('Orders/orderActionButtons') ?>
        </div>

        <div class="form-group">
          <span data-bind="visible: description().length > 0">
            <span>Description: <span style="font-weight: bold" data-bind="text: description"></span> </span>
            <br />
          </span>

          <span>Created: <span style="font-weight: bold" data-bind="text: created"></span> </span>
          <br />

          <span>Author: <span style="font-weight: bold" data-bind="text: author"></span> </span>
          <br />

          <span>Order time: <span style="font-weight: bold" data-bind="text: time"></span> </span>
          <br />

          <span>Status: <span style="font-weight: bold" data-bind="text: status"></span> </span>
          <br />

          <span style="float: left; margin-right: 10px;">Cost: <span style="font-weight: bold" data-bind="text: cost"></span> zł </span>

          <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" data-bind="attr: { title: progress() + '%' }, style: { width: progress() + '%' }">
              <span class="sr-only">45% Complete</span>
            </div>
          </div>

          <br />
          <?= $this->element('Orders/orderPositionList') ?>
          <br />
          <?= $this->element('Orders/orderMessageList'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
