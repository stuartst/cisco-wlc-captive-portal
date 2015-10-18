<?php

$switch_url = $_GET['switch_url'];
$ap_mac = $_GET['ap_mac'];
$client_mac = $_GET['client_mac'];
$wlan = $_GET['wlan'];
$redirect = $_GET['redirect'];
$statusCode = $_GET['statusCode'];

if ($statusCode == 1) {
    $statusMessage = "You are already logged in.";
}
elseif ($statusCode == 2) {
    $statusMessage = "You are not configured to authenticate against this web portal.";
}
elseif ($statusCode == 3) {
    $statusMessage = "The email address specified cannot be used at this time. Perhaps the username is already logged into the system?";
}
elseif ($statusCode == 4) {
    $statusMessage = "This account has been excluded. Please contact the administrator.";
}
elseif ($statusCode == 5) {
    $statusMessage = "Invalid email or password. Please try again.";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <title>Web Authentication</title>

        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
 
    <body>
        
        <div class="head">
            <h1 class="center-text white">Login now</h1>
        </div>
        
        <form action="<?php echo $switch_url; ?>" method="post" id="login-form">
            
            <div class="social">
              <h4>Connect with</h4>
              <ul>
                <li> 
                <a href="" class="facebook">
                  <span class="fa fa-facebook"></span>
                </a>
                </li>
                <li>
                  <a href="" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
                <li>
                  <a href="" class="google-plus">
                    <span class="fa fa-google-plus"></span>
                  </a>
                </li>
              </ul>
             </div>

             <div class="divider">
               <span>or</span>
             </div>

            <div class="input-field">
                <?php if ($statusMessage) echo "<p class=\"alert\"><i class=\"fa fa-warning\"></i> {$statusMessage}</p>"; ?>
                
                <label for="email">Email</label>
                <input type="email" name="username" required="email" />
                <label for="password">Password</label> 
                <input type="password" name="password" required/>
                <input type="submit" value="Log in" />

                <input type="hidden" name="buttonClicked" size="16" maxlength="15" value="4">

                <p class="text-p">Not signed up yet? <a href="#">Sign up</a></p>
            </div>
        </form>
        
    </body>
</html> 