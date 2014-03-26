<?php
	/*-------------------------------------------------------------------------------
		Serenity - "Serene PHP made easy."

		Developer: Patrick Stephens
		Email: pstephens2601@gmail.com
		Github Repository: https://github.com/pstephens2601/Serenity
		Creation Date: 8-17-2013
		Last Edit Date: 3-24-2014

		Class Notes - The base controller class will be the parent class for all of 
		your controllers.  It will provide them with basic methods and functionality, 
		while also performing nessasary actions upon creation and destruction of your
		controller objects.
	---------------------------------------------------------------------------------*/

	class baseController extends sereneObject 
	{

		protected $provides = array();
		protected $view;
		protected $layout = 'layout';
		protected $get_id;
		public $params = array();
		public $form_submit = false;
		protected $ajax_request = false;
		private $download = false;

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

			echo "Serenity: Your ajax request has been processed. To customize the response create an ajax function in your ";
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

		/*-------------------------------------------------------------------
			Parses a nested associative array into a comma seperated value
			and returns list as a string. Takes either one or two arguments.

			Arguments:
				1. array to be parsed
				2. array of keys to be included if not all keys are to be
				   included in the list
		--------------------------------------------------------------------*/
		protected function to_csv($list)
		{
			$csv_string = '';

			foreach ($list as $line)
			{
				end($line);
				$last_index = key($line);
				reset($line);

				foreach ($line as $key => $item)
				{
					if (func_num_args() > 1)
					{
						if (in_array($key, func_get_arg(1)))
						{
							if (strripos($item, ',') !== false)
							{
								$csv_string .= '"' . trim($item) . '"';
							}
							else
							{
								$csv_string .= trim($item);
							}
							
							if ($key != $last_index)
							{
								$csv_string .= ",";
							}
							else
							{
								$csv_string .= "\n";
							}
						}
					}
					else
					{
						$csv_string .= "\"" . $item . "\"";

						if ($key != $last_index)
						{
							$csv_string .= ", ";
						}
						else
						{
							$csv_string .= "\n";
						}
					}
				}
			}
			return $csv_string;
		}

		protected function download($file_name, $content)
		{
			$file = new file;

			if (!$file->exists($file_name))
			{
				$file->create($file_name);
				$file->write($content);
			}
			else
			{
				$file->open($file_name);
				$file->write($content);
			}
			
			if ($file->exists($file_name))
			{
				if (headers_sent())
				{
					echo "WTF!?!";
				}
				else
				{
					$this->download = true;

					$filepath = $_SERVER['DOCUMENT_ROOT'] . ROOT . "/" . $file_name;

					header('Pragma: public'); 	// required
					header('Expires: 0');		// no cache
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Last-Modified: '. gmdate ('D, d M Y H:i:s', filemtime ($filepath)).' GMT');
					header('Cache-Control: private',false);
					header("Content-type: application/vnd.ms-excel");
					header('Content-Disposition: attachment; filename="'. basename($filepath) . '"');
					header('Content-Transfer-Encoding: binary');
					//header('Content-Length: '. filesize($filepath));	// provide file size
					header('Connection: close');
					readfile($filepath); // push it out
					exit();
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
			if ($this->ajax_request == false && $this->download == false)
			{
				$this->dump_data();
				include('app/views/layouts/' . $this->layout .'.php');
			}
		}
	}
?>