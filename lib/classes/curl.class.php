<?php
	class curl {

		private $ch;

		function __construct($url)
		{
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_URL, $url)
		}

		public function execute()
		{
			curl_exec($this->ch);
		}

		function __destruct()
		{
			curl_close($this->ch);
		}
	}
?>