<?php if(!defined('access') or !access) die("This file cannot be directly accessed."); ?>
<?php G\Render\include_theme_file('elements/header'); ?>
    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1><?php echo get_title(); ?></h1>
        <p><?php echo get_blurb(); ?></p>
      </div>

        <div class="col-lg-12">
          <div class="list-group">
            <div class="list-group-item">
              <h4 class="list-group-item-heading">Users</h4>
              <p class="list-group-item-text">Basic user management features such as login (with remember me and forgot password), logout, register (with confirmation email) and account page (with user details and ability to change passwords).</p>
            </div>
            <div class="list-group-item">
              <h4 class="list-group-item-heading">User Administration</h4>
              <p class="list-group-item-text">Admin users have the ability to manage a users status (valid, pending, banned) and role (user, admin).</p>
            </div>
            <div class="list-group-item">
              <h4 class="list-group-item-heading">Easy installation!</h4>
              <p class="list-group-item-text">Upload files to a server, create a database with 1 table (schema included) and adjust site settings.</p>
            </div>
            <a href="http://gbackslash.com/" target="_blank" class="list-group-item">
              <h4 class="list-group-item-heading">Built using G\ framework</h4>
              <p class="list-group-item-text">G\ is an elegant micro-framework that helps you to quickly build PHP web applications like never before.</p>
            </a>
            <a href="http://getbootstrap.com/examples/theme/" target="_blank" class="list-group-item">
              <h4 class="list-group-item-heading">Styled using Bootstrap</h4>
              <p class="list-group-item-text">Replaced the default G\ theme with the Bootstrap for easy customization.</p>
            </a>
            <a href="https://github.com/PHPMailer/PHPMailer" target="_blank" class="list-group-item">
              <h4 class="list-group-item-heading">PHPMailer for added functionality</h4>
              <p class="list-group-item-text">Integrated PHPMailer to allow for custom emails and SMTP servers.</p>
            </a>
          </div>
        </div>

    </div> <!-- /container -->
<?php G\Render\include_theme_file('elements/footer'); ?>