<?php

	// starts a session
	session_start();
	
	// Loads the needed files
	require_once('lib/loader.php');
	load_files();

	//environment setup
	setup_environment();

	// Create Front End Controller object
	$front_end_controller = new frontEndController;
	//grabs the controller + action from $_GET, creates the correct controller object, and calls the action method.
	$front_end_controller->follow_path();
