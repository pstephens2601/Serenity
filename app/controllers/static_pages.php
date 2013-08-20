<?php
	class static_pages extends baseController
	{
		function aboutme()
		{
			$this->provide('title', '| About Me');
		}

		function home()
		{
			$this->provide('title', '| Home');
		}
	}
?>