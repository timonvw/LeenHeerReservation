<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    
    require_once "includes/init.php";

    $controller = new AppointmentController();
    $subjects = $controller->getSubjects();
    $messages = [];

    if(isset($_POST['submit']))
    {
        $messages = $controller->save($_POST/*, $_FILES*/);

        if($messages[0] == "")
        {
            header("location:includes/views/viewsucceed.php?l=".$_POST['last']."&e=".$_POST['email']."&d=".$_POST['afspraak-date']."&t=".$_POST['hiddenTime']);
        }
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
    <title>Leenheern Administraties Afpsraak</title>
    <meta name="author" content="Leenheer Administraties">
    <meta name="description" content="Afspraak maken Leenheer Administraties">
    <meta name="theme-color" content="#FFCE06"/>
    <meta name="msapplication-navbutton-color" content="#FFCE06">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="icon" href="includes/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="includes/images/favicon.ico" type="image/x-icon">

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body class="background">
    <header>
        <div id="logo"><img class="unselectable" src="includes/images/logo.png"></div>
        
        <button onclick="OpenMenuButtonClick()" id="menuButton"><img src="includes/images/menu-icon.png"></button>
        <div id="menuHidden" class="menuOverlay">
            <a href="javascript:void(0)" class="closeButton" onclick="CloseMenuButtonClick()">&times;</a>
            <div class="menuOverlay-actions">
                <a href="#" onclick="CloseMenuButtonClick()">afspraak maken</a>
                <!--<a href="#" onclick="CloseMenuButtonClick()">home</a>
                <a href="#" onclick="CloseMenuButtonClick()">over</a>
                <a href="#" onclick="CloseMenuButtonClick()">diensten</a>
                <a href="#" onclick="CloseMenuButtonClick()">contact</a>-->
            </div>
        </div>
    </header>

    <div class="container_center">
        <div class="h_text"><h1>afspraak maken</h1></div>
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
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container_center">
            <div class="form_page" id="expand">
                <input class="input" id="date-input" type="date" name="afspraak-date" onchange="calcDate(this)" required>
                <div class="input" id="times_container"></div>
                <input type="hidden" id="hiddenTime" name="hiddenTime" value="" required>
                <div id="hidden">
                    <input class="input" type="text" name="first" placeholder="voornaam" required>
                    <input class="input" type="text" name="last" placeholder="achternaam" required>
                    <input class="input" type="email" name="email" placeholder="email" required>
                    <input class="input" type="text" name="phone" placeholder="telefoonnummer" required>
                    <select class="input" name="subject" required>
                        <option value="">kies een onderwerp</option>
                        <?php   
                            foreach($subjects as $subject)
                            {
                                echo "<option value='{$subject}'>{$subject}</option>";
                            }
                        ?>
                    </select>
                    <textarea name="description" id="text_area" class="input" cols="30" rows="5" placeholder="beschrijving"></textarea>
                    <input id="file_upload" type="file" name="file" accept="application/pdf">
                    <div id="recap" class="g-recaptcha" data-sitekey="6LcYy4wUAAAAANSb4iOq45W8r50jJ2RC_GOR9-B3"></div>
                </div>
            </div>
        </div>
        <div class="container_center">
        <input type="submit" id="submit" name="submit" value="inplannen">
        </div>
    </form>
</body>
</html>