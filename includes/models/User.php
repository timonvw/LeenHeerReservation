<?php
class User extends Model
{
    private $id;
    private $password;
    public $email;
    public $username;
    
    public function __construct
    ( 
        string $username = null, 
        string $password = null,
        int $id = null,
        string $email = null
    )
    {
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
        $this->email = $email;
    }

    public function login()
    {
        $database = new Database();

        $username    = htmlentities($database->connect()->real_escape_string($this->username));
        $password    = htmlentities($database->connect()->real_escape_string($this->password));
   
        //$sql = "SELECT id, username FROM users WHERE username = '$username' OR email = '$username' AND password =". password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT password, id FROM users WHERE username = '$username' OR email = '$username'";
        $result = $database->connect()->query($sql);
        $numRows = $result->num_rows;

        if($numRows == 1)
        {
            $row = $result->fetch_assoc();

            if(password_verify($password, $row['password']))
            {
                $_SESSION['userid'] = $row['id'];
                $_SESSION['login'] = "valid";
                header("Location:calender.php");
                return "gelukt";
            }
            else
            {
                return "wachtwoord is onjuist";
            }
        }
        else
        {
            return "oops, er is iets mis gegaan. probeer opniew :(";
        }
    }

    public function getID()
    {
        return $this->id;
    }

    public function logout()
    {
        //
    }

    protected function getTableName(): string 
    {
        return 'users';
    }

    public function save()
    {
        $database = new Database();

        $email    = htmlentities($database->connect()->real_escape_string($this->email));
        $username = htmlentities($database->connect()->real_escape_string($this->username));
        $password = htmlentities($database->connect()->real_escape_string($this->password));
        
        $sql_u = "SELECT * FROM users WHERE username='$username'";
        $sql_e = "SELECT * FROM users WHERE email='$email'";

        $res_u = $database->connect()->query($sql_u);
        $res_e = $database->connect()->query($sql_e);

        if($res_u->num_rows > 0)
        {
            return "gebruikersnaam is al bezet :(";
        }
        else if($res_e->num_rows > 0)
        {
            return "email is al bezet :(";
        }
        else
        {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users
            (
                email, 
                username, 
                password
            )
            VALUES 
            (
                '$email',
                '$username',
                '$password_hash'
            )";
    
            if($database->connect()->query($sql))
            {
                return "";
            }
            else
            {
                return die('oops, er is iets mis gegaan. probeer opniew :('."<br>".$email."<br> ".$username."<br> ".$password_hash);
            }
        }
    }

    public function update()
    {
        //
    }
    
    public function delete()
    {
        if($this->id != 1)
        {
            $database = new Database();
            $sql = "DELETE FROM users WHERE id=".$this->id;

            if($database->connect()->query($sql))
            {
                return "";
            }
            else
            {
                return die('oops, er is iets mis gegaan. probeer opniew :(');
            }        
        }
        else
        {
            return "u kunt de hoofd admin niet verwijderen";
        }
    }
}
?>