<?php
if(!isset($_POST['submit']))
{
	echo "error; you need to submit the form!";
  exit;
}

$name = $_POST['name'];
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // add filtration to email address input
$message = $_POST['message'];
$url = $_POST['url'];

// Validate email first
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo ("$email is not valid; try again.");
  exit;
}

// if antispam url field is not empty send fake success message; if antispam url field is empty send the message 
if(!empty($url)) {  
 echo "Thanks for your submission.  We will be in contact with you shortly.";

}
  elseif(empty($name)||empty($email)) {
    echo "Name and email are mandatory!";
  
}

  else {

  function clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
  }
    
    $email_from = 'some@email.com';// email to use to send message FROM
    $email_subject = "Senior Insurance Depot - Request";
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";

    $to = "your@email.com, another@email.com";// email addresses to send message TO
    $headers = "From: $email_from \r\n";
    $headers .= "Reply-To: $email \r\n";

    //Send the email!
    mail($to,$email_subject,$email_message,$headers);

    //done. redirect to thank-you page.
    header('Location: thank-you.html');

}

?> 
