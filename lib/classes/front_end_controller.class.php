<?php
	/*-----------------------------------------------------------------------------------------------
		Serinity - "Serene PHP made easy."
		
		The front End Controller is responsible for all of the application routing.
	------------------------------------------------------------------------------------------------*/

	class frontEndController
	{
		var $path;
		var $controllers;

		function __construct()
		{
			//if the controller or action are not set
			if ((!isset($_GET['controller'])) || (!isset($_GET['action'])))
			{
				//ROOT_PATH is defined in funcs.php
				$this->path = ROOT_PATH;
			}
		}

		function follow_path()
		{
			if ($this->path == ROOT_PATH)
			{
				/* array format = 
				 * Array ( [0] => Array ( [0] => controller [1] => action ) [1] =>
				 * app/views/controller/action.php )
				 */
				$path = unserialize(ROOT_PATH);

				$controller = $path[0];
				$action = $path[1];
			
				$active_controller = new $controller($action);
				call_user_func(array($active_controller, $action));
				unset($active_controller);
			}
			else
			{
				$this->call($_GET['controller'], $_GET['action']);
			}
		}

		private function call($controller, $action)
		{
			if ((class_exists($controller)) && (method_exists($controller, $action)))
			{
				$active_controller = new $controller($action);
			}
			else
			{
				echo "You are here!";
				//header('Location: ../index.php');
			}
		}
	}

?>