<!DOCTYPE html>
<html>
	<head>
		<title>Patrick Stephens <?php render('title'); ?></title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Poiret+One|Lato' rel='stylesheet' type='text/css'>
		<?php 
			load_css();
			load_javascript();
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="upper top">
			<div class="container">
				<?php insert('header') ?>
			</div>
		</div>
		<?php yield(); ?>
	</body>
</html>
