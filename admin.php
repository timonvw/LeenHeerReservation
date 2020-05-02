<?php
    session_start();

    if(isset($_SESSION['login']))
    {
        header("Location:calender.php");
    }

    require_once "includes/init.php";

    $controller = new LoginController();
    $messages = [];

    if(isset($_POST['submit']))
    {
        $message[] = $controller->login($_POST);
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
    <title>Leenheern Administraties Inlog</title>
    <meta name="theme-color" content="#FFCE06"/>
    <meta name="msapplication-navbutton-color" content="#FFCE06">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="icon" href="includes/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="includes/images/favicon.ico" type="image/x-icon">
</head>
<body class="background">
    <header>
        <div id="logo"><img class="unselectable" src="includes/images/logo.png"></div>
    </header>

    <div class="container_center">
        <div class="h_text"><h1>inlog admin</h1></div>
    </div>
    <div class="container_center">
        <?php
            if(!empty($messages))
            {
                echo "<div id='message'>";
                foreach($messages as $message)
                {
                    echo "<br>- ".$message;
                }
                echo "</div>";
            }
        ?>
    </div>
    <form action="" method="post">
        <div class="container_center">
            <div id="succeed_page">
                <input class="input" id="top_margin_fix" type="username" name="username" placeholder="gebruikersnaam of email" required>
                <input class="input" type="password" name="password" placeholder="wachtwoord" required>
            </div>
        </div>
        <div class="container_center">
        <input type="submit" class="button" name="submit" value="inloggen">
        </div>
    </form>
</body>
</html>