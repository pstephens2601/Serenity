<?php
	/*----------------------------------------------------------------------------
		This is the primary layout for your site.  Unless another layout is
		specified in your controller, this is the layout file that will be
		used.
	-----------------------------------------------------------------------------*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Serenity | Serene PHP</title>
	<?php 
		load_css();
		load_javascript();
	?>
</head>
	<body>
		<?php 
			yield(); //Serenity's yield function is used to insert the page's view.
		?>
	</body>
</html>