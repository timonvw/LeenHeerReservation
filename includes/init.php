<?php 
    //libaries
    require_once __DIR__ ."/../vendor/autoload.php";
    //require __DIR__ . "/domains/timonvanwaardhuizen.nl/public_html/leenheer/vendor/autoload.php";

    //standaard
    require_once "classes/Database.php";
    require_once "classes/BlockedDate.php";
    require_once "models/Model.php";
    require_once "classes/Validator.php";

    //afspraken
    require_once "models/Appointment.php";
    require_once "validators/AppointmentValidator.php";
    require_once "controllers/AppointmentController.php";
    
    //gebruikers en login
    require_once "models/User.php";
    require_once "validators/LoginValidator.php";
    require_once "controllers/LoginController.php";
    require_once "controllers/SettingController.php";
?>