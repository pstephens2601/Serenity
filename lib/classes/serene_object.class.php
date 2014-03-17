<?php
	
	class serene_object {

		protected function print_error($message) {
			$html = "<html>";
			$html .= "<head>";
			$html .= '<link rel="stylesheet" type="text/css" href="' . ROOT . 'app/assets/stylesheets/serenity.css">' . "\n";
			$html .= '</head>';
			$html .= '<body>';
			$html .= '<div class="Serene_Error">' . $message . '</div>';
			$html .= '</body>';

			echo $html;
		}

	}

?>