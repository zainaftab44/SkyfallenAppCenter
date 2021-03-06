<?php
// Initialize the session
session_name("AppCenterSession");
session_start();
include_once "../configuration.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /");
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Skyfallen App Center</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
    <script>
        function logoutbutton(){
            var http = new XMLHttpRequest();
            var url = '/api/';
            var params = 'action=logout';
            http.open('POST', url, true);

        //Send the proper header information along with the request
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
            window.location.href = "/";
        }
        }
        http.send(params);
        }
    </script>
</head>

<body>
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="https://theskyfallen.company/wp-content/uploads/2020/07/IMG_0183.png" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php if($_GET["app"]=="dash"){ echo "active"; }?>" href="?app=dash">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">All Apps</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($_GET["app"]=="edit"){ echo "active"; }?>" href="?app=edit">
                            <i class="ni ni-planet text-orange"></i>
                            <span class="nav-link-text">Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($_GET["app"]=="new"){ echo "active"; }?>" href="?app=new">
                            <i class="ni ni-pin-3 text-primary"></i>
                            <span class="nav-link-text">New</span>
                        </a>
                    </li>
                </ul>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center  ml-md-auto ">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <div class="media-body  ml-2  d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION["username"]; ?></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right ">
                            <button style="outline: none; background: transparent; border: none;" type="button" onclick="logoutbutton()">
                            <a href="#" class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <?php
                    if($_GET["app"]=="new"){ ?>
                        <form method="post" style="text-align: center; width: 100%;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">App Name</span>
                                </div>
                                <input type="text" class="form-control" name="appname" placeholder="App Name" aria-label="App Name" aria-describedby="basic-addon1">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isPublicNew" name="isPublicNew">
                                <label class="form-check-label" for="defaultCheck1">
                                    Make it Public?
                                </label>
                            </div>
                            <button type="submit" class="btn btn-secondary">Create</button>
                        </form>
                    <?php }
                    if($_GET["app"]=="new" and isset($_POST["appname"])){
                        if($_POST["isPublicNew"] == "on"){
                            $ispublicnew = "PUBLIC";
                        } else {
                            $ispublicnew = "PRIVATE";
                        }
                        $sql = "INSERT INTO apps (appid,appname,appsecret,creator,ispublic,verified) VALUES ('".md5(uniqid(rand(), true))."','".$_POST["appname"]."','".md5(uniqid(rand(), true))."','".$_SESSION["username"]."','".$ispublicnew."','NO')";
                        if($res = mysqli_query($link,$sql)){
                            $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                            if (!empty($referer)) {

                                echo '<p><a style="color: white;" href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            } else {

                                echo '<p><a style="color: white;" href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            }
                            echo "<br><p>Success!</p>";
                        } else {
                            $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                            if (!empty($referer)) {

                                echo '<p><a style="color: white;" href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            } else {

                                echo '<p><a style="color: white;" href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            }
                            echo "<br><p>Error!</p>";
                        }
                    }
                    ?>
                    <?php
                    if($_GET["app"]=="dash"){
                    $sql = "SELECT * FROM apps WHERE creator='".$_SESSION["username"]."'";
                    if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                    echo '<div style="text-align: center; width: 100%; text-align: center;">';
                        echo "<table class='table' style='width:80%; margin-right: auto; margin-left: auto;'>";
                            echo "<thead>";
                            echo "<tr>";
                                echo "<th scope='col'>App Name</th>";
                                echo "<th scope='col'>Public</th>";
                                echo "<th scope='col'>Edit</th>";
                                echo "<th scope='col'>Delete</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['appname'] . "</td>";
                                echo "<td>" . $row['ispublic'] . "</td>";
                                echo "<td><a style='color: white;' href='?app=edit&appid=" . $row['appid'] . "' >Edit</a></td>";
                                echo "<td><a style='color: white;' href='?app=delete&appid=" . $row['appid'] . "' >Delete</a></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        mysqli_free_result($result);
                        } else{
                        echo "No apps found.";
                        }
                        } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link); }
                    if($_GET["app"]=="delete"){
                        $sql = "DELETE FROM apps WHERE appid='".$_GET["appid"]."'";
                        if($result = mysqli_query($link, $sql)){
                            $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                            if (!empty($referer)) {

                                echo '<p><a style="color: white;" href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            } else {

                                echo '<p><a style="color: white;" href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p><br>';

                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link); }
                    if($_GET["app"]=="edit"){
                        $sql = "SELECT * FROM apps WHERE creator='".$_SESSION["username"]."' and appid='".$_GET["appid"]."'";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) == 1){
                                echo '<div style="text-align: center; width: 100%; text-align: center;">';
                                while($row = mysqli_fetch_array($result)){
                                    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                                    if (!empty($referer)) {

                                        echo '<p><a style="color: white;" href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p>';

                                    } else {

                                        echo '<p><a style="color: white;" href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p>';

                                    }
                                    ?>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">App Name</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="App Name" aria-describedby="basic-addon1" value="<?php echo $row["appname"]; ?>" disabled>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">App ID</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="App ID" aria-describedby="basic-addon1" value="<?php echo $row["appid"]; ?>" disabled>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">App Secret</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="App Secret" aria-describedby="basic-addon1" value="<?php echo $row["appsecret"]; ?>" disabled>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Is Public</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Is Public?" aria-describedby="basic-addon1" value="<?php echo $row["ispublic"]; ?>" disabled>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">App Creator</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="App Creator" aria-describedby="basic-addon1" value="<?php echo $row["creator"]; ?>" disabled>
                                    </div>
                                    <?php
                                }
                                mysqli_free_result($result);
                            } else{
                                $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

                                if (!empty($referer)) {

                                    echo '<p><a style="color: white;" href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p><br>';

                                } else {

                                    echo '<p><a style="color: white;" href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p><br>';

                                }
                                echo "Invalid App ID";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link); }
                    ?>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Footer -->
        <footer class="footer pt-0">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6">
                    <div class="copyright text-center  text-lg-left  text-muted">
                        &copy; 2020 Skyfallen Developers
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Argon Scripts -->
<!-- Core -->
<script src="assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/js-cookie/js.cookie.js"></script>
<script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
<!-- Optional JS -->
<script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
<script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
<!-- Argon JS -->
<script src="assets/js/argon.js?v=1.2.0"></script>
</body>

</html>

