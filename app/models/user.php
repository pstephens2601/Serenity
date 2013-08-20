<?php
	
	class user extends baseModel
	{

		public $first_name;
		public $last_name;
		public $email;
		protected $password;
		protected $password_confirmation;
		private $login_status = false;
		public $password_hash;

		function __construct()
		{
			parent::__construct();
			$this->authenticate_user();
			$this->validate('first_name', 'name:first name', 'min-length:2', 'max-length:30', 'format:[a-zA-Z]');
			$this->validate('last_name','name:last name', 'min-length:2', 'max-length:30', 'format:[a-zA-Z]');
			$this->validate('email', 'check:unique');
			$this->validate('password','match:' . $this->password_confirmation);
			$this->validate('email', 'min-length:7', 'max-length:60', 'format:[a-zA-Z]');
			$this->validate('password', 'min-length:6', 'max-length:12', 'format:[a-zA-Z0-9]');
		}

		function secure_password()
		{
			$this->password_hash = md5($this->password);
		}

		function set_password($password)
		{
			$this->password = $password;
		}

		function authenticate_user()
		{
			$key = $this->build_session_key('id');

			if (isset($_SESSION[$key]))
			{
				$this->login_status = true;
				$this->id = $_SESSION[$key];
			}
		}
		
		function check_login_info()
		{
			$this->secure_password();
			$key = $this->build_session_key('id');

			if ($this->find('email', $this->email, 'password_hash', $this->password_hash))
			{
				$_SESSION[$key] = $this->id;
				$this->authenticate_user();
				return true;
			}
			else
			{
				$this->messages[] = 'You have entered an email address, or password that does not match our records.';
				return false;
			}
		}
		

		function is_logged()
		{
			return $this->login_status;
		}
	}

?>