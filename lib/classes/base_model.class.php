<?php
	/*-------------------------------------------------------------------------------
		Serenity - "Serene PHP made easy."

		Developer: Patrick Stephens
		Email: pstephens2601@gmail.com
		Github Repository: https://github.com/pstephens2601/Serenity
		Creation Date: 8-17-2013
		Last Edit Date: 5-5-2014

		Class Notes - The baseModel class forms the framework for all of your models.
		When creating a new model it is required that it is a child of the baseModel 
		class.
	---------------------------------------------------------------------------------*/

	class baseModel extends sereneObject 
	{

		protected $id; //holds the uid for the model
		protected $db; //used to hold the database object
		protected $form; //holds the name of the form if one has been submitted
		protected $is_valid = true; //used to determine if the current object can be saved, can be set to false using a validate method.
		protected $validation_errors = array();
		protected $validation_messages = array();
		protected $messages = array();
		protected $validators = array();

		/*----------------------------------------------------------------------------------
			Upon loading the baseModel class automatically checks for form submissions and
			creates a new database object to establish a connection the the database.
		-----------------------------------------------------------------------------------*/
		function __construct()
		{
			if (HOST != '' && USER != '' && PASSWORD != '' && DATABASE != '')
			{
				//database constant values set in config/db_config.php
				$this->db = new database(HOST, USER, PASSWORD, DATABASE);
			}
		}

		function find()
		{
			$num_args = func_num_args();

			if ($num_args == 4)
			{
				$args = func_get_args();

				$query = $this->build_query('select',  $args);
				if ($this->get_all($query))
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			elseif ($num_args == 1)
			{
				$id = func_get_arg(0);

				$query = $this->build_query('select',  $id);
				
				if ($this->get_all($query))
				{
					return true;
				}
				else
				{
					return false;
				}
			}

			//if $result includes at least one row then $is_found = true
			//$is_found = ($result->num_rows > 0) ? true : false;
		}

		/*--------------------------------------------------------------------
			This method locates a group of records in the database. It may be
		 	passed either 0 or 2 arguments.  If it is passed 0 arguments it
		 	will return all rows in the table.  If it is passed 2 it will
		 	return all rows where the value contained in the column given in
		 	argument 0 is equal to argument 1.
		 --------------------------------------------------------------------*/
		function find_all()
		{

			$num_args = func_num_args();

			if ($num_args == 2)
			{
				$col = func_get_arg(0);
				$val = func_get_arg(1);

				$query = "SELECT * FROM " . get_class($this) . "s WHERE $col ='$val'";

				if ($results = $this->db->query($query))
				{
					$result_set = array();

					while($result = $results->fetch_assoc())
					{
						$result_set[] = $result;
					}

					return $result_set;
				}
				else
				{
					if (ENVIRONMENT == 'development')
					{
						$message = "Serene Error (Stay Calm!): ";
						$message .= "There was an error when executing " . __METHOD__ . "() on line " . __LINE__;
						$message .= "- the database query failed for the following reason (" . $this->db->error . ").";

						$this->print_error($message);
					}
					else
					{
						die(PRODUCTION_ERROR_MESSAGE);
					}
				}
			}
			elseif ($num_args == 0)
			{
				$query = "SELECT * FROM " . get_class($this) . 's';

				if ($results = $this->db->query($query))
				{
					$result_set = array();

					while($result = $results->fetch_assoc())
					{
						$result_set[] = $result;
					}

					return $result_set;
				}
				else
				{
					if (ENVIRONMENT == 'development')
					{
						$message = "Serene Error (Stay Calm!): ";
						$message .= "There was an error when executing " . __METHOD__ . "() on line " . __LINE__;
						$message .= "- the database query failed for the following reason (" . $this->db->error . ").";

						$this->print_error($message);
					}
					else
					{
						die(PRODUCTION_ERROR_MESSAGE);
					}
				}
			}
			else
			{
				if (ENVIRONMENT == 'development')
				{
					$this->print_error("Serene Error (Stay Calm!): invalid number of arguments passed to " . __METHOD__ . "() on line " . __LINE__);
				}
				else
				{
					die(PRODUCTION_ERROR_MESSAGE);
				}
			}

		}

		/*---------------------------------------------------------------------------------
			Used to see if a matching value already exists in the database.
		----------------------------------------------------------------------------------*/
		function is_unique($value) {

			$query = 'SELECT * FROM ' . get_class($this) . 's WHERE ' . $value . " = '" .$this->$value . "'";

			if ($result = $this->db->query($query))
			{
				if ($result->num_rows > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				die('Serenity Error: is_unique returned QUERY FAILED! ' . $this->db->error);
			}
		}

		/*------------------------------------------------------------------------------------------
			The save method is used to insert new all information for the model into the database.
			$is_valid must be set to true for this method to work.
 			NOTE: the ability to update the database will be added later.
 		--------------------------------------------------------------------------------------------*/
		function save() 
		{
			if (func_num_args() >= 1)
			{
				//get any params passed to function
				$params = func_get_arg(0);
				// Load params into object properties
				foreach ($params as $key => $value) {
					if ($this->$key = $value)
					{

					}
				}

				// Check information stored in object properties againts validators.
				$this->run_validation;

				// Insert data into the database.
				if ($this->is_valid)
				{
					$insert_query = $this->build_query('insert');
		
					if ($this->db->query($insert_query))
					{
						$this->id = $this->db->insert_id;
						return true;
					}
					else
					{
						echo "Attempted query = " . $insert_query;
						die($this->db->error);
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				// Check information stored in object properties againts validators.
				$this->run_validation();

				// Insert data into the database.
				if ($this->is_valid)
				{
					$insert_query = $this->build_query('insert');
		
					if ($this->db->query($insert_query))
					{
						$this->id = $this->db->insert_id;
						return true;
					}
					else
					{
						echo "Attempted query = " . $insert_query;
						die($this->db->error);
						return false;
					}
				}
				else
				{
					return false;
				}
			}
		}

		function get_id()
		{
			return $this->id;
		}

		function messages()
		{
			return $this->messages;
		}

		function form()
		{
			return $this->form;
		}

		function logout()
		{
			session_destroy();
			header('Location: ' . ROOT);
		}

		function get_associations($table, $value, $return)
		{
			$table_data = explode(':', $table);
			$table = $table_data[1];

			$where_data = explode(':',$value);
			$where_data = explode('=', $where_data[1]);
			$col = $where_data[0];
			$val = $where_data[1];

			$return_data = explode(':', $return);
			$return = explode(',', $return_data[1]);

			$query = "SELECT ";

			$num_returns = count($return);
			$counter = 0;

			foreach ($return as $key => $value) {
				$query .= $value;
				if ($counter < $num_returns - 1) { $query .= ', '; }
				$counter ++;
			}

			
			$query .= ' FROM ' . $table . ' WHERE ' . $col . " = '" . $val . "'";

			if ($result = $this->db->query($query))
			{
				while ($line = $result->fetch_assoc())
				{
					$associations[] = $line;
				}
				if (isset($associations))
				{
					return $associations;
				}
			}
			else
			{
				echo $query;
				die($this->db->error);
			}
		}

		protected function build_session_key($extension)
		{
			$class = get_class($this);
			$key = $class . ':' . $extension;
			return $key;
		}

		//Example function call: $this->get_associations('from_table:used_by', 'where:user_id=' . $user->id, 'return:budget_id');
		

		//	Checks to see if a form has been submitted using $_POST.  If one has been submitted it
		//	places the values entered into the appropriate child class attributes.

		protected function validate()
		{

			$count = func_num_args();
			$validator = array();

			for ($i=0; $i < $count; $i++) { 
				$validator[] = func_get_arg($i);
			}

			$this->validators[] = $validator;
		}

		/*------------------------------------------------------
			Used to add validation messages that can be displayed 
			when a field does not pass validation.
		--------------------------------------------------------*/
		protected function add_validation_message($variable, $validator, $message)
		{
			$validation_message = array($variable, $validator, $message);

			$this->validation_messages[] = $validation_message;
		}

		/*------------------------------------------------------
			Public method that runs the form validations 
			declared in $validators and returns a boolean
			value set to true if the form validates and
			set to false if it does not.
		-------------------------------------------------------*/
		public function form_validates() {
			return $this->run_validation();
		}

		/*------------------------------------------------------
			Runs the form validations declared in $validators.
		-------------------------------------------------------*/
		protected function run_validation()
		{
			$var;
			
			foreach ($this->validators as $validator)
			{
				foreach ($validator as $current_action)
				{
					$action_pair = explode(':', $current_action);
				
					//if the action pair is the variable name, or the keyword is_present
					if (count($action_pair) == 1)
					{
						if ($action_pair[0] == 'unique')
						{
							if ($this->is_unique($var))
							{
								$this->check_for_validation_message($var, 'unique');
								$this->is_valid = false;
							}
						}
						else
						{
							//set the name of the variable being checked
							$var = $action_pair[0]; 
						}
					}
					else
					{
						switch ($action_pair[0])
						{
							case 'min-length':
								if (!validate::length($this->$var, $action_pair[1], 'min'))
								{
									$this->check_for_validation_message($var, 'min-length');
									$this->is_valid = false;
									return false;
								}
								else {
									return true;
								}
								break;
							case 'max-length':
								if (!validate::length($this->$var, $action_pair[1], 'max'))
								{
									$this->check_for_validation_message($var, 'max-length');
									$this->is_valid = false;
									return false;
								}
								else {
									return true;
								}
								break;
							case 'format':
								if (!validate::has_form($this->$var, $action_pair[1]))
								{
									$this->check_for_validation_message($var, 'format');
									$this->is_valid = false;
									return false;
								}
								else {
									return true;
								}
								break;
							case 'match':

								if (!validate::match($this->$var, $this->$action_pair[1]))
								{
									$this->check_for_validation_message($var, 'match');
									$this->is_valid = false;
									return false;
								}
								else {
									return true;
								}
								break;
							default:
								if (ENVIRONMENT == 'development')
								{
									$message = "Serene Error (Stay Calm!): ";
									$message .= "There was an error when executing " . __METHOD__ . "() on line " . __LINE__;
									$message .= "- " . $action_pair[0] . " is an invalid validation method.";

									$this->print_error($message);
								}
								else
								{
									die(PRODUCTION_ERROR_MESSAGE);
								}	
						}
					}
				}
			}
		}

		#	Used to build database queries.
		#	Accepts the following values for $type:
		#	select - used to build a SELECT query.
		#	insert - used to build an INSERT INTO query.
		private function build_query($type)
		{
			if ($type == 'insert')
			{
				$query = 'INSERT INTO ' . get_class($this) . 's (';

				$public_properties = $this->get_public_properties();

				$is_first = true;
				foreach ($this as $key => $value) {
					if (($key != 'id') && ($key != 'db') && (in_array($key, $public_properties)))
					{ 
						if ($is_first == false) { $query .= ', '; }
						$query .= $key;
					}

					$is_first = false;
				}

				$query .= ') VALUES (';

				$is_first = true;
				foreach ($this as $key => $value) {
					if (($key != 'id') && ($key != 'db') && (in_array($key, $public_properties)))
					{ 
						if ($is_first == false) { $query .= ', '; }

						if ($value == 'now')
						{
							$query .= 'NOW()';
						}
						else
						{
							$query .= "'" . $value . "'";
						}
					}

					$is_first = false;
				}
				$query .= ')';

				return $query;
			}
			elseif ($type == 'select')
			{
 				if (is_array(func_get_arg(1)))
				{
					$args = func_get_arg(1);
					
					$query = 'SELECT * FROM ' . get_class($this) . "s WHERE " . $args[0] . " = '" . $args[1] . "' AND " . $args[2] . " = '" . $args[3] . "'";

					return $query;
				}
				elseif (func_num_args() == 2)
				{
					$id = func_get_arg(1);

					$query = 'SELECT * FROM ' . get_class($this) . "s WHERE id = '" . $id . "'";

					return $query;
				}
			}
			else {
				if (ENVIRONMENT == 'development')
				{
					$this->print_error("Serene Error (Stay Calm!): Invalid type given for build_query() in class baseModel.");
				}
				else
				{
					die(PRODUCTION_ERROR_MESSAGE);
				}
			}
		}

		#	This method is used to get a list of the public properties contained in the child class.
		#	The list of public properties can be used to determine, which columns exist in the database as
		#	properties that do not corespond to a database column should be protected or private.
		private function get_public_properties()
		{
			$reflection = new ReflectionObject($this);
			$properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

			$public_properties = array();

			foreach ($properties as $property) {
				$public_properties[] = $property->getName();
			}
	
			return $public_properties;
		}

		private function get_all($query)
		{
			if ($result = $this->db->query($query))
			{
				if ($result->num_rows > 0)
				{
					$array = $result->fetch_assoc();

					foreach ($array as $key => $value) {
						$this->$key = $value;
					}

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				echo "Attempted query = " . $query;
				die($this->db->error);
			}
		}

		/*-------------------------------------------------------------
			Searches through all of the model's validation messages to
			see if there is one that applies and puts it into messages
			if there is.
		---------------------------------------------------------------*/
		private function check_for_validation_message($variable, $validation)
		{
			foreach($this->validation_messages as $validation_message)
			{
				if ($validation_message[0] == $variable && $validation_message[1] == $validation)
				{
					//Search messages to see if the message already exists.
					$message_exists = false;

					foreach($this->messages as $message)
					{
						if ($message == $validation_message[2])
						{
							$message_exists = true;
						}
					}

					if ($message_exists == false)
					{
						$this->messages[] = $validation_message[2];
					}
				}
			}
		}
	}
?>