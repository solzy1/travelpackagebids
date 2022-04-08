<?php
	// start up eloquent
	require_once '_comments.php';

	use Controllers\Comments;
	use Controllers\Replies;

	Class Create_Comments extends _Comments {
		private $user_id;
		private $comment;

		function __construct($comment) {
			$this->comment = $comment;

			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function comment(){
			$comment_id = $this->comment->get_comment_id(); // get comment id
			$package_id = $this->comment->get_package_id(); // get package id
			$user_id = $this->user_id;
			$comment = $this->comment->get_comment(); // get comment

			// if comment is not empty
			if($comment && $package_id){
				$comment = Comments::create($package_id, $user_id, $comment);

				// if it's a reply to a comment
				// comment was created
				if(isset($comment->id)){
					// if comment, is a reply save as reply
					if($comment_id > 0){
						$reply_id = $comment->id; // reply is, is the comment_id that was just saved
						$reply = Replies::create($comment_id, $reply_id);

						if(isset($reply->id))
							$this->success();
						else{
							$this->failure();
						}
					}
					else{
						$this->success();
					}
				}
				else{
					$this->failure();
				}
			}
			else{
				$this->failure();
			}
		}

		public function failure(){
			echo 'failed';
		}

		public function success(){
			echo 'success';
		}
	}
?>