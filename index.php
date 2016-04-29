<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Contact - Madison PHP Conference 2016</title>
   <meta name="description" content="Contact Us Form">
   <meta property="og:image" content="/images/madison-php-logo.jpg">
   <meta property="og:image:width" content="300">
   <meta property="og:image:height" content="300">
   <meta name="twitter:card" content="summary">
   <meta name="twitter:site" content="@madisonphp">
   <meta name="twitter:title" content="Madison PHP Conference">
   <meta name="twitter:description" content="Madison PHP Conference is designed to offer something to attendees at all skill levels. It will be a day of networking, learning, sharing, and great fun!">
   <meta name="twitter:image" content="/images/madison-php-logo.jpg">

   <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
   <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
   <link href="/style.css" rel="stylesheet">

   <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>
<body>

<div class="jumbotron text-center" role="banner">
   <div class="container">
      <h1><img src="/images/conf-logo.png" class="img-responsive" alt="Madison PHP Conference"></h1>
      <ul class="list-inline">
         <li>Share On</li>
         <li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]=http://2016.madisonphpconference.com/&amp;p[images][0]=http://2016.madisonphpconference.com/mysite/images/madison-php-shareable.jpg&amp;p[title]=+&amp;p[summary]=Madison PHP" class="btn btn-default btn-xs"><span class="fa fa-facebook" aria-hidden="true"></span> facebook</a></li>
         <li><a target="_blank" href="https://twitter.com/intent/tweet?url=http://2016.madisonphpconference.com/&amp;text=Madison PHP Conference&amp;via=MadisonPHP" class="btn btn-default btn-xs"><span class="fa fa-twitter" aria-hidden="true"></span> twitter</a></li>
      </ul>
   </div>
</div>
<div id="content">

<?php


require_once 'Zend/Mail.php';
   $mail = new Zend_Mail();
   
if($_POST['submit'] == "Send") {
   $efs_name = htmlentities(strip_tags($_POST['name']));
   $efs_email = htmlentities(strip_tags($_POST['email']));
   $efs_message = htmlentities(strip_tags(preg_replace('/"/',"'",$_POST['message'])));
   $efs_subject = htmlentities(strip_tags(preg_replace('/"/',"'",$_POST['subject'])));
   $efs_submit = "Send";
}
unset($_POST);


/* ******************************************************
Change these variables for installation on new sites
****************************************************** */

$efs_sendto = "team@madisonphpconference.com";
$efs_sendName = "Madison PHP Conference";
$efs_siteName = "Madison PHP Conference";
$efs_filler_subject = "E-mail from the Madison PHP Conference Website";
$mail->setFrom("noreply@madisonphpconference.com", "$efs_name");
$thankYou = '<p>Thank you, your message has been sent.</p><p><a href="http://www.madisonphpconference.com">Return to the Conference website.</a></p>';

/* ******************************************************
End change vars for new install
****************************************************** */

if($efs_submit == "Send") {
   if (!$efs_name) { $efs_error[] = "Please enter your Name."; }
   if (!$efs_email) { $efs_error[] = "Please enter your E-mail Address."; }
   if (!filter_var($efs_email, FILTER_VALIDATE_EMAIL)) { $efs_error[] = "Please check what you entered in the E-mail Address field. It is not a valid e-mail address."; }
   if (!$efs_message) { $efs_error[] = "Please enter your Message."; }
   if (strpos($efs_message,'[link=') !== false) { $efs_error[] = "Please do not include code in your Message."; }
   if (strpos($efs_message,'[url=') !== false) { $efs_error[] = "Please do not include code in your Message."; }

   if(is_array($efs_error)) {
      echo "<ul>";
      foreach($efs_error as $v) {
         echo "<li class=\"error\">$v</li>";
      }
      echo "</ul>";
      $efs_submit = "";
   }
}

if(($efs_submit == "Send") && (!is_array($efs_error))) {
   $efs_content = "Name: $efs_name
E-mail Address: $efs_email

Message: $efs_message

--------------------------------
Sent from the $efs_siteName site
";

    $mail->setBodyText($efs_content);
    $mail->setReplyTo($efs_email, $efs_name);
if(empty($efs_subject)) {
    $mail->setSubject($efs_filler_subject);
}else {
    $mail->setSubject($efs_subject);
}
    $mail->addTo($efs_sendto, $efs_sendName);
    $mail->send();

   echo "$thankYou";
}   
else {
   echo "Send an e-mail to the Madison PHP Conference organizers:<br />
   <form action=\"{$_SERVER['REQUEST_URI']}\" method=\"post\">
   <p><strong>Name</strong><br />
   <input type=\"text\" name=\"name\" value=\"$efs_name\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>E-mail Address</strong><br />
   <input type=\"text\" name=\"email\" value=\"$efs_email\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>Subject</strong><br />
   <input type=\"text\" name=\"subject\" value=\"$efs_subject\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>Message</strong><br />
   <textarea name=\"message\" cols=\"50\" rows=\"10\">$efs_message</textarea></p>
   <p><input type=\"submit\" name=\"submit\" value=\"Send\" /></p>
   </form>";
}

?>

</div>

</body></html>