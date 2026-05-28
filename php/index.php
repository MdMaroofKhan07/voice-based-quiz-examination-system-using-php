<!DOCTYPE html>

<html lang="en">
<head>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>University Polytechnic , AMU</title>

<!-- ================= CSS FILES ================= -->
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="/exam/css/main.css">
<link rel="stylesheet" href="css/change.css">
<link rel="stylesheet" href="css/font.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

<!-- ================= JS FILES ================= -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- ================= PHP ALERT ================= -->
<?php
if (isset($_GET['w'])) {
    echo '<script>alert("' . $_GET['w'] . '");</script>';
}
?>

<!-- ================= FORM VALIDATION ================= -->
<script>
function validateForm() {

    var name = document.forms["form"]["name"].value;
    var letters = /^[A-Za-z]+$/;

    if (name === "") {
        alert("Name must be filled out.");
        return false;
    }

    if (!name.match(letters)) {
        alert("Name must contain only letters.");
        return false;
    }

    var college = document.forms["form"]["college"].value;
    if (college === "") {
        alert("College must be filled out.");
        return false;
    }

    var email = document.forms["form"]["email"].value;
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");

    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
        alert("Not a valid e-mail address.");
        return false;
    }

    var password = document.forms["form"]["password"].value;
    if (password === "") {
        alert("Password must be filled out.");
        return false;
    }

    if (password.length < 5 || password.length > 25) {
        alert("Password must be 5 to 25 characters long.");
        return false;
    }

    var confirmPassword = document.forms["form"]["cpassword"].value;
    if (password !== confirmPassword) {
        alert("Passwords must match.");
        return false;
    }

    return true;
}
</script>


</head>

<body>

<!-- ================= HEADER ================= -->

<div class="header">
    <div class="row">


    <!-- Logo / Title -->
    <div class="col-lg-6">
        <h1 class="logo">Online Examination System for Visually Challenged Students</h1>
    </div>

    <!-- Signin Button -->
    <div class="col-md-2 col-md-offset-4">
        <a href="#" class="pull-right btn sub1" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-log-in"></span>
            <b>Signin</b>
        </a>
    </div>

</div>


</div>

<!-- ================= LOGIN MODAL ================= -->

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span style="color:orange">Log In</span></h4>
        </div>

        <div class="modal-body">
            <form action="login.php?q=index.php" method="POST">

                <input type="email" name="email" placeholder="Enter your email-id" class="form-control"><br>

                <input type="password" name="password" placeholder="Enter your Password" class="form-control">

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Log in</button>
            </form>
        </div>

    </div>
</div>


</div>

<!-- ================= SIGNUP FORM ================= -->

<div class="bg1">
    <div class="row">


    <div class="col-md-7"></div>

    <div class="col-md-4 panel">
        <form name="form" action="sign.php?q=account.php" method="POST" onsubmit="return validateForm()">

            <input type="text" name="name" placeholder="Enter your name" class="form-control"><br>

            <select name="gender" class="form-control">
                <option>Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select><br>

            <input type="text" name="college" placeholder="Enter your college" class="form-control"><br>

            <input type="email" name="email" placeholder="Enter your email" class="form-control"><br>

            <input type="number" name="mob" placeholder="Enter mobile number" class="form-control"><br>

            <input type="password" name="password" placeholder="Enter password" class="form-control"><br>

            <input type="password" name="cpassword" placeholder="Confirm Password" class="form-control"><br>

            <?php
            if (isset($_GET['q7'])) {
                echo '<p style="color:red">' . $_GET['q7'] . '</p>';
            }
            ?>

            <input type="submit" class="sub btn btn-primary" value="Sign Up">

        </form>
    </div>

</div>


</div>

<!-- ================= FOOTER START ================= -->
<div class="row footer">

    <!-- About Us -->
    <div class="col-md-3 box">
        <a href="Files/Project pdf.pdf" target="_blank">About us</a>
    </div>

    <!-- Admin Login -->
    <div class="col-md-3 box">
        <a href="#" data-toggle="modal" data-target="#login">Admin Login</a>
    </div>

    <!-- Developers -->
    <div class="col-md-3 box">
        <a href="#" data-toggle="modal" data-target="#developers">Developers</a>
    </div>

    <!-- Feedback -->
    <div class="col-md-3 box">
        <a href="feedback.php" target="_blank">Feedback</a>
    </div>

</div>
<!-- ================= FOOTER END ================= -->


<!-- ================= DEVELOPERS MODAL ================= -->
<div class="modal fade title1" id="developers">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title" style="font-family:'typo'">
                    <span style="color:orange">Developers</span>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">

                    <!-- Developer Image -->
                    <div class="col-md-4">
                        <img src="image/Maroof 3.jpg"
                             width="100"
                             height="100"
                             alt="Md Maroof Khan"
                             class="img-rounded">
                    </div>

                    <!-- Developer Details -->
                    <div class="col-md-5">
                        <a href="https://www.linkedin.com/in/Md Maroof Khan"
                           target="_blank"
                           style="color:#202020; font-family:'typo'; font-size:18px">
                           Md Maroof Khan
                        </a>

                        <h4 class="title1"
                            style="color:#202020; font-family:'typo'; font-size:16px">
                            +91 9569864910
                        </h4>

                        <h4 style="font-family:'typo'">kmaroof1107@gmail.com</h4>
                        <h4 style="font-family:'typo'">University Polytechnic , AMU</h4>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- ================= DEVELOPERS MODAL END ================= -->


<!-- ================= ADMIN LOGIN MODAL ================= -->
<div class="modal fade" id="login">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">
                    <span style="color:orange; font-family:'typo'">LOGIN</span>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body title1">
                <div class="row">

                    <div class="col-md-3"></div>

                    <div class="col-md-6">
                        <form method="post" action="admin.php?q=index.php">

                            <!-- Username -->
                            <div class="form-group">
                                <input type="text"
                                       name="uname"
                                       maxlength="20"
                                       placeholder="Admin user id"
                                       class="form-control">
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <input type="password"
                                       name="password"
                                       maxlength="15"
                                       placeholder="Password"
                                       class="form-control">
                            </div>

                            <!-- Submit -->
                            <div class="form-group text-center">
                                <input type="submit"
                                       name="login"
                                       value="Login"
                                       class="btn btn-primary">
                            </div>

                        </form>
                    </div>

                    <div class="col-md-3"></div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- ================= ADMIN LOGIN MODAL END ================= -->

</body>
</html>
