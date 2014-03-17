<?php
	class curl extends serene_object 
	{

		public $error;
		private $ch;

		function __construct($url)
		{
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_URL, $url);
		}

		function set_option($option, $value)
		{
			curl_setopt($this->ch, $option, $value);
		}

		public function execute()
		{
			if ($result = curl_exec($this->ch))
			{
				return $result;
			}
			else
			{
				$this->error = curl_error($this->ch);
			}
		}

		function __destruct()
		{
			curl_close($this->ch);
		}
	}
?>