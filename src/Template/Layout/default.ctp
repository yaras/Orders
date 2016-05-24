<?php
use Cake\Core\Configure;

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
  <head>
      <?= $this->Html->charset() ?>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>
        <?= $this->fetch('title') ?>
      </title>

      <?= $this->Html->meta('icon') ?>

      <?= $this->Html->css('bootstrap.css') ?>
      <?= $this->Html->css('bootstrap-theme.css') ?>
      <?= $this->Html->css('base.css') ?>

      <?= $this->Html->script('jquery-2.2.4.js') ?>
      <?= $this->Html->script('bootstrap.js') ?>
      <?= $this->Html->script('knockout-3.4.0.js') ?>

      <?= $this->fetch('meta') ?>
      <?= $this->fetch('css') ?>
      <?= $this->fetch('script') ?>
  </head>
  <body>
    <div class="container">
      <?php if ($authUser) { ?>
        <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">
                <?= $this->Html->image('bread.png', ['alt' => 'Orders']); ?>
              </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active">
                  <a href="#">Orders</a>
                </li>
              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      <?php } ?>

      <h1><a href=""><?= $this->fetch('title') ?></a></h1>

      <?= $this->Flash->render() ?>

      <div class="container clearfix">
          <?= $this->fetch('content') ?>
      </div>
    </div>

    <?= $this->fetch('scriptBottom') ?>

    <footer style="border-top: 1px solid silver; text-align: center; font-size: 8pt; margin-top: 50px; padding-top: 10px;">
      <div>
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="glyphicon glyphicon-chevron-right"></span>
        with
        <span class="glyphicon glyphicon glyphicon-heart"></span>
        in
        <?= $this->Html->link($this->Html->image("atomic-structure.png", ["alt" => "Atom"]), "https://atom.io/", ['escape' => false]) ?>
        by
        <?= $this->Html->link($this->Html->image("yrs.png", ["alt" => "yaras"]), "http://yaras.pl/", ['escape' => false]) ?>

        (v<?= Configure::read('version') ?>)
      </div>

      <div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </footer>
  </body>
</html>
