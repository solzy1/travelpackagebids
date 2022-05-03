<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';
    
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
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                // $mail->SMTPDebug = 1;
                // SMTP::DEBUG_SERVER;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'travelpackagebids.com';              // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'info@travelpackagebids.com';        // SMTP username
                $mail->Password   = 'travelpackageauctionorbidding';              // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
                $mail->Port       = 465;
                
                //Recipients
                $mail->setFrom('info@travelpackagebids.com', 'TravelPackageBids');
                
                $to = $this->receiver_email;
                $receiver_name = $this->get_name($to);
                
                $subject = $this->subject;
    
                $message = $this->bodytemplate();
                
                $mail->addAddress($to, $receiver_name);    // Add a recipient
              
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
    
                // altbody (plain html)
                $mail->AltBody = $message;
    
                $mail->send();
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
            }
		}
		
        function get_name($email){
            $split = explode('@', $email);
            
            return $split[0];
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