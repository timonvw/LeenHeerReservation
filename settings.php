<?php
error_reporting(E_ALL); ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['login']))
{
     header("Location:admin.php");
}

require_once "includes/init.php";

$controller = new SettingController();
$times = $controller->showTimes();
$dates = $controller->showBlockedDates();
$users = $controller->showUsers();

$messages = [];

if(isset($_SESSION["messageSettings"]))
{
     $messages[] = $_SESSION["messageSettings"];
}

if(isset($_POST['deleteMessage']))
{
     unset($_SESSION["messageSettings"]);
     header("location:settings.php");
}

if(isset($_POST['logout']))
{
     unset($_SESSION['login']);
     header("location:admin.php");
}

if(isset($_POST['deleteDate']))
{
     $controller->deleteDate($dates[$_POST['key']]);
     header("location:settings.php");
}

if(isset($_POST['deleteTime']))
{
     $controller->deleteTime($times[$_POST['key']]);
     header("location:settings.php");
}

if(isset($_POST['deleteUser']))
{
     $controller->deleteUser($users[$_POST['key']]);
     header("location:settings.php");
}

if(isset($_POST['addTime']))
{
    $controller->addTime($_POST);
    header("location:settings.php");
}

if(isset($_POST['addDate']))
{
    $controller->addDate($_POST);
    header("location:settings.php");
}

if(isset($_POST['addUser']))
{
    $controller->addUser($_POST);
    header("location:settings.php");
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
    <title>Instellingen</title>
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
        <div class="h_text"><h1>instellingen</h1></div>
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
            <!--instellingen hier
                - tijden verwijderen en toevoegen
                - blokkeerde datums verwijderen en toevoegen
            -->
            <?php
                echo "<p><h2>geblokkeerde datums</h2></p>";
                foreach($dates as $key => $date)
                {
                    echo "<div class='balk'>
                    <div class='one'>".$date['date']."</div>
                    <div class='fourth'><form action='' method='post'><input type='hidden'name='key' value='{$key}'><input class='deletebutton' type='submit'name='deleteDate'title='verwijderen' value=''></form></div>
                    </div>";
                }

                echo "<div class='container_center'>
                <div class='settingAdd'>
                    <form action='' method='post'>
                        <input class='input' type='date' name='date'required>
                        <input type='submit' id='submit_update' name='addDate' value='datum toevoegen'>
                    </form>
                </div>
                </div>";

                echo "<p><h2>beschikbare tijden in het algemeen</h2></p>";
                foreach($times as $key => $time)
                {
                    echo "<div class='balk'>
                    <div class='one'>".$time['time']."</div>
                    <div class='fourth'><form action='' method='post'><input type='hidden'name='key' value='{$key}'><input class='deletebutton' type='submit'name='deleteTime'title='verwijderen' value=''></form></div>
                    </div>";
                }

                echo "<div class='container_center'>
                <div class='settingAdd'>
                    <form action='' method='post'>
                        <input class='input' type='time' name='time' value='00:00:00'required>
                        <input type='submit' id='submit_update' name='addTime' value='tijd toevoegen'>
                    </form>
                </div>
                </div>";

                echo "<p><h2>gebruikers</h2></p>";
                foreach($users as $key => $user)
                {
                    echo "<div class='balk'>
                    <div class='one'>".$user->username."</div>
                    ".($user->getID() != 1 ? "<div class='fourth'><form action='' method='post'><input type='hidden'name='key' value='{$key}'><input class='deletebutton' type='submit'name='deleteUser'title='verwijderen' value=''></form></div>" : "") ."
                    </div>";
                }

                echo "<div class='container_center'>
                <div class='settingAdd' id='long_setting_add'>
                    <form action='' method='post'>
                        <input class='input' type='email' name='email' value='email'required>
                        <input class='input' type='text' name='username' value='gebruikersnaam'required>
                        <input class='input' type='password' name='password' value='wachtwoord'required>
                        <input type='submit' id='submit_update' name='addUser' value='gebruiker toevoegen'>
                    </form>
                </div>
                </div>";
            ?>
        </div>
    </div>
</body>
</html>