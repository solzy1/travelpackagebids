class Bids{
	constructor(){

    }
    
    enable_offer(_this){
        let is_owner = $(_this).children('.is-owner');
        let offer = $("#bid-submit, #bid-offer, #bid-deadline");
        
        if(is_owner.val()!==undefined){
            offer.addClass('disabled')
                .attr('disabled', 'disabled')
                .css('cursor', 'not-allowed');
        }
        else {
            offer.removeClass('disabled')
                .removeAttr('disabled')
                .css('cursor', 'initial');

            $("#bid-submit").css('cursor', 'pointer'); 
        }
    }
    
    // CREATE BID/OFFER
    show_createoffer(){ // append package_id (on click), to input tag (package-id)
        $('.place-bid:not(.no-bidding)').click(function(){
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
            else{
                const _bids = new Bids();
                
                _bids.enable_offer(this); // enable or disable the make an offer fields, depending on who wants to place a bid

                // get the offers so far and display it, for the user
                let is_owner = _bids.is_owner(this);
                _bids.get_offers(package_id, is_owner); 
            }
            
            $(modal).modal('show');
        });
    }

    is_owner(_this){
        let is_owner = $(_this).children('.is-owner');
        // let offer = $("#bid-submit, #bid-offer");
        
        if(is_owner.val()!==undefined){
            return $.trim(is_owner.val());
        }

        return '';
    }

    create_offer(){
        $('#bid-submit').click(function(){
            let offer = $.trim($("#bid-offer").val());
            let deadline = $.trim($("#bid-deadline").val());
            const _bid = new Bids();

            // if an offer was made
            if(offer!=='' && deadline!==''){
                let package_id = $("#package-id").val();

                let bid = {package_id: package_id, offer: offer, deadline: deadline};

                // hide the error/response message display
                $('.create-bid-status').html('').css({'opacity': 0});

                _bid.send_offer(bid); // send offer
            }
            else {
                _bid.report_status('failure', 0, 'Both Offer and Expiration must be set, before Sending Offer!');
            }
    	});
    }

    refresh_bids(package_id){
        $.post("https://travelpackagebids.com/app/src/package/get-bids.php", {package_id: package_id}, function(result){
            $("#package-bids-display").html(result);
        });
    }

    send_offer(bid){
        $.post("https://travelpackagebids.com/app/src/bids/receive.php", bid, function(result){
            const _bid = new Bids();

            _bid.report_status($.trim(result), bid.package_id, 'Your bid was not received. Please try again, later.');
        });
    }

    report_status(result, package_id, failure){
        let status = {icon: '', message: '', backcolor: ''};

        if(result=='success'){
            status.icon = 'check';
            status.message = 'Your bid was received!';
            status.backcolor = 'green';

            // reload the bids
            const _bids = new Bids();
            
            // get the offers so far and display it, for the user
            _bids.get_offers(package_id, '');

            // refresh the bids on the package page
            if($("#package-bids-display").length > 0){
                _bids.refresh_bids(package_id);
            }
        }
        else{
            status.icon = 'exclamation';
            status.message = failure;
            status.backcolor = 'red';
        }

        let content = '<i class="fa-solid fa-circle-'+status.icon+'"></i> <span style="margin-left: 2px;">' + 
            status.message + '</span>';

        $('.create-bid-status')
        .html(content)
        .css({'opacity': 1, 'background-color': status.backcolor});
    }

    get_offers(package_id, is_owner){
        let bid = {package_id: package_id, is_owner: is_owner};

        $.post("https://travelpackagebids.com/app/src/bids/get-bids.php", bid, function(result){
            const _bid = new Bids();

            _bid.getoffers_response($.trim(result));
        });
    }

    getoffers_response(result){
        $('#package-bids').html(result);
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
            $('#package-bids').html('');
        })
    }

    // ACTIVATE AND DEACTIVATE BID
    activate(_this){
        if(_this!==undefined){
            let is_activate = $(_this).hasClass('activate-bid');
            let status = is_activate ? 'active' : 'inactive';

            const _bid = new Bids();

            let id = $.trim($(_this).parent().children('.id').val());

            let url = 'https://travelpackagebids.com/app/src/bids/update-status.php';

            let data = {id: id, status: status};

            _bid.send_statusrequest(data, url, _this);
        }
    }

    send_statusrequest(data, url, _this){
        $.post(url, data, function(result){
            if($.trim(result)=='success'){
                const _bid = new Bids();

                _bid.toggle_btn(data.id, _this); // de-activate button
            }
        });
    }

    toggle_btn(id, _this){
        if(id > 0){
            $('.toggle-status-'+id).css({'pointer-events': '', 'text-decoration': '', 
                'cursor': 'pointer', 'opacity': ''}); // activate all
        }

        $(_this).css({'pointer-events': 'none', 'text-decoration': 'none', 
                'cursor': 'not-allowed', 'opacity': 0.4}); // deactivate selected
    }

    // PREVENT BIDDING
    prevent_bidding(){
        $(".place-bid.no-bidding").click(function(){
            let parent = $(this).parent();

            parent.next('.blocked-message').removeClass('d-none');
        })
    }
}