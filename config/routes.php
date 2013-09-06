<?php
	/*-----------------------------------------------------------------
		This file contains all of the routing information for your
		application.
	------------------------------------------------------------------*/

	define("ROOT", "/Serenity/"); //sets the root folder for your site, which is used for links.

	$set = new router;

	/*------------------------------------------------------------------
		Defines the root (home page) of your application.  To change the
		root define the controller and action seperated by a "#".
	-------------------------------------------------------------------*/
	$set->root_to('serene_defaults#default_page');
?> 