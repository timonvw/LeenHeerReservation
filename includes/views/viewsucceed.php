<?php
    //require_once "../init.php";
    $last = $_GET['l'];
    $email = $_GET['e'];
    $date = $_GET['d'];
    $time = $_GET['t'];

    if(empty($_GET))
    {
        header("location:../../index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/main.js"></script>
    
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no">
    <title>Afspraak Gelukt</title>
    <meta name="theme-color" content="#FFCE06"/>
    <meta name="msapplication-navbutton-color" content="#FFCE06">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <style>
      #map 
      {
        margin-top: 20px;
        height: 310px;
        width: 100%;

        font-family: "Ubuntu", sans-serif;
        font-size: 16px;
        box-shadow: 5px 5px 10px -3px #69696980;
      }

      #plan_b
      {
        background-color: #FFCE06;
        color:white;
        text-align: center;

        
        height: 23px;
        width: 100px;
        border: none;
        box-shadow: 1px 1px 1px 1px #a1a1a180;
        cursor: pointer;
      }

      #link_map
      {
        text-decoration: none;
        font-family: "Ubuntu", sans-serif;
      }

    </style>
</head>
<body class="background">
    <header>
        <div id="logo"><img class="unselectable" src="../images/logo.png"></div>
    </header>

    <div class="container_center">
        <div class="h_text"><h1>afspraak maken gelukt</h1></div>
    </div>
    <div class="container_center">
        <div id="succeed_page">
        <?php
            echo "Geachte heer/mevrouw {$last} uw afspraak is gepland op:
            <br><u>".date("d-m-Y", strtotime($date))."</u> om <u>{$time}</u>.<br><br>Voor meer informatie is er een bevestigings mail gestuurd naar:
                <u>{$email}</u>."
        ?>
        <div id="map"></div>
        <script>
            var map;

            function initMap() 
            {
                    //nieuwe map maken
                    map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 51.8815298, lng: 4.4587699},
                    zoom: 14,
                    styles: [
                    {
                        "featureType": "landscape.man_made",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#dfecee"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#4a9da6"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#ffce06"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#79bec4"
                            }
                        ]
                    }]
                });

                    //marker toeveogen
                    var marker = new google.maps.Marker(
                    {
                        position:{lat: 51.8815298, lng: 4.4587699},
                        map:map,
                        icon: '../images/marker.png'
                    });

                    //info window toevoegen als op de marker word geklikt
                    var infoWindow = new google.maps.InfoWindow(
                    {
                        content:'<b>Leenheer Administraties</b><br><br><b>Telefoon: </b>010 254 0313<br><b>Email: </b>info@leenheeradministraties.com<br><b>Adres: </b>Nieuwe Binnenweg 91, 3014GG Rotterdam<br><br><button id="plan_b" type="button"><a id="link_map" href="https://www.google.com/maps/dir//Aarnoudstraat+36,+3084+PB+Rotterdam/@51.8790511,4.4611492,14.13z/data=!4m9!4m8!1m0!1m5!1m1!1s0x47c43470344eb1d1:0xed3ea692def9b7da!2m2!1d4.4597355!2d51.8818319!3e0" target="_blank">plan uw route</a></button>'
                    });

                    infoWindow.open(map,marker);

                    //listener voor marker
                    marker.addListener('click', function()
                    {
                        infoWindow.open(map,marker);
                    });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOfGfo8ofjuqkVC0YxAtBYBHqk5ZQsDX0&callback=initMap"async defer></script>
        </div>
    </div>
    <div class="container_center">
        <input type="submit" class="button" value="terug" onclick="toAppointment()">
    </div>

</body>
</html>