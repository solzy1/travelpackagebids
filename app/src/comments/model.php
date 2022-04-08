<?php 
	class Comment extends _Comments {
		private $comment_id;
		private $package_id;
		private $comment;

		public function __construct($comment, $package_id, $comment_id) {
			$this->comment = $comment;
			$this->package_id = $package_id;
			$this->comment_id = $comment_id;
		}

		// SET & GET FUNCTIONS
		public function set_comment(){
			// validate userinput
			$this->comment = $this->validate('string', $this->comment);
		}

		public function set_package_id(){
			// validate userinput
			$this->package_id = $this->validate('int', $this->package_id);
		}

		public function set_comment_id(){
			// validate userinput
			$this->comment_id = $this->validate('int', $this->comment_id);
		}

		// GET
		public function get_comment(){
			$this->set_comment();

			return $this->comment;
		}
		
		public function get_package_id(){
			$this->set_package_id();

			return $this->package_id;
		}

		public function get_comment_id(){
			$this->set_comment_id();

			return $this->comment_id;
		}
	}
?>