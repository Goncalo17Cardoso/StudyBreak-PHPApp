 <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../inc/vendor/autoload.php';

    class utils {
        public static function generateLink($length = 100) {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); 
            $alphaLength = strlen($alphabet) - 1; 
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }

        public function sendEmail($from_name, $from_email, $to_name, $to_email, $subject, $message) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();                                            
                $mail->Host       = GMAIL_HOST;                     
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = GMAIL_EMAIL;                     
                $mail->Password   = GMAIL_TOKEN;                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                $mail->Port       = 465;                                    

                //Recipients
                //$mail->setFrom(GMAIL_EMAIL, $from_name);
                //$mail->addAddress(GMAIL_EMAIL, $to_name);  
                
                $mail->setFrom($from_email, $from_name);
                $mail->addAddress($to_email, $to_name);   

                //Content
                $mail->isHTML(true);                                  
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = $message;

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
            }
        }
    }
?>