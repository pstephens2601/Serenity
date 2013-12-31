<?php

	/*-----------------------------------------------------------------------------------------------
	Serinity - "Serene PHP made easy."
	
	The validate class handles all input validation for the validators specified by your models.
	------------------------------------------------------------------------------------------------*/

	class validate
	{
		
		public static function length($value, $length, $type)
		{
			if ($type == 'max')
			{
				if (strlen($value) < $length)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			elseif ($type == 'min')
			{
				if (strlen($value) < $length)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}

		public static function is_present($value)
		{
			if (strlen($value)  > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public static function has_form($value, $regx)
		{
			if (preg_match("/" . $regx . "/", $value) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public static function match($val1, $val2)
		{
			if ($val1 === $val2)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
 
	}

?>