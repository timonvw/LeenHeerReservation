<?php
class ViewBlockeddate extends Blockeddate
{
    public function showAllDates()
    {
        $dates = $this->getAllBlockedDates();

        foreach ($dates as $date) 
        {
            echo "".$date['date'].",";
        }
    }
}
?>