<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Javascript tests</title>
    <link rel="stylesheet" href="<?= $this->Url->css('tests/qunit-1.23.1.css') ?>" type="text/css" media="screen">
  </head>
  <body>
    <h1 id="qunit-header">QUnit/Sinon.JS Test</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests"></ol>

    <script type="text/javascript" src="<?= $this->Url->script('jquery-2.2.4.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('bootstrap.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('knockout-3.4.0.js') ?>"></script>

    <script type="text/javascript" src="<?= $this->Url->script('orderPositionViewModel.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('orderDialogViewModel.js') ?>"></script>

    <script type="text/javascript" src="<?= $this->Url->script('tests/qunit-1.23.1.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('tests/sinon-1.17.3.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('tests/sinon-qunit-1.0.0.js') ?>"></script>

    <script type="text/javascript" src="<?= $this->Url->script('tests/orderPositionViewModelTests.js') ?>"></script>
    <script type="text/javascript" src="<?= $this->Url->script('tests/orderDialogViewModelTests.js') ?>"></script>
  </body>
</html>
