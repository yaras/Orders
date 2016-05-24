<div style="max-width:450px; margin: 0 auto">

  <?php
    $this->assign('title', 'Create account');
    echo $this->Form->create($user);
  ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Register</h3>
    </div>
    <div class="panel-body">

      <?php if (isset($authError)) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <?php echo $this->Flash->render('auth'); ?>
        </div>
      <?php } ?>

      <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Login" value="<?= $user['name'] ?>" />

        <?php
          if (isset($errors) && array_key_exists('name', $errors))
          {
            foreach ($errors['name'] as $msg)
            {
              echo '<div class="help-block">'.$msg.'</div>';
            }
          }
        ?>
      </div>

      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" />

        <?php
          if (isset($errors) && array_key_exists('password', $errors))
          {
            foreach ($errors['password'] as $msg)
            {
              echo '<div class="help-block">'.$msg.'</div>';
            }
          }
        ?>
      </div>

      <div class="form-group">
        <input type="password" name="password-repeat" class="form-control" placeholder="Repeat password" />

        <?php
          if (isset($errors) && array_key_exists('password', $errors))
          {
            foreach ($errors['password'] as $msg)
            {
              echo '<div class="help-block">'.$msg.'</div>';
            }
          }
        ?>
      </div>

      <br /><br />

      <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
    </div>
  </div>

  <?php
    echo $this->Form->end();
  ?>

</div>
