<?php
	/*-------------------------------------------------------------------------------
        Serenity - "Serene PHP made easy."

        Developer: Patrick Stephens
        Email: pstephens2601@gmail.com
        Github Repository: https://github.com/pstephens2601/Serenity
        Creation Date: 8-20-2013
        Last Edit Date: 3-21-2014

        File Notes - This file contains all of the routing information for your
		application.
    ---------------------------------------------------------------------------------*/

	define("ROOT", "/Serenity/"); //sets the root folder for your site, which is used for links.

	$set = new router;


	/*-------------------------------------------------------------------------------
		Defines the root (home page) of your application.  To change the root 
		define the controller and action seperated by a "#".
	---------------------------------------------------------------------------------*/
	$set->root_to('serene_defaults#default_page');
?> 