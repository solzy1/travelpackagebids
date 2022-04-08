class Bids{
	constructor(){

    }

    // CREATE BID/OFFER
    show_createoffer(){ // append package_id (on click), to input tag (package-id)
        $('.place-bid').click(function(){
            let package_id = $.trim($(this).children('.package_id').val());
            
            $("#package-id").val(package_id); // add package_id to the form

            // check if user is loggedin
            let is_userloggedin = $.trim($("#user-loggedin").val());
            let modal = '#create-package-bid'; // selector for create bid modal

            // if user isn't logged-in
            if(is_userloggedin=='no'){
                let sign_up_first = '<p>Hello, <br>You cannot place a Bid, on this package, unless you '+
                    '<a href="/user/sign-up.php" class="btn-link" style="color: #03C6C1;"'+
                    'target="_blank">Sign up</a>.</p>'+
                    '<p>Kindly <a href="/user/sign-up.php" class="btn-link" '+
                    'style="color: #03C6C1;" target="_blank">Sign up</a> now, to PLACE BID.</p>';

                $('#sign-up-first').html(sign_up_first);

                modal = '#modal-signup-now';
            }
            
            $(modal).modal('show');
        });
    }

    create_offer(){
        $('#bid-submit').click(function(){
            let offer = $("#bid-offer").val();

            // if an offer was made
            if($.trim(offer)!=''){
                const _bid = new Bids();

                let package_id = $("#package-id").val();

                _bid.send_offer(package_id, offer); // send offer
            }
    	});
    }

    // submit_offer(){
    //     $('#bid-form').submit(function (evt) {
    //         // prevent from from submitting (the form is used for validation, purposes)
    //         evt.preventDefault();

    //         // BIDS
    //         const _bid = new Bids();

    //         _bid.create_offer();
    //     });
    // }

    send_offer(package_id, offer){
        let bid = {package_id: package_id, offer: offer};

        $.post("/app/src/bids/receive.php", bid, function(result){
            const _bid = new Bids();

            _bid.report_status($.trim(result));
        });
    }

    report_status(result){
        let status = {icon: '', message: '', backcolor: ''};

        if(result=='success'){
            status.icon = 'check';
            status.message = 'Your bid was received!';
            status.backcolor = 'green';
        }
        else{
            status.icon = 'exclamation';
            status.message = 'Your bid was not received. Please try again, later.';
            status.backcolor = 'red';
        }

        let content = '<i class="fa-solid fa-circle-'+status.icon+'"></i> <span>'+status.message+'</span>';

        $('.create-bid-status')
        .html(content)
        .css({'opacity': 1, 'background-color': status.backcolor});
    }

    on_modalshown(){
        let create_bid = document.getElementById('create-package-bid');

        create_bid.addEventListener('shown.bs.modal', function () {
            $('#bid-offer').focus(); // focus on the 'make an offer', input tag
        })
    }

    on_modalhidden(){
        let create_bid = document.getElementById('create-package-bid');

        create_bid.addEventListener('hidden.bs.modal', function () {
            $('.create-bid-status').css('opacity', 0);
        })
    }
}