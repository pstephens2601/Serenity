<?php

	/*-------------------------------------------------------------------------------------------------
		This file handles all of the file loading for the application except for javascript
	 	and css files, which must be loaded from the layout. The include order for loading is defined
	 	in load_files(), however, it is mandatory that 'config/serenity_config.php' is always loaded first
	 	as it defines constants required by the other config files.
	 -------------------------------------------------------------------------------------------------*/

	function load_files()
	{
		load_file('config/serenity_config.php');
		//serene_object must be preloaded as it is the base class for all classes
		load_file('lib/classes/serene_object.class.php'); 
		load_dir('lib/classes');
		load_file('serenity_funcs.php');
		load_dir('config');
		load_dir('app/models');
		load_dir('app/controllers');
		load_file('pluggins/loader.php');
	}

	/*--------------------------------------------------------------------------------------------------
		This helper function is used to load entire directories. If a file in the directory has already
	 	been loaded this function will not include it again.
	 --------------------------------------------------------------------------------------------------*/
	 
	function load_dir($directory)
	{
		$files = scandir($directory);

		foreach ($files as $file)
		{
			if (($file != '.') && ($file != '..') && ($file != ''))
			{
				$path = $directory . '/' . $file;
				require_once($path);
			}
		}
	}

	/*--------------------------------------------------------------------------------------------------
		This helper function is used to load a single file. If the file has already
	 	been loaded this function will not include it again.
	 --------------------------------------------------------------------------------------------------*/
	function load_file($file)
	{
		require_once($file);
	}

	function load_classes() {

	}
?>