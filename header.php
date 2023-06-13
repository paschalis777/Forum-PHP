<!doctype html>
<html>

<head>
<title>Online Forum </title>
<link rel="stylesheet" href="style/style.css">
</head>

<body>
<h1> Online Forum</h1>
  <div id="wrapper">
  <div id="menu">
      <a class="item" href="indexx.php"> Αρχική </a>
      <a class="item" href="create_topic.php"> Δημιούργησε θέμα </a>
      <a class="item" href="create_cat.php"> Δημιούργησε κατηγορία</a>
    </div>

  <div id="userbar">

  <div id="userbar">
    <?php
    session_start();

      if(isset($_SESSION['signed_in']))
      {
          echo 'Καλωσόρισες ' . $_SESSION['user_name'] . '! Δεν είσαι εσύ; <a href="signout.php">Sign out</a>';
      }
      else
      {
          echo '<a href="signin.php"> Συνδεθείτε </a> η <a href="signup.php"> Δημιουργία λογαριασμού</a>.';
      }
      ?>
  </div>
  </div>

  <div id="content">