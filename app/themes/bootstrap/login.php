<?php if(!defined('access') or !access) die("This file cannot be directly accessed."); ?>
<?php G\Render\include_theme_file('elements/header'); ?>

	<div class="container">
		
		<?php if( is_error() || is_success() ) : ?>
		<div class="alert <?php echo is_error() ? 'alert-danger' : 'alert-success'; ?>" role="alert">
			<strong><?php echo is_error() ? 'Warning!' : 'Success!'; ?></strong> <?php echo get_alert_message(); ?>
		</div>
		<?php endif; ?>
	
		<form class="form-signin" method="post">
			
			<h2 class="form-signin-heading">Please Login</h2>
			
			<label for="email_username" class="sr-only">Email/Username</label>
			<input type="text" id="email_username" name="email_username" class="form-control" placeholder="Email/Username" value="<?php echo get_safe_post()["email_username"]; ?>" required autofocus>
			
			<label for="password" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			
			<div class="checkbox">
				<label>
					<input type="checkbox" value="1" id="remember_me" name="remember_me"> Remember me
				</label>
			</div>
			
			<a href="<?php echo G\get_base_url('login/forgot'); ?>" class="forgot">Forgot password?</a>
			
			<?php echo G\Render\get_input_auth_token(); ?>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			
		</form>
	
	</div> <!-- /container -->
    
<?php G\Render\include_theme_file('elements/footer'); ?>