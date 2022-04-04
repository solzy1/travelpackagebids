<?php 
	class Profile extends _Profile {
		public $email;
		public $pass;

		function __construct($email, $pass) {
			$this->email = $email;
			$this->pass = $pass;
		}

		// SET & GET FUNCTIONS
		function set_email(){
			// validate userinput
			$this->validate('email', $this->email);
		}

		function set_password(){
			// validate userinput
			$this->validate('string', $this->pass);
		}

		function get_email(){
			$this->set_email();

			return $this->email;
		}

		function get_pass(){
			$this->set_password();

			return $this->pass;
		}
	}
?>