<?php
	function load_dir($directory)
	{
		$files = scandir($directory);

		foreach ($files as $file)
		{
			if (($file != '.') && ($file != '..') && ($file != ''))
			{
				$path = '/' . $directory . '/' . $file;
				require_once($path);
			}
		}
	}

	//resets the root path of the application
	function root_to($view)
	{
		define("ROOT_PATH", 'app/views/pages/' . $view . '.php');
	}

	//used to render the body of the page
	function render()
	{
		if (PATH != null)
		{
			if(file_exists(PATH))
			{
				require_once(PATH);
			}
			else
			{
				echo PATH;
				echo "phpMojo Error: the defined view can not be found.";
			}
		}
	}
?>