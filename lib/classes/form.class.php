<?php
	/*-----------------------------------------------------------------------------------------------
		Serinity - "Serene PHP made easy."

		
		The form class is used to quickly construct Serenity compliant forms.
	------------------------------------------------------------------------------------------------*/

	class form {

		private $name;
		private $action = "";
		private $method = "post";
		private $form;
		private $on_submit;
		private $controller;

		function __construct($action, $method, $name)
		{
			$this->action = $action;
			$this->method = $method;
			$this->name = $name;
			if (func_num_args() > 3)
			{
				$this->on_submit = func_get_arg(3);
			}
			$this->controller = CONTROLLER;
		}

		function startForm()
		{
			$html = '<form action ="' . $this->action . '" method = "' . $this->method . '"';
			if ($this->on_submit != '')
			{
				$html .= ' onsubmit="' . $this->on_submit . '" ';
			}
			$html .= '>';
			$html .= '<input type="hidden" name="form" value="' . $this->name . '">';
			echo $html;
		}

		function start_form()
		{
			$html = '<form action ="' . $this->action . '" method = "' . $this->method . '"';
			if ($this->on_submit != '')
			{
				$html .= ' onsubmit="' . $this->on_submit . '" ';
			}
			$html .= '>';
			$html .= '<input type="hidden" name="form" value="' . $this->name . '">';
			echo $html;
		}

		function setController($controller)
		{
			$this->controller = $controller;
		}

		function input($type)
		{
			$html = "";

			switch ($type)
			{
				case 'password':
				case 'text': // Argument format (type, name, id, class(optional))
					$html .= '<input type="' . $type . '" name="' . func_get_arg(1) .'" id="' . func_get_arg(2) . '" ';

					if (func_num_args() == 4)
					{
						$html .= 'class="' . func_get_arg(3) . '" ';
					}

					$html .= ">\n";
					break;
				case 'submit': // Argument format (type, value, class(optional))
					$html .= '<input type="submit" value="' . func_get_arg(1) . '" name="' . $this->controller . ':submit" class="' . func_get_arg(2). '">';
					break;
				default:
					die('Serenity Error: Invalid type given for input()');
					break;
			}

			echo $html;
		}

		function endForm()
		{
			echo "</form>";
		}

		function end_form()
		{
			echo "</form>";
		}

	}

?>