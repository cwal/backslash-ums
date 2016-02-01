    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo G\get_base_url(); ?>">Backslash\UMS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?php echo strtolower(G\Handler::getRoute(false)) == 'index' ? 'active' : ''; ?>"><a href="<?php echo G\get_base_url(); ?>">Home</a></li>
            <?php if(!is_logged()) : ?>
            <li class="<?php echo strtolower(G\Handler::getRoute(false)) == 'login' ? 'active' : ''; ?>"><a href="<?php echo G\get_base_url('login'); ?>">Login</a></li>
            <li class="<?php echo strtolower(G\Handler::getRoute(false)) == 'register' ? 'active' : ''; ?>"><a href="<?php echo G\get_base_url('register'); ?>">Register</a></li>
            <?php endif; ?>
            <?php if(is_logged()) : ?>
            <li class="<?php echo strtolower(G\Handler::getRoute(false)) == 'account' ? 'active' : ''; ?>"><a href="<?php echo G\get_base_url('account'); ?>">Account</a></li>
            <li><a href="<?php echo G\get_base_url('logout'); ?>">Logout</a></li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
