<?php

	/*-----------------------------------------------------------------------------------------
		This file contains functions required for the application.  Most of
	 	these function are used to insert information into the layouts and views, however, some
	 	are required for application setup in index.php.
	 -----------------------------------------------------------------------------------------*/

	//used to render the body of the page
	function yield()
	{
		$num_args = func_num_args();

		if (VIEW != null)
		{
			if(file_exists(VIEW))
			{
				require_once(VIEW);
			}
			else
			{
				echo "phpMojo Error: the defined view can not be found.";
			}
		}
	}

	//grabs data provided by a model for use in a view
	function get_provide($key)
	{
		$provides = unserialize(PROVIDES);

		if (isset($provides[$key]))
		{
			return $provides[$key];
		}
		else
		{
			return false;
		}
	}

	//used to
	function render($key)
	{
		$provides = unserialize(PROVIDES);

		if (isset($provides[$key]))
		{
			if (is_array($provides[$key]))
			{
				if ((func_num_args() > 1) && (count($provides[$key]) != 0))
				{
					 $class = func_get_arg(1);
					 echo '<div class="' . $class . '">';
				}

				foreach ($provides[$key] as $value) {
					echo $value . '<br>';
				}

				if ((func_num_args() > 1) && (count($provides[$key]) != 0))
				{ 
					echo '</div>';
				}
			}
			else
			{
				echo $provides[$key];
			}
		}
	}

	function debug($message)
	{
		
	}

	//used to load all of the files in the stylesheets folder into your layout
	function load_css() {
		$css_files = scandir('app/assets/stylesheets');

		foreach ($css_files as $css) {
			if (($css != '.') && ($css != '..'))
			{
				echo '<link rel="stylesheet" type="text/css" href="' . ROOT . 'app/assets/stylesheets/' . $css . "\">\n";
			}
		}
	}

	//used to load all of the files in the javascript folder into your layout
	function load_javascript() {

		$js_files = scandir('app/assets/javascript');
		$load_priorities = unserialize(JS_PRELOADS);

		foreach ($load_priorities as $js_file)
		{
			echo '<script type="text/javascript" src="' . ROOT . 'app/assets/javascript/' . $js_file . "\"></script>\n";
		}

		foreach ($js_files as $js) {
			if (($js != '.') && ($js != '..') && (!in_array($js, $load_priorities)))
			{
				echo '<script type="text/javascript" src="' . ROOT . 'app/assets/javascript/' . $js . "\"></script>\n";
			}
		}
	}

	//Used to insert partials into a page
	function insert($partial) {
		$layouts = scandir('app/views/layouts');

		if (in_array('_' . $partial . '.php', $layouts))
		{
			include('app/views/layouts/_' . $partial . '.php');
		}
		else
		{
			echo "phpMojo Error: partial not found.";
		}
	}

	//used to create a link in a view or layout
	function link_to($path, $name)
	{
		
		$num_args = func_num_args();

		if ($num_args > 2)
		{
			$class = func_get_arg(2);
		}		

		echo '<a href="' . ROOT . $path . '"';
		if (isset($class)) echo ' class="' . $class . '"';
		echo '>' . $name . '</a>';
	}

	//sets up the application for the current environment which can be set in config/serenity_config.php
	function setup_environment()
	{

		if (ENVIRONMENT == 'development')
		{
			global $development;

			error_reporting(E_ALL);
			ini_set('error_reporting',E_ALL);

		}
		elseif (ENVIRONMENT == 'production')
		{
			error_reporting(0);
			ini_set('error_reporting', 0);
		}
	}

	//used to set load priority for javascript files that need to be loaded first.
	//should only be used in the serenity_config file.
	function js_preload($files)
	{
		$js_files = serialize($files);
		define("JS_PRELOADS", $js_files);
	}

?>