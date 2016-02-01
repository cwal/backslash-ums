<?php if(!defined('access') or !access) die("This file cannot be directly accessed."); ?>
<?php G\Render\include_theme_file('elements/header'); ?>

	<div class="container">
		
		<?php if( is_error() || is_success() ) : ?>
		<div class="alert <?php echo is_error() ? 'alert-danger' : 'alert-success'; ?>" role="alert">
			<strong><?php echo is_error() ? 'Warning!' : 'Success!'; ?></strong> <?php echo get_alert_message(); ?>
		</div>
		<?php endif; ?>
		
		<form class="form-signin" method="post">
      	
			<h2 class="form-signin-heading">Reset Password</h2>
			
			<label for="newpassword" class="sr-only">New Password</label>
			<input type="password" id="newpassword" name="newpassword" class="form-control no-bottom-margin" placeholder="New Password" required>
			
			<label for="confirmpassword" class="sr-only">Confirm Password</label>
			<input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
			
			<?php echo G\Render\get_input_auth_token(); ?>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
        
		</form>

	</div> <!-- /container -->
    
<?php G\Render\include_theme_file('elements/footer'); ?>