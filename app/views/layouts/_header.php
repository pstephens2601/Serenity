<div class="header-upper">
	
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<?php link_to( '', 'Home', 'navbar-brand'); ?>
				<ul class="nav navbar-nav">
					<li class="navbar_link"><?php link_to('aboutme', 'About Me', 'tabindex:-1') ?></li>
					<li class="navbar_link"><?php //link_to('contact.', 'Contact Me'); ?></li>
					<li class="navbar_link"><?php // link_to('logout', 'Logout'); ?></li>
				</ul>
			</div>
		</div>
</div>
<div class="upper">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<?php echo '<img class="logo" src="'. ROOT . 'app/assets/images/so_me.png">'; ?>
			</div>
			<div class="col-lg-8">
				<h1 class="title">Patrick Stephens</h1>
				<h4>Web Developer | CMPSCI Student</h4>
			</div>
		</div>
	</div>
</div>