<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interviews - Madison PHP Conference</title>
    <meta name="description" content="Contact Us Form">
    <meta property="og:image" content="/images/madison-php-logo.jpg">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@madisonphp">
    <meta name="twitter:title" content="Madison PHP Conference">
    <meta name="twitter:description" content="Madison PHP Conference is designed to offer something to attendees at all skill levels. It will be two days of networking, learning, sharing, and great fun!">
    <meta name="twitter:image" content="/images/madison-php-logo.jpg">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
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
    </div>
</div>
<div id="content">

    <?php


    if($_POST['submit'] == "Send") {
        $efs_name = htmlentities(strip_tags($_POST['name']));
        $efs_email = htmlentities(strip_tags($_POST['email']));
        $efs_phone = htmlentities(strip_tags($_POST['phone']));
        $efs_location = htmlentities(strip_tags(preg_replace('/"/',"'",$_POST['location'])));
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
    $efs_filler_subject = "Interview Signup from the Madison PHP Conference Website";
    $thankYou = '<p>Thank you for signing up. You will receive a confirmation email once your information has been processed. This may take 1-2 business days.</p><p><a href="https://www.madisonphpconference.com">Return to the Conference website.</a></p>';

    /* ******************************************************
    End change vars for new install
    ****************************************************** */

    if($efs_submit == "Send") {
        if (!$efs_name) { $efs_error[] = "Please enter your Name."; }
        if (!$efs_email) { $efs_error[] = "Please enter your E-mail Address."; }
        if (!filter_var($efs_email, FILTER_VALIDATE_EMAIL)) { $efs_error[] = "Please check what you entered in the E-mail Address field. It is not a valid e-mail address."; }
        if (!$efs_phone) { $efs_error[] = "Please enter your Phone Number."; }
        if (!$efs_location) { $efs_error[] = "Please enter your General Location."; }
        if (strpos($efs_location,'[link=') !== false) { $efs_error[] = "Please do not include code in your General Location."; }
        if (strpos($efs_location,'[url=') !== false) { $efs_error[] = "Please do not include code in your General Location."; }
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
        $efs_content = "$efs_name|$efs_email|$efs_phone|$efs_location|$efs_message";


        $mailHeaders = "Reply-To: $efs_name <$efs_email>" . "\r\n" .
            "From: $efs_name <noreply@madisonphpconference.com>";

        $wereAt = file_get_contents('/signups_number.txt');
        file_put_contents('/signups.txt', "$wereAt - $efs_content", FILE_APPEND | LOCK_EX);

        mail($efs_sendto, $efs_filler_subject, $efs_content, $mailHeaders);

        echo "$thankYou";
    }
    else {
        echo "Send an e-mail to the Madison PHP Conference organizers:<br />
   <form action=\"{$_SERVER['REQUEST_URI']}\" method=\"post\">
   <p><strong>Name</strong><br />
   <input type=\"text\" name=\"name\" value=\"$efs_name\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>E-mail Address</strong><br />
   <input type=\"text\" name=\"email\" value=\"$efs_email\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>Phone</strong><br />
   <input type=\"text\" name=\"phone\" value=\"$efs_phone\" maxlength=\"25\" size=\"25\" /></p>
   <p><strong>General Location</strong> (Example: East side of Madison, Middleton, Watertown, etc.<br />
   <input type=\"text\" name=\"location\" value=\"$efs_location\" maxlength=\"250\" size=\"100\" /></p>
   <p><strong>Message</strong><br />
   <textarea name=\"message\" cols=\"50\" rows=\"10\">$efs_message</textarea></p>
   <p><input type=\"submit\" name=\"submit\" value=\"Send\" /></p>
   </form>";
    }

    ?>

</div>

</body></html>