<?php
session_start();

if(!isset($_SESSION['login']))
{
     header("Location:admin.php");
}
require_once "includes/init.php";

$messages = [];

if(isset($_SESSION["message"]))
{
     $messages[] = $_SESSION["message"];
}

$controller = new AppointmentController();
$appointments = $controller->show();
//var_dump($appointments);

if($appointments == "") $messages[] = "Oops er is iets mis gegaan :(";

if(isset($_POST['update']))
{
     $messages[] = $controller->update($_POST, $appointments[$_POST['key']]);
     header("location:calender.php");
}

if(isset($_POST['delete']))
{
     $messages[] = $appointments[$_POST['key']]->delete();
     header("location:calender.php");
}

if(isset($_POST['deleteMessage']))
{
     unset($_SESSION["message"]);
     header("location:calender.php");
}

if(isset($_POST['logout']))
{
     unset($_SESSION['login']);
     header("location:admin.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="includes/css/style.css">
    <script src="includes/js/main.js"></script>
    
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no">
    <title>Admin Panel</title>
    <meta name="theme-color" content="#FFCE06"/>
    <meta name="msapplication-navbutton-color" content="#FFCE06">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="icon" href="includes/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="includes/images/favicon.ico" type="image/x-icon">
</head>
<body class="background">
    <header>
        <div id="logo"><img class="unselectable" src="includes/images/logo.png"></div>
        <button onclick="OpenMenuButtonClick()" id="menuButton"><img src="includes/images/menu-icon.png"></button>
        <div id="menuHidden" class="menuOverlay">
            <a href="javascript:void(0)" class="closeButton" onclick="CloseMenuButtonClick()">&times;</a>
            <div class="menuOverlay-actions">
                <a href="calender.php" onclick="CloseMenuButtonClick()">Agenda</a>
                <a href="settings.php" onclick="CloseMenuButtonClick()">Instellingen</a>
                <a href="#" onclick="CloseMenuButtonClick()"><br><br><form method="post" action=""><input type="submit" id="logoutButton" name="logout" value="uitloggen"></form></a>
            </div>
        </div>
    </header>

    <div class="container_center">
        <div class="h_text"><h1>afspraken overzicht</h1></div>
    </div>

    <div class="container_center">
        <?php
            if(!empty($messages))
            {
               echo "<div id='messageList'>";
               echo "<form method='post' action=''><input id='messageDelete' value='' type='submit' title='verwijderen' name='deleteMessage'></form>";
               foreach($messages as $message)
               {
               echo "<br>- ".$message;
               }
               echo "</div>";
            }
        ?>
    </div>
     <div class="container_center">
          <div id="calendarbody">
          <?php
               echo "<p><h2>komend</h2></p>";
               foreach($appointments as $key => $appointment)
               {
                    if(date("Y-m-d") <= $appointment->date)
                    {
                         echo $appointment->show($key, true);
                    }
               }

               echo "<p><h2>geweest</h2></p>";
               //de appointments array omdraaien maar de zelfde keys behouden
               $reversedApp = array_reverse($appointments, true);

               foreach($reversedApp as $key => $appointment)
               {
                    if(date("Y-m-d") > $appointment->date)
                    {
                         echo $appointment->show($key, false);
                    }
               }
          ?>
          </div>
    </div>
</body>
</html>