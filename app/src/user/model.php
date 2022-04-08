<?php 
	// namespace User;

	class User extends _User {
		private $email;
		private $pass;
		private $re_pass;

		function __construct($email, $pass, $re_pass = '') {
			$this->email = $email;
			$this->pass = $pass;
			$this->re_pass = $re_pass;
		}

		// SET & GET FUNCTIONS
		function set_email(){
			// validate userinput
			$this->email = $this->validate('email', $this->email);
		}

		function set_password(){
			// validate userinput
			$this->pass = $this->validate('string', $this->pass);
		}

		function set_repassword(){
			// validate userinput
			$this->re_pass = $this->validate('string', $this->re_pass);
		}

		function get_email(){
			$this->set_email();

			return $this->email;
		}

		function get_pass(){
			$this->set_password();

			return $this->pass;
		}

		function get_repass(){
			$this->set_repassword();

			return $this->re_pass;
		}
	}
?>