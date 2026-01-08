<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>University Polytechnic , AMU</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/font.css">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"  type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<?php if(@$_GET['w']) { echo '<script>alert("'.htmlspecialchars(@$_GET['w'], ENT_QUOTES, 'UTF-8').'");</script>'; } ?>
<script>
function validateForm() {
  var y = document.forms["form"]["name"].value;
  if (y == null || y == "") { alert("Name must be filled out."); return false; }
  var z = document.forms["form"]["college"].value;
  if (z == null || z == "") { alert("College must be filled out."); return false; }
  var x = document.forms["form"]["email"].value;
  var atpos = x.indexOf("@");
  var dotpos = x.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) { alert("Not a valid e-mail address."); return false; }
  var a = document.forms["form"]["password"].value;
  if(a == null || a == ""){ alert("Password must be filled out"); return false; }
  if(a.length<5 || a.length>25){ alert("Passwords must be 5 to 25 characters long."); return false; }
  var b = document.forms["form"]["cpassword"].value;
  if (a!=b){ alert("Passwords must match."); return false; }
}
</script>
</head>

<body>
<div class="header"><div class="row">
  <div class="col-lg-6"><span class="logo">Test Your Skill</span></div>
  <div class="col-md-2 col-md-offset-4">
    <a href="#" class="pull-right btn sub1" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span>&nbsp;<span class="title1"><b>Signin</b></span></a>
  </div>
</div></div>

<div class="bg1">
<div class="row">
  <div class="col-md-7"></div>
  <div class="col-md-4 panel">
    <!-- sign in form begins -->  
    <form class="form-horizontal" name="form" action="sign.php?q=account.php" onSubmit="return validateForm()" method="POST">
      <fieldset>
        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_name" name="name" placeholder="Enter your name" class="form-control input-md" type="text">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_name">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <select id="signup_gender" name="gender" class="form-control input-md">
              <option value="">Select Gender</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_gender">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_college" name="college" placeholder="Enter your college name" class="form-control input-md" type="text">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_college">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_email" name="email" placeholder="Enter your email-id" class="form-control input-md" type="email">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_email">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_mob" name="mob" placeholder="Enter your mobile number" class="form-control input-md" type="number">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_mob">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_password" name="password" placeholder="Enter your password" class="form-control input-md" type="password">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_password">🔊</button>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            <input id="signup_cpassword" name="cpassword" placeholder="Confirm Password" class="form-control input-md" type="password">
            <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#signup_cpassword">🔊</button>
          </div>
        </div>

        <?php if(@$_GET['q7']) { echo '<p style="color:red;font-size:15px;">'.htmlspecialchars(@$_GET['q7'], ENT_QUOTES, 'UTF-8').'</p>'; } ?>

        <div class="form-group">
          <div class="col-md-12"> 
            <input type="submit" class="sub" value="sign up"/>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
</div>

<!-- Footer -->
<div class="row footer">
  <div class="col-md-3 box"><a href="http://www.projectworlds/online-examination" target="_blank">About us</a></div>
  <div class="col-md-3 box"><a href="#" data-toggle="modal" data-target="#login">Admin Login</a></div>
  <div class="col-md-3 box"><a href="#" data-toggle="modal" data-target="#developers">Developers</a></div>
  <div class="col-md-3 box"><a href="feedback.php" target="_blank">Feedback</a></div>
</div>

<!-- developers modal unchanged -->
<div class="modal fade title1" id="developers"> ... </div>

<!-- Modal for sign-in (Login) -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content title1">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title title1"><span style="color:orange">Log In</span></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="login.php?q=index.php" method="POST">
          <fieldset>
            <div class="form-group">
              <div class="col-md-6">
                <input id="login_email" name="email" placeholder="Enter your email-id" class="form-control input-md" type="email">
                <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#login_email">🔊</button>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <input id="login_password" name="password" placeholder="Enter your Password" class="form-control input-md" type="password">
                <button type="button" class="tts-play-btn" data-tts-play data-tts-target="#login_password">🔊</button>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" id="readLoginForm" class="btn btn-info">🔊 Read form</button>
              <button type="submit" class="btn btn-primary">Log in</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// small script for Read form button in login modal
document.addEventListener('DOMContentLoaded', function(){
  var read = document.getElementById('readLoginForm');
  if (!read) return;
  read.addEventListener('click', function(){
    var email = document.getElementById('login_email');
    var password = document.getElementById('login_password');
    var text = '';
    if (email) text += 'Email. ' + (email.placeholder || email.value || '') + '. ';
    if (password) text += 'Password field. ' + (password.placeholder || '') + '.';
    if (window.TTS) window.TTS.speak(text);
  });
});
</script>

</body>
</html>
