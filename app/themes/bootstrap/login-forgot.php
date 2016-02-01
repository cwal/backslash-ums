<?php if(!defined('access') or !access) die("This file cannot be directly accessed."); ?>
<?php G\Render\include_theme_file('elements/header'); ?>

	<div class="container">
		
		<?php if( is_error() || is_success() ) : ?>
		<div class="alert <?php echo is_error() ? 'alert-danger' : 'alert-success'; ?>" role="alert">
			<strong><?php echo is_error() ? 'Warning!' : 'Success!'; ?></strong> <?php echo get_alert_message(); ?>
		</div>
		<?php endif; ?>
		
		<form class="form-signin" method="post">
      	
			<h2 class="form-signin-heading">Forgot Password?</h2>
			
			<label for="email" class="sr-only">Email address</label>
			<input type="email" id="email" name="email" class="form-control bottom-margin" placeholder="Email address" value="<?php echo get_safe_post()["email"]; ?>" required autofocus>
			
			<?php echo G\Render\get_input_auth_token(); ?>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
        
		</form>

	</div> <!-- /container -->
    
<?php G\Render\include_theme_file('elements/footer'); ?>