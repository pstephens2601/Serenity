<?php
	class budget extends baseModel
	{

		public $name;
		public $created;
		public $created_by;
		public $last_modified;
		public $type;
		protected $last_modified_by;
		protected $categories;
		protected $users;
		protected $current_user;

		function __construct() {
			parent::__construct();

			$this->validate('budget_name', 'is_present','min-length:3', 'max-length:60', 'format:[a-zA-Z0-9 ]$');
			$this->validate('type', 'is_present');
			$this->get_categories();
			$this->get_transactions();
		}

		function set_created_by($id)
		{
			$this->created_by = $id;
		}

		function save_association($access_level)
		{
			$query = "INSERT INTO used_by ( budget_id, user_id, created, access_level ) VALUES ( '" . $this->id . "', '" . $this->created_by . "', NOW(), '" . $access_level . "')";

			if ($this->db->query($query))
			{

			}
			else
			{
				echo "Attempted Query = " . $query . "<br>";
				die($this->db->error);
			}
		}

		private function get_users()
		{

		}

		private function get_categories()
		{

		}

		private function get_transactions()
		{

		}



	}
?>