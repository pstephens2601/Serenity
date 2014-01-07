<?php

	/*-----------------------------------------------------------------------------------------------
		Serinity - "Serene PHP made easy."

		The base controller class will be the parent class for all of your controllers.  It will
		provide them with basic methods and functionality, while also performing nessasary actions
		upon creation and destruction of your controller objects.
	------------------------------------------------------------------------------------------------*/

	class baseController {

		protected $provides = array();
		protected $view;
		protected $layout = 'layout';
		protected $get_id;
		public $params = array();
		public $form_submit = false;
		protected $ajax_request = false;

		function __construct($action)
		{
			$this->check_form_submission();
			$this->get_params();
			$this->view = 'app/views/' . get_class($this) . '/' . $action . '.php';
			$this->$action();
			$this->defineController();
		}

		function ajax()
		{
			$this->ajax_request = true;

			echo "phpMojo: Your ajax request has been processed. To customize the response create an ajax function in your ";
			echo get_class($this) . " controller. Don't forget to set the ajax_request param to true.";
		}

		function pass_form_data()
		{
			return $this->post;
		}

		/*-------------------------------------------------------------------
			Redirects the user to another page.  Can only be used before
			any output is written to the browser.
		--------------------------------------------------------------------*/
		function to_page($url)
		{
			header("Location: " . ROOT . $url);
		}

		protected function provide($key, $value)
		{
			$this->provides[$key] = $value;
		}

		protected function set_layout($layout_name)
		{
			$this->layout = $layout_name;
		}

		protected function set_view($view)
		{
			$this->view = 'app/views/' . get_class($this) . '/' . $view . '.php';
		}

		private function get_params()
		{
			foreach ($_GET as $key => $value) 
			{
				if (($key != 'action') && ($key != 'controller'))
				{
					$this->params[$key] = $value;
				}
			}
		}

		private function defineController()
		{
			define('CONTROLLER', get_class($this));
		}

		private function check_form_submission()
		{
			if (isset($_POST[ get_class($this) . ':submit']))
			{
				//put each element into the $post_data array
				foreach ( $_POST as $key => $value)
				{
					$fields = explode( ':', $key );

					if (count($fields) < 2)
					{
						$this->params[$fields[0]] = htmlspecialchars($value);
					}
				}

				$this->form_submit = true;
			}
		}

		function dump_data()
		{
			define("VIEW", $this->view);
			define("PROVIDES", serialize($this->provides));
		}

		function __destruct()
		{
			if ($this->ajax_request == false)
			{
				$this->dump_data();
				include('app/views/layouts/' . $this->layout .'.php');
			}
		}
	}
?>