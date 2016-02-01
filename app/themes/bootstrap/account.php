<?php if(!defined('access') or !access) die("This file cannot be directly accessed."); ?>
<?php G\Render\include_theme_file('elements/header'); ?>

	<div class="container">
		
		<div class="page-header"><h1>Account</h1></div>
		
		<?php if( is_error() || is_success() ) : ?>
		<div class="alert <?php echo is_error() ? 'alert-danger' : 'alert-success'; ?>" role="alert">
			<strong><?php echo is_error() ? 'Warning!' : 'Success!'; ?></strong> <?php echo get_alert_message(); ?>
		</div>
		<?php endif; ?>
		
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Account Info</h3>
					</div>
					<div class="panel-body">
						
						<ul class="list-group">
							<?php foreach(get_user() as $key => $value) : ?>
								<?php if($key == 'username' || $key == 'email') : ?>
									<li class="list-group-item"><?php echo ucfirst($key); ?>: <?php echo $value; ?></li>
								<?php endif; ?>
								<?php if($key == 'date_gmt') : ?>
									<li class="list-group-item">Date Joined (GMT): <?php echo $value; ?></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
          
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Change Password</h3>
					</div>
					<div class="panel-body">
						
						<form class="form-signin" method="post">
							
							<label for="currentpassword" class="sr-only">Current Password</label>
							<input type="password" id="currentpassword" name="currentpassword" class="form-control no-bottom-margin" placeholder="Current Password" required autofocus>
							
							<label for="newpassword" class="sr-only">New Password</label>
							<input type="password" id="newpassword" name="newpassword" class="form-control no-bottom-margin" placeholder="New Password" required>
							
							<label for="confirmpassword" class="sr-only">Confirm Password</label>
							<input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
							
							<?php echo G\Render\get_input_auth_token(); ?>
							
							<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
				        
						</form>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php if(get_user()['is_admin']) : ?>
		
		<div class="page-header"><h1>User Administration (<?php echo count(get_all_users()); ?>)</h1></div>
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Email</th>
					<th>Status</th>
					<th>Admin?</th>
					<th>Date (GMT)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach(get_all_users() as $user) : ?>
				<tr id="<?php echo $user['id']; ?>">
					<td><?php echo $user['id']; ?></td>
					<td><?php echo $user['username']; ?></td>
					<td><?php echo $user['email']; ?></td>
					<td class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><?php echo $user['status']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="?id=<?php echo $user['id']; ?>&status=valid">valid</a></li>
							<li><a href="?id=<?php echo $user['id']; ?>&status=pending">pending</a></li>
							<li><a href="?id=<?php echo $user['id']; ?>&status=banned">banned</a></li>
						</ul>
					</td>
					<td class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><?php echo $user['is_admin'] ? 'yes' : 'no'; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="?id=<?php echo $user['id']; ?>&admin=true">yes</a></li>
							<li><a href="?id=<?php echo $user['id']; ?>&admin=false">no</a></li>
						</ul>
					</td>
					<td><?php echo $user['date_gmt']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php endif; ?>

	</div> <!-- /container -->

<?php G\Render\include_theme_file('elements/footer'); ?>