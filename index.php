<?php
 //require_once "configuration.php";
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign in - Skyfallen</title>
    <link type="text/css" rel="stylesheet" href="css/main.css">
    <script type="text/javascript" rel="script" src="js/main.js"></script>
    <script type="text/javascript" rel="script" src="js/jquery.min.js"></script>
</head>

<body onload="onpagloadcheck()">
    <form method="post" class="centered" id="form">
        <div class="container centered text-center" id="outsider">
            <div id="middle">
            <div class="field text-center">
                <img src="https://theskyfallen.company/wp-content/uploads/2020/07/IMG_0183.png" style="height: 100px;">
            </div>
            <div class="field text-center">
                <h3>Sign to Skyfallen App Center</h3>
            </div>
            <div class="field">
                <input type="text" required autocomplete="off" id="username" name="username" style="border-radius: 10px 10px 0px 0px;">
                <label for="username" title="Please enter your Username or E-Mail" data-title="Username or E-Mail"></label>
            </div>

            <div class="field">
                <input type="password" required autocomplete="off" id="password" name="password" style="border-radius: 0px 0px 10px 10px; border-top: none;">
                <label for="password" title="Please enter your password." data-title="Password"></label>
            </div>
            <div class="field-button">
                <button type="button" style="border: none; background: transparent;" onclick="swaploading()" id="submit-arrow-pwin-btn" name="submit-arrow-pwin"><img src="img/RightArrow.png" style="height: 30px;" id="submit-arrow-pwin-img" name="submit-arrow-pwin-img"> </button>
            </div>
            </div>
        </div>
    </form>
    <div class="footer"><p class="text-center">Don't have an account? <a href="/register/">Create here</a></p></div>
</body>
</html>
