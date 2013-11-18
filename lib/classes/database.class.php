<?php
	/*-----------------------------------------------------------------------------------------------
		Serinity - "Serene PHP made easy."

		Built on top of the mysqli class the database class handles interaction with the
	 	database.  A database object is created in the constructor of every model and can be accessed
	 	from within the model class using $this->db. 
	------------------------------------------------------------------------------------------------*/
	

	class database extends mysqli{

		function __construct($host, $user, $pass, $db)
		{
			
			parent::__construct($host, $user, $pass, $db);

			if (mysqli_connect_error())
			{
				//provides detailed error information in the development environment.
				if (ENVIRONMENT == 'development')
				{
					die('phpMojo Error-> Database Connection Error: Class: "' . get_class($this) . '"" has experienced the following error: ' . mysqli_connect_error());
				}
				else
				{
					die('SERVER CONNECTION ERROR: Please try again later.');
				}
			}
			else {
				return true;
			}
		}

		function mojo_query($query)
		{
			if($query_result = $this->query($this->real_escape_string($query)))
			{
				if (func_num_args() > 1)
				{

				}
			}
			else
			{
				echo "phpMojo Error-> Database query error for: $query. <br>";
				die($this->error);
			}
		}

	}
?>