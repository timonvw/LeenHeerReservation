<?php
    require_once "../init.php";

    //alle data ophalen uit de database
    $blocked_date = new blockeddate();
    $dates = $blocked_date->getAllBlockedDates();
    $taken_date = $blocked_date->getAllTakenDates();
    $times = $blocked_date->getAllTimes();
    
    //de meegeleverde waarde ophalen
    $q = $_REQUEST["q"];
    $w = $_REQUEST["w"];

    //huidige datum ophalen
    $current_date = date('Y-m-d');
    
    //kijken of het zaterdag of zondag is
    if($w == 0 || $w == 6)
    {
        echo "in het weekend zijn we dicht helaas :(";
    }
    else
    {
        //alle geblokkeerde datums doorgaan
        foreach ($dates as $date) 
        {
            //als de datum geblokkeerd is of in het verleden of vandaag, dan niks laten zien en stoppen
            if($date['date'] == $q || $q <= $current_date)
            {
                echo "er zijn helaas geen tijden beschikbaar op deze dag :(";
                return;
            }
        }

        //alle afspraken doorgaan
        foreach ($taken_date as $taken)
        {
            //kijken welke afspraken dezelfde datum hebben als ingevuld in form
            if($taken['date'] == $q)
            {
                //als er een zelfde datum is dan deze tijd ervan uit de beschikbare tijden array halen
                if (($key = array_search($taken['time'], $times)) !== false) 
                {
                    unset($times[$key]);
                }
            }
        }

        //tijdknoppen neerzetten
        foreach ($times as $time)
        {
            $output = "";

            //kijken of de tijd begint met een 0 (dus 09:00:00 bvb) zo ja dan:
            if(preg_match("#([0]{1}[0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", $time))
            {
                //de eerste 0 weghalen en de laatste nullen weghalen (09:00:00 word -> 9:00)
                $output = preg_replace("#([0]{1})([0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", "$2:$3", $time);
            }
            else
            {
                //als de tijd niet begint met een 0 (dus 11:00:00 bvb), alleen de laatste nullen verwijderen (11:00:00 word -> 11:00)
                $output = preg_replace("#([1-2]{1})([0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", "$1$2:$3", $time);
            }

            echo "<div class='time_block' name='' onclick='expandForm(this)' value='".$time."'><span>".$output."</span></div>";
        }

        if(empty($times))
        {
            echo "Alle afspraken op deze dag zijn al bezet :(";
        }
    }

?>