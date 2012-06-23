<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	function send_email($recipient, $sender, $subject, $message)
	{
	    require_once("phpmailer/class.phpmailer.php");
	    $mail = new PHPMailer();
	    $body = $message;
	    $mail->IsSMTP();
	    $mail->FromName = "Rakbuku";
	    $mail->From = $sender;
	    $mail->Subject = $subject;
	    $mail->AltBody = strip_tags($message);
	    $mail->MsgHTML($body);
	    $mail->AddAddress($recipient);
	
	        // added by jerome 5th June 2011
	        $mail->SMTPAuth   = true;                  // enable SMTP authentication
	        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	        $mail->Port       = 465;                   // set the SMTP port
	
	        $mail->Username   = "magnoworks@hasriyan.com";  // GMAIL username
	        $mail->Password   = "221082010183";            // GMAIL password
	
	        // end of added by jerome
	    if ( ! $mail->Send())
	    {
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}