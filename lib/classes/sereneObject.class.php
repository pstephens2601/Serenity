<?php
	/*-------------------------------------------------------------------------------
        Serenity - "Serene PHP made easy."

        Developer: Patrick Stephens
        Email: pstephens2601@gmail.com
        Github Repository: https://github.com/pstephens2601/Serenity
        Creation Date: 3-17-2014
        Last Edit Date: 3-21-2014

        Class Notes - The sereneObject class is the parent class for all Serenity
        Objects except the database class.
    ---------------------------------------------------------------------------------*/
	class sereneObject {

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