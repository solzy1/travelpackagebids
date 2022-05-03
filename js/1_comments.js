class Comments{
	constructor(){
		this.loader = '<div class="d-flex justify-content-center">'+
							'<div class="spinner-border" role="status">'+
								'<span class="sr-only">Loading...</span>'+
							'</div>'+
						'</div>';
	}

	sign_up_first(){
    	let sign_up_first = '<p>Hello, <br>You cannot make a comment, on this package, unless you '+
    		'<a href="/user/sign-up.php" class="btn-link" style="color: #03C6C1;"'+
    		'target="_blank">Sign up</a>.</p>'+
            '<p>Kindly <a href="/user/sign-up.php" class="btn-link" '+
            'style="color: #03C6C1;" target="_blank">Sign up</a> now, to post your comment.</p>';

    	$signupfirst = $('#sign-up-first').html(sign_up_first);
	}

	prevent_reply(_this){
		const _comments = new Comments();

		// click event for the container of 'reply button'
        // check if user is loggedin
        let is_userloggedin = $.trim($("#user-loggedin").val());

        // if user isn't logged-in, else
        if(is_userloggedin=='no'){
        	$('#modal-signup-now').modal('show');
        }
        else{
        	$('.comment-response:first').css('opacity', 0).html(''); // clear the new comment response message
        	_comments.show_replycomment(_this);
        }
	}

	show_replycomment(_this){
		let reply_comment_container = $(_this).next('.reply-comment');
		let create_comment_content = '';
		let comment_idtag = '';

		// populate, reply-comment-container, if empty, else remove content
		if($.trim(reply_comment_container.html())===""){
			// append comment id, to the reply-comment section
			let comment_id = $.trim($(_this).children('.replycomment').children('.comment_id').val()); // get comment id
			comment_idtag = '<input type="hidden" class="comment_id" value="'+comment_id+'">'; // create comment id tag

			// add the create-comment-section to reply-comment-section
			create_comment_content = $('#create-comment-content').html(); // get the form for sending comment
		}
		
		reply_comment_container.html(create_comment_content).append(comment_idtag);
	}

	send_comment(_this){
		let sendbtn_parent = $(_this).parent(); // parent of the send_comment button
		let comment = $.trim(sendbtn_parent.prev().children('.user-comment').val()); // get user comment

		if(comment!==""){
			let comment_id = 0; // hold the comment id, for reply
			let package_id = $.trim($('#package_id').val()); // get package id
			
			let comment_idtag = sendbtn_parent.next('.comment_id');

			if(comment_idtag.html()!==undefined){
				comment_id = $.trim(comment_idtag.val());
			}

			const _comments = new Comments();

			_comments.post_comment(comment, comment_id, package_id);
		}
	}

	post_comment(comment, comment_id, package_id){
		let user_comment = {comment: comment, package_id: package_id, comment_id: comment_id};

        $.post("https://travelpackagebids.com/app/src/comments/receive.php", user_comment, function(result){
        	// console.log($.trim(result));
        	// const _comments = new Comments();

        	// _comments.
        	result = $.trim(result);

        	comment_result(result, 'Your comment has been saved',
        	 'Your comment was not saved. Please try again.');

        	if(result==='success'){
        		// $("#package-comments").html(''); // clear comments
        		$('.loading-comments').html(this.loader); // show loading comments

        		// load comments
	            const _comment = new Comments();

	            _comment.load_comments(package_id);
        	}
        });
	}

	load_comments(package_id){
		let load = {package_id: package_id, allow: 'yes'};

        $.post("https://travelpackagebids.com/app/src/package/get_comments.php", load, function(result){
            // const _comments = new Comments();

            $('.loading-comments').html(''); // hide loading

            $('#package-comments').html(result);
            
    		let no_ofcomments = $(".guestcommentdisplay").length; // no of comments
    		$(".noofcomments").text(no_ofcomments+' Comment(s)'); // update the no of comments
        });
	}

    on_modalshown(){
        let create_bid = document.getElementById('modal-signup-now');

        create_bid.addEventListener('shown.bs.modal', function () {
        	const _comments = new Comments();

        	_comments.sign_up_first();
        })
    }

    prevent_comment(){
    	$(".prevent-comment").click(function(){
        	const _comments = new Comments();

        	_comments.sign_up_first(); // what happens when 'modal is shown'
    	});
    }
}