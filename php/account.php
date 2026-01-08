<!-- Initializes the session, includes database connection, checks user login,
and fetches the logged-in user's details from the session. -->
<?php
// account.php - Final version with voice/TTS/ASR behavior
// Backup your original file before replacing.

include_once 'dbConnection.php';
session_start();

if (!(isset($_SESSION['email']))) {
    header("location:index.php");
    exit;
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>University Polytechnic , AMU</title>

<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/account.css">
<link rel="stylesheet" href="css/font.css">

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"  type="text/javascript"></script>

<style>
/* small styling */
.option-text{margin-left:6px;}
</style>
</head>
<body>
<div class="header">
  <div class="row">
    <div class="col-lg-6"><span class="logo">Choose Your Subject</span></div>
    <div class="col-md-4 col-md-offset-2">
      <?php
        echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="account.php?q=1" class="log log1">'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</a></span>';
      ?>
    </div>
  </div>
</div>

<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><b>Netcamp</b></a>
    </div>
    <!-- 
      Creates a responsive navigation bar with Home, History, Ranking, and Signout links,
      and highlights the active menu based on the current page using PHP.
    -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?> ><a href="account.php?q=1"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</a></li>
        <li <?php if (@$_GET['q'] == 2) echo 'class="active"'; ?>><a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;History</a></li>
        <li <?php if (@$_GET['q'] == 3) echo 'class="active"'; ?>><a href="account.php?q=3"><span class="glyphicon glyphicon-stats"></span>&nbsp;Ranking</a></li>
        <li class="pull-right"><a href="logout.php?q=account.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Signout</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group"><input type="text" class="form-control" placeholder="Enter tag "></div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row"><div class="col-md-12">

  <!-- Home: list quizzes -->
  <?php if (@$_GET['q'] == 1) {
    $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
    echo '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
    <tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $sahi = $row['sahi'];
      $time = $row['time'];
      $eid = $row['eid'];
      $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
      $rowcount = mysqli_num_rows($q12);
      if ($rowcount == 0) {
        echo '<tr><td>'.$c++.'</td><td>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</td><td>'.$total.'</td><td>'.($sahi*$total).'</td><td>'.$time.'&nbsp;min</td>
        <td><b><a href="account.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
      } else {
        echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'&nbsp;<span title="This quiz is already solved by you" class="glyphicon glyphicon-ok"></span></td><td>'.$total.'</td><td>'.($sahi*$total).'</td><td>'.$time.'&nbsp;min</td>
        <td><b><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-repeat"></span>&nbsp;<span class="title1"><b>Restart</b></span></a></b></td></tr>';
      }
    }
    echo '</table></div></div>';
  } ?>

  <!-- Quiz block -->

<!-- Fetches and displays the current quiz question and its options from the database,
then generates a form to submit the selected answer for evaluation. -->


  <?php
  if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {

    $eid = @$_GET['eid'];
    $sn = intval(@$_GET['n']);
    $total = intval(@$_GET['t']);

    $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'") or die('Error fetching question');
    echo '<div class="panel" style="margin:5%">';
    while ($row = mysqli_fetch_array($q)) {
      $qns = $row['qns'];
      $qid = $row['qid'];
      echo '<div id="question_text"><b>Question '.htmlspecialchars($sn, ENT_QUOTES, 'UTF-8').' ::<br>'.htmlspecialchars($qns, ENT_QUOTES, 'UTF-8').'</b></div><br>';
    }

    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid'") or die('Error fetching options');
    echo '<form id="quizForm" action="update.php?q=quiz&step=2&eid='.urlencode($eid).'&n='.urlencode($sn).'&t='.urlencode($total).'&qid='.urlencode($qid).'" method="POST" class="form-horizontal"><br />';

    $optIndex = 0;
    while ($row = mysqli_fetch_array($q)) {
      $option = $row['option'];
      $optionid = $row['optionid'];
      $optIndex++;
      $optTextId = 'opt_'.htmlspecialchars($qid, ENT_QUOTES, 'UTF-8').'_'.$optIndex;
      echo '<label>';
      echo '<input type="radio" name="ans" value="'.htmlspecialchars($optionid, ENT_QUOTES, 'UTF-8').'"> ';
      echo '<span id="'.$optTextId.'" class="option-text">'.htmlspecialchars($option, ENT_QUOTES, 'UTF-8').'</span>';
      echo '</label><br /><br />';
    }

    echo '<br /><button id="submitBtn" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span>&nbsp;Submit</button></form></div>';
  }
  ?>

  <!-- Result / History / Ranking -->
  
<!-- 1. Displays the quiz result of the logged-in user by showing total questions,
      correct answers, wrong answers, and scores after exam completion.

    2. Shows the quiz history of the user, including past attempts, scores,
    and performance details for each quiz.

    3. Generates the overall ranking list by fetching user details and scores
    from the database and displaying them in descending order. -->

  <?php
  if (@$_GET['q'] == 'result' && @$_GET['eid']) {
    $eid = @$_GET['eid'];
    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error157');
    echo '<div class="panel"><center><h1 class="title" style="color:#660033">Result</h1></center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
    while ($row = mysqli_fetch_array($q)) {
      $s = $row['score']; $w = $row['wrong']; $r = $row['sahi']; $qa = $row['level'];
      echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>'.$qa.'</td></tr>
            <tr style="color:#99cc32"><td>Right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle"></span></td><td>'.$r.'</td></tr>
            <tr style="color:red"><td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle"></span></td><td>'.$w.'</td></tr>
            <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star"></span></td><td>'.$s.'</td></tr>';
    }
    $q2 = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error157');
    while ($row = mysqli_fetch_array($q2)) {
      $s = $row['score'];
      echo '<tr style="color:#990000"><td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats"></span></td><td>'.$s.'</td></tr>';
    }
    echo '</table></div>';
  }

  if (@$_GET['q'] == 2) {
    $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC") or die('Error197');
    echo '<div class="panel title"><table class="table table-striped title1"><tr style="color:red"><td><b>S.N.</b></td><td><b>Quiz</b></td><td><b>Question Solved</b></td><td><b>Right</b></td><td><b>Wrong</b></td><td><b>Score</b></td>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
      $eid = $row['eid']; $s = $row['score']; $w = $row['wrong']; $r = $row['sahi']; $qa = $row['level'];
      $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE eid='$eid'") or die('Error208');
      $title = '';
      while ($r2 = mysqli_fetch_array($q23)) { $title = $r2['title']; }
      $c++;
      echo '<tr><td>'.$c.'</td><td>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
    }
    echo '</table></div>';
  }

  if (@$_GET['q'] == 3) {
    $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC") or die('Error223');
    echo '<div class="panel title"><div class="table-responsive"><table class="table table-striped title1"><tr style="color:red"><td><b>Rank</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>College</b></td><td><b>Score</b></td></tr>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
      $e = $row['email']; $s = $row['score'];
      $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e'") or die('Error231');
      $name = $gender = $college = '';
      while ($r2 = mysqli_fetch_array($q12)) { $name = $r2['name']; $gender = $r2['gender']; $college = $r2['college']; }
      $c++;
      echo '<tr><td style="color:#99cc32"><b>'.$c.'</b></td><td>'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'</td><td>'.htmlspecialchars($gender, ENT_QUOTES, 'UTF-8').'</td><td>'.htmlspecialchars($college, ENT_QUOTES, 'UTF-8').'</td><td>'.$s.'</td></tr>';
    }
    echo '</table></div></div>';
  }
  ?>

  </div></div>
</div>

<!-- footer -->
<div class="row footer">
  <a href="Files/Project pdf.pdf " target="_blank">About us</a>
  <div class="col-md-3 box"><a href="#" data-toggle="modal" data-target="#login">Admin Login</a></div>
  <div class="col-md-3 box"><a href="#" data-toggle="modal" data-target="#developers">Developers</a></div>
  <div class="col-md-3 box"><a href="feedback.php" target="_blank">Feedback</a></div>
</div>

<!-- minimal modals -->
<div class="modal fade title1" id="developers">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title"><span style="color:orange">Developers</span></h4></div>
  <div class="modal-body">Developer info...</div></div></div>
</div>

<div class="modal fade" id="login">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title"><span style="color:orange">LOGIN</span></h4></div>
  <div class="modal-body title1"><div class="row"><div class="col-md-3"></div><div class="col-md-6">
  <form role="form" method="post" action="admin.php?q=index.php">
    <div class="form-group"><input type="text" name="uname" maxlength="20" placeholder="Admin user id" class="form-control"/></div>
    <div class="form-group"><input type="password" name="password" maxlength="15" placeholder="Password" class="form-control"/></div>
    <div class="form-group" align="center"><input type="submit" name="login" value="Login" class="btn btn-primary" /></div>
  </form></div><div class="col-md-3"></div></div></div></div></div>
</div>

<!-- ===========================
 Voice/TTS/ASR SCRIPT (final)
 - male voice only
 - read once on load
 - repeat only on 'repeat' command
 - pause on 'no' until repeat/submit/option
 - uses user's spoken form (e.g., "3" or "C") in final submission line
 - confirm timeout 10s (auto-submit after timeout)
 ============================ -->
<script>
/* Voice/TTS/ASR replacement — final behavior */

// --- voice helpers ---
function ensureVoicesLoaded(cb) {
  var voices = speechSynthesis.getVoices();
  if (voices.length) { if (cb) cb(voices); return; }
  speechSynthesis.onvoiceschanged = function() {
    voices = speechSynthesis.getVoices();
    if (cb) cb(voices);
  };
}
function findMaleVoice() {
  var voices = speechSynthesis.getVoices() || [];
  if (!voices.length) return null;
  var maleHints = ['david','daniel','google uk english male','google us english male','microsoft','alex','fred','john','male'];
  for (var i=0;i<maleHints.length;i++){
    var hint = maleHints[i].toLowerCase();
    for (var j=0;j<voices.length;j++){
      var v = voices[j];
      if (v.name && v.name.toLowerCase().indexOf(hint) !== -1) return v;
    }
  }
  for (var k=0;k<voices.length;k++){
    if (voices[k].lang && (voices[k].lang.indexOf('en-IN')===0 || voices[k].lang.indexOf('en-')===0)) return voices[k];
  }
  return voices[0] || null;
}
function speakWithCallbackMale(text, cb) {
  if (!window.speechSynthesis) { if (cb) cb(); return; }
  try { speechSynthesis.cancel(); } catch(e){}
  var u = new SpeechSynthesisUtterance(text);
  u.lang = 'en-IN';
  u.rate = 1.0;
  u.pitch = 1.0;
  if (window._maleVoice) u.voice = window._maleVoice;
  u.onend = function(){ if (cb) cb(); };
  speechSynthesis.speak(u);
}

// --- build question+options text ---
function buildReadText() {
  var qEl = document.querySelector('#question_text');
  var opts = document.querySelectorAll('input[name="ans"]');
  if (!qEl || !opts || opts.length === 0) return null;
  var text = '';
  var params = new URLSearchParams(window.location.search);
  var sn = params.get('n');
  if (sn) text += 'Question ' + sn + '. ';
  text += (qEl.innerText || qEl.textContent).trim() + '. ';
  opts.forEach(function(op, idx) {
    var span = op.parentNode.querySelector('.option-text') || op.nextElementSibling;
    var txt = span ? (span.innerText || span.textContent).trim() : ('Option ' + (idx+1));
    text += 'Option ' + (idx+1) + ': ' + txt + '. ';
  });
  return text;
}

// --- state ---
var recognition = null;
var confirmTimer = null;
var awaitingConfirm = false;
var pausedAfterNo = false;
var lastSelectedIndex = -1;
var lastSpokenForm = null;

// --- helpers ---
function clearConfirmTimer(){ if (confirmTimer){ clearTimeout(confirmTimer); confirmTimer = null; } }
function getOptionTextByIndex(idx) {
  var all = document.querySelectorAll('input[name="ans"]');
  if (!all || !all[idx]) return '';
  var span = all[idx].parentNode.querySelector('.option-text') || all[idx].nextElementSibling;
  return span ? (span.innerText || span.textContent).trim() : '';
}
function formatLabelForSpeech(spokenForm, idx) {
  if (spokenForm && typeof spokenForm === 'string') {
    var s = spokenForm.trim();
    var m = s.match(/[a-dA-D]/);
    if (m) return 'Option ' + m[0].toUpperCase();
    var n = s.match(/\d+/);
    if (n) return 'Option ' + n[0];
    var mapWords = {'one':'1','two':'2','three':'3','four':'4'};
    for (var w in mapWords) {
      if (s.toLowerCase().indexOf(w) !== -1) return 'Option ' + mapWords[w];
    }
  }
  var letters = ['A','B','C','D'];
  if (typeof idx === 'number' && idx >=0 && idx < letters.length) return 'Option ' + letters[idx];
  return 'Option ' + (idx+1);
}

// --- submit with detailed voice line ---
function submitAnswer() {
  awaitingConfirm = false;
  clearConfirmTimer();
  var label = formatLabelForSpeech(lastSpokenForm, lastSelectedIndex);
  var optText = getOptionTextByIndex(lastSelectedIndex) || '';
  var speakLine = 'Submitting your answer: ' + label;
  if (optText) speakLine += ' - ' + optText + '.';
  else speakLine += '.';
  speakWithCallbackMale(speakLine, function(){
    var btn = document.querySelector('#submitBtn') || document.querySelector("button[type='submit']");
    if (btn) btn.click();
  });
}

// --- match option and capture spoken form ---
function tryMatchOptionWithForm(command) {
  var raw = (command || '').toLowerCase();
  raw = raw.replace(/[^a-z0-9\s]/gi,' ').trim();
  var letterMatch = raw.match(/\b(a|b|c|d)\b/);
  if (letterMatch) {
    var letter = letterMatch[1].toLowerCase();
    var idx = {'a':0,'b':1,'c':2,'d':3}[letter];
    return { idx: idx, spokenForm: letter.toUpperCase() };
  }
  var numMatch = raw.match(/\b([1-4])\b/);
  if (numMatch) {
    var n = parseInt(numMatch[1],10);
    return { idx: n-1, spokenForm: String(n) };
  }
  var wordMap = { 'one':0,'two':1,'three':2,'four':3 };
  for (var w in wordMap) {
    if (raw.indexOf(w) !== -1) return { idx: wordMap[w], spokenForm: w };
  }
  var optNum = raw.match(/option\s+([1-4])/);
  if (optNum) return { idx: parseInt(optNum[1],10)-1, spokenForm: optNum[1] };
  var optLet = raw.match(/option\s+([a-dA-D])/i);
  if (optLet) return { idx: {'a':0,'b':1,'c':2,'d':3}[optLet[1].toLowerCase()], spokenForm: optLet[1].toUpperCase() };
  return { idx: null, spokenForm: null };
}

// --- select option and ask confirm (records spoken form) ---
function selectOptionByIndexAndForm(idx, spokenForm) {
  var allOptions = document.querySelectorAll('input[name="ans"]');
  if (!allOptions || !allOptions[idx]) return;
  allOptions[idx].checked = true;
  lastSelectedIndex = idx;
  lastSpokenForm = spokenForm || null;
  awaitingConfirm = true;
  clearConfirmTimer();

  speakWithCallbackMale('Option ' + (idx+1) + ' selected.', function(){
    speakWithCallbackMale('May I submit?', function(){
      clearConfirmTimer();
      confirmTimer = setTimeout(function(){
        if (awaitingConfirm) submitAnswer();
      }, 10000); // 10 seconds
    });
  });
}

// --- handle spoken command ---
function handleCommand(command) {
  if (!command) return;
  command = command.toLowerCase().trim();
  console.log('Heard:', command);

  if (pausedAfterNo) {
    if (command.indexOf('repeat') !== -1) {
      pausedAfterNo = false;
      var t = buildReadText();
      if (t) speakWithCallbackMale(t, function(){ if (recognition) try{ recognition.start(); } catch(e){} });
      return;
    }
    if (command.indexOf('submit') !== -1 || command.indexOf('yes') !== -1) {
      pausedAfterNo = false;
      submitAnswer();
      return;
    }
    var m = tryMatchOptionWithForm(command);
    if (m.idx !== null) {
      pausedAfterNo = false;
      selectOptionByIndexAndForm(m.idx, m.spokenForm);
      return;
    }
    return;
  }

  if (awaitingConfirm) {
    if (command.indexOf('yes') !== -1 || command.indexOf('submit') !== -1) {
      submitAnswer();
      return;
    }
    if (command.indexOf('no') !== -1 || command.indexOf('nahi') !== -1) {
      awaitingConfirm = false;
      pausedAfterNo = true;
      clearConfirmTimer();
      speakWithCallbackMale('Okay. I will wait. Say repeat, submit or choose another option when you are ready.', function(){});
      return;
    }
    var m2 = tryMatchOptionWithForm(command);
    if (m2.idx !== null) {
      selectOptionByIndexAndForm(m2.idx, m2.spokenForm);
      return;
    }
    return;
  }

  if (command.indexOf('repeat') !== -1) {
    var t = buildReadText();
    if (t) speakWithCallbackMale(t, function(){ if (recognition) try{ recognition.start(); } catch(e){} });
    return;
  }
  if (command.indexOf('submit') !== -1 || command.indexOf('next') !== -1) {
    submitAnswer();
    return;
  }

  var match = tryMatchOptionWithForm(command);
  if (match.idx !== null) {
    selectOptionByIndexAndForm(match.idx, match.spokenForm);
    return;
  }

  if (command.length > 2) {
    speakWithCallbackMale('I did not understand. Say option one, option two, repeat, or submit.', function(){});
  }
}

// --- initialize recognition ---
function initRecognition() {
  if (!('SpeechRecognition' in window) && !('webkitSpeechRecognition' in window)) return null;
  try {
    var Rec = window.SpeechRecognition || window.webkitSpeechRecognition;
    var r = new Rec();
    r.lang = 'en-IN';
    r.interimResults = false;
    r.continuous = true;

    r.onresult = function(evt) {
      var last = evt.results[evt.results.length - 1];
      if (last && last[0]) {
        handleCommand(last[0].transcript);
      }
    };

    r.onerror = function(e) {
      console.warn('Recognition error', e);
      try { r.stop(); } catch(e){}
      setTimeout(function(){ try { r.start(); } catch(e){} }, 500);
    };

    r.onend = function() {
      if (window.location.search.indexOf('q=quiz') !== -1) {
        try { r.start(); } catch(e){}
      }
    };

    return r;
  } catch (ex) {
    return null;
  }
}

// --- start flow on page load ---
document.addEventListener('DOMContentLoaded', function(){
  if (window.location.search.indexOf('q=quiz') === -1) return;
  ensureVoicesLoaded(function() {
    window._maleVoice = findMaleVoice();
    if (!recognition) recognition = initRecognition();
    try { if (recognition) recognition.stop(); } catch(e){}
    var read = buildReadText();
    if (read) {
      speakWithCallbackMale(read, function(){
        if (recognition) {
          try { recognition.start(); } catch(e){}
        }
      });
    } else {
      if (recognition) {
        try { recognition.start(); } catch(e){} 
      }
    }
  });
});

// cleanup
window.addEventListener('beforeunload', function(){
  clearConfirmTimer();
  try { if (recognition) recognition.stop(); } catch(e){}
});
</script>

</body>
</html>