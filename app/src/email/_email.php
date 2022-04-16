<?php 
	// namespace Email;
	
	class Email {
		private $receiver_email;
		private $subject;
		private $body;

		function __construct($receiver_email, $subject, $body) {
			$this->receiver_email = $receiver_email;
			$this->subject = $subject;
			$this->body = $body;
		}

		function send(){
			$to = $this->receiver_email;
			$subject = $this->subject;

			$message = $this->bodytemplate();

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <webuildwebsitesfast@gmail.com>' . "\r\n";

			mail($to, $subject, $message, $headers);
		}
		
		function bodytemplate(){
		
		    return '<!DOCTYPE html> 
            <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
            
                    <!-- Latest compiled and minified CSS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
            
                    <style>
                    body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
                    </style>
                </head>
                <body style="align-items: middle">
                    <div class="container-fluid" style="background-color: white;border-radius: 10px;padding: 0px  !important;margin: 10px 20px 10px 20px !important;height: inherit;max-width: 500px;width: inherit;">
                        <div class="row" style="color: black;padding: 10px 0 4px 0;font-size: 15px;margin: 0;border-radius: 10px 10px 0px 0px;">
                            <p class="col-sm-12 col-md-6 col-lg-6" style="font-weight: bold;text-align: center">TravelPackageBids</p>
                        </div>
                        <hr>
                        
                        <!-- main body -->
                        <div class="row" style="margin: 10px 10px 10px 10px;font-size: 15px;">
                            '.$this->body.'
                        </div>
                    </div>
            
            
                    <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
                </body>
            
            </html>';
		}
	}
?>