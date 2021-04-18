<?php

require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$user = 'noreplyhrptlintasmediatama@gmail.com'; 

$name = $_POST['user-name'];
$email = $_POST['user-email'];
$subject = "Hi WAWA, From natanawa.web.id";
$message = $_POST['user-message'];
$error = true;
$errorMessage = 'Sorry your message can not be sent.';

//Validate first
if(empty($name)||empty($email)||empty($message)) 
{
  echo "Name and email and message are required !";
  header('Location: index.html');
  $error = false;
}
//validate against any email injection attempts
if(IsInjected($email))
{
  $error = false;
  echo "Bad email value!";
  header('Location: index.html');
}


$mail->isSMTP();
$mail->Host = 'ssl://smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = $user;
$mail->Password = 'superuser';
$mail->SMTPSecure = 'tls';
$mail->Port = 465;
$mail->setFrom($user, 'NATANAWA.WEB.ID');

$msg =  " Name : $name <br>"; 
$msg .= " Email: $email <br>";
$msg .= " WebSite: $website <br>";
$msg .= " Subject: $subject <br>";
$msg .= " Message : ".stripslashes($_POST['message'])."<br>\n";
$msg .= "User information <br>"; 
$msg .= "User IP : ".$_SERVER["REMOTE_ADDR"]."<br>"; 
$msg .= "Browser info : ".$_SERVER["HTTP_USER_AGENT"]."<br>"; 
$msg .= "User come from : ".$_SERVER["SERVER_NAME"]."<br>";
$msg .= "Template Name : SPLIT VCARD";

$sujet =  "Sender information";

if ($error){
  $mail->addAddress('korodarmo@gmail.com');
  $mail->Subject = $sujet;
  $mail->isHTML(true);
  $mail->Body = $msg;

  if($mail->send()){
    echo "SENDING"; 
  } else {
    echo $errorMessage; 
  }
} else {
  echo $errorMessage; 
}


function IsInjected($str)
{
  $injections = array('(\n+)',
    '(\r+)',
    '(\t+)',
    '(%0A+)',
    '(%0D+)',
    '(%08+)',
    '(%09+)'
  );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
  {
    return true;
  }
  else
  {
    return false;
  }
}

?>