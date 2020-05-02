<?php
class Blockeddate extends Database
{
    //haalt alle geblokkeerde datums op en zet deze in een array
    public function getAllBlockedDates()
    {
        $sql = "SELECT * FROM blockeddate";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            return $data;
        }
        else
        {
            return "";
        }
    }

    //haalt de datum en tijd van alle afpsraken op en zet deze in een array
    public function getAllTakenDates()
    {
        $sql = "SELECT date,time FROM appointments";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            return $data;
        }
        else
        {
            return "";
        }
    }

    public function getAllTimes()
    {
        $sql = "SELECT time FROM times";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            foreach($data as $time)
            {   
                $newData[] = $time['time']; 
            }
            
            return $newData;
        }
        else
        {
            return "";
        }
    }

    public function getAllTimesID()
    {
        $sql = "SELECT * FROM times";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            return $data;
        }
        else
        {
            return "";
        }
    }

    public function getAllSubjects()
    {
        $sql = "SELECT subject FROM subjects";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            foreach($data as $subject)
            {   
                $newData[] = $subject['subject']; 
            }

            return $newData;
        }
        else
        {
            return "";
        }
    }

    public function deleteDate($id)
    {
        $sql = "DELETE FROM blockeddate WHERE id={$id}";
       
        if($this->connect()->query($sql))
        {
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }        
    }

    public function deleteTime($id)
    {
        $sql = "DELETE FROM times WHERE id={$id}";
       
        if($this->connect()->query($sql))
        {
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }        
    }

    public function addTime($time)
    {
        
        $time2    = htmlentities($this->connect()->real_escape_string($time));
        
        $sql = "INSERT INTO times
        (
            time
        )
        VALUES 
        (
            '$time2'
        )";

        if($this->connect()->query($sql))
        {
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }
    }

    public function addDate($date)
    {
        
        $date2    = htmlentities($this->connect()->real_escape_string($date));
        
        $sql = "INSERT INTO blockeddate
        (
            date
        )
        VALUES 
        (
            '$date2'
        )";

        if($this->connect()->query($sql))
        {
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }
    }

    public function addUser($data)
    {
        
        $date2    = htmlentities($this->connect()->real_escape_string($date));
        $date2    = htmlentities($this->connect()->real_escape_string($date));
        
        $sql = "INSERT INTO users
        (
            date
        )
        VALUES 
        (
            '$date2'
        )";

        if($this->connect()->query($sql))
        {
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }
    }
}
?>