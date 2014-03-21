<?php
	/*-------------------------------------------------------------------------------
        Serenity - "Serene PHP made easy."

        Developer: Patrick Stephens
        Email: pstephens2601@gmail.com
        Github Repository: https://github.com/pstephens2601/Serenity
        Creation Date: 8-20-2013
        Last Edit Date: 3-21-2014

        File Notes - This file defines the database connection information for the 
        application. Enter the connection information for your databases as the 
        second argument in each call to define().
	 
	 	Placing the information for each database into this file eliminates the need
	 	to change the login information when moving the app to the server.
    ---------------------------------------------------------------------------------*/

	//the login information for your development database goes in this block
	if (ENVIRONMENT == 'development')
	{
		define("HOST", '');
		define("USER", '');
		define("PASSWORD", '');
		define("DATABASE", '');
	}

	//the login information for your production database goes in this block
	elseif (ENVIRONMENT == 'production')
	{
		define("HOST", '');
		define("USER", '');
		define("PASSWORD", '');
		define("DATABASE", '');
	}
?>