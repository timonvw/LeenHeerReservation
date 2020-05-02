<?php
class SettingController
{
    // public function __constructor()
    // {

    // }

    //geblokkeerde data's ophalen
    public function showBlockedDates()
    {
        $info = new blockeddate();
        return $info->getAllBlockedDates();
    }

    //alle tijden ophalen
    public function showTimes()
    {
        $info = new blockeddate();
        return $info->getAllTimesID();
    }

    //alle gebruikers ophalen
    public function showUsers()
    {
        $users = new User();
        $users = $users->get("ORDER BY id");

        $userssObj = [];

        foreach($users as $user)
        {
            $userssObj[] = new User($user['username'],
            $user['password'],
            $user['id'],
            $user['email']);
        }
        return $userssObj;
    }

    //geblokkeerde date verwijderen
    public function deleteDate($date)
    {
        $info = new blockeddate();
        if($info->deleteDate($date['id']) == "")
        {
            session_start();
            $_SESSION["messageSettings"] = $date['date']." is succesvol verwijderd";
        }
    }

    //tijd verwijderen
    public function deleteTime($time)
    {
        $info = new blockeddate();
        if($info->deleteTime($time['id']) == "")
        {
            session_start();
            $_SESSION["messageSettings"] = $time['time']." is succesvol verwijderd";
        }
    }

    //gebruikers verwijderen
    public function deleteUser($obj)
    {
        if($obj->getID() != 1)
        {
            $message = $obj->delete();

            if($message == "")
            {
                session_start();
                $_SESSION["messageSettings"] = $obj->username." is succesvol verwijderd";
            }
            else
            {
                session_start();
                $_SESSION["messageSettings"] = "".$message;
            }
        }
        else
        {
            session_start();
            $_SESSION["messageSettings"] = "u kunt de hoofd admin niet verwijderen";
        }
    }

    //tijd toevoegen
    public function addTime($request)
    {
        $info = new blockeddate();
        if($info->addTime($request['time']) == "")
        {
            session_start();
            $_SESSION["messageSettings"] = $request['time']." is succesvol toegevoegd";
        }
    }

    //datum toevoegen
    public function addDate($request)
    {
        $info = new blockeddate();
        if($info->addDate($request['date'])== "")
        {
            session_start();
            $_SESSION["messageSettings"] = $request['date']." is succesvol toegevoegd";
        }
    }

    //gebruiker toevoegen
    public function addUser($request)
    {
        $obj = new User($request['username'],$request['password'], null, $request['email']);
        $message = $obj->save();

        if($message == "")
        {
            session_start();
            $_SESSION["messageSettings"] = $obj->username." is succesvol toegevoegd";
        }
        else
        {
            session_start();
            $_SESSION["messageSettings"] = "".$message;
        }
    }
}
?>