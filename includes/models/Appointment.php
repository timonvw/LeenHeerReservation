<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Appointment extends Model
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $subject; 
    public $description; 
    public $date; 
    public $time;
    public $file; 
    
    public function __construct
    ( 
        string $firstname = null, 
        string $lastname = null, 
        string $email = null,
        string $phone = null, 
        string $subject = null, 
        string $description = null, 
        string $date = null, 
        string $time = null,
        int $id = null,
        array $file = null
    )
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->subject = $subject;
        $this->description = $description;
        $this->date = $date;
        $this->time = $time;
        $this->file = $file;
    }

    public function save()
    {
        $database = new Database();

        $firstname    = htmlentities($database->connect()->real_escape_string($this->firstname));
        $lastname     = htmlentities($database->connect()->real_escape_string($this->lastname));
        $email        = htmlentities($database->connect()->real_escape_string($this->email));
        $phone        = htmlentities($database->connect()->real_escape_string($this->phone));
        $subject      = htmlentities($database->connect()->real_escape_string($this->subject));
        $description  = htmlentities($database->connect()->real_escape_string($this->description));
        $date         = htmlentities($database->connect()->real_escape_string($this->date));
        $time         = htmlentities($database->connect()->real_escape_string($this->time));
        
        $sql = "INSERT INTO appointments
        (
            firstname, 
            lastname, 
            email, 
            phone_number, 
            subject, 
            description, 
            date, 
            time, 
            user_id
        )
        VALUES 
        (
            '$firstname',
            '$lastname',
            '$email',
            '$phone',
            '$subject',
            '$description',
            '$date',
            '$time',
            1
        )";

        if($database->connect()->query($sql))
        {
            $this->sendMail(1);
            /*if(!empty($file))
            {
                echo "FILE WERKT 2";
                move_uploaded_file($this->file[0],"../files/".$this->file[1]);
            }*/
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }
    }

    protected function getTableName(): string 
    {
        return 'appointments';
    }

    public function getTime()
    {
         //kijken of de tijd begint met een 0 (dus 09:00:00 bvb) zo ja dan:
         if(preg_match("#([0]{1}[0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", $this->time))
         {
             //de eerste 0 weghalen en de laatste nullen weghalen (09:00:00 word -> 9:00)
             return preg_replace("#([0]{1})([0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", "$2:$3", $this->time);
         }
         else
         {
             //als de tijd niet begint met een 0 (dus 11:00:00 bvb), alleen de laatste nullen verwijderen (11:00:00 word -> 11:00)
             return preg_replace("#([1-2]{1})([0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", "$1$2:$3", $this->time);
         }
    }

    public function update()
    {
        $database = new Database();

        $firstname    = htmlentities($database->connect()->real_escape_string($this->firstname));
        $lastname     = htmlentities($database->connect()->real_escape_string($this->lastname));
        $email        = htmlentities($database->connect()->real_escape_string($this->email));
        $phone        = htmlentities($database->connect()->real_escape_string($this->phone));
        $subject      = htmlentities($database->connect()->real_escape_string($this->subject));
        $description  = htmlentities($database->connect()->real_escape_string($this->description));
        $date         = htmlentities($database->connect()->real_escape_string($this->date));
        $time         = htmlentities($database->connect()->real_escape_string($this->time));

        $sql = "UPDATE appointments
            SET firstname='$firstname',
            lastname='$lastname',
            email='$email',
            phone_number='$phone', 
            subject='$subject',
            description='$description', 
            date='$date',
            time='$time',
            user_id=1
            WHERE id=".$this->id;

        if($database->connect()->query($sql))
        {
            //$this->sendMail(2);
            session_start();
            $_SESSION["message"] = "{$this->firstname} {$this->lastname} is succesvol aangepast";
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }
    }
    
    public function delete()
    {
        $database = new Database();
        
        $sql = "DELETE FROM appointments WHERE id=".$this->id;

        if($database->connect()->query($sql))
        {
            session_start();
            $_SESSION["message"] = "{$this->firstname} {$this->lastname} is succesvol verwijderd";
            return "";
        }
        else
        {
            return die('oops, er is iets mis gegaan. probeer opniew :(');
        }        
    }

    //De afspraak als een blok laten zien met delete, edit en knop kalender toevoeg   <---- normaal geen html in een model class maar ik had haast en ben nu al tever heen :(
    public function show($key, bool $isNew)
    {
        return "<div class='balk'>
        <div class='one'>".$this->firstname ." ". $this->lastname."</div>
        <div class='second'>".date("d-m-Y", strtotime($this->date))."</div>
        <div class='third'>".$this->getTime()."</div>
        <div class='fourth'>". ($isNew ? "<input type='image' src='includes/images/add.png' width='30px' height='30px' title='toevoegen aan google kalender'/>" : "") ."</div>
        <div class='fourth'><input type='image' src='includes/images/update.png' width='30px' height='30px' title='bewerken / info tonen' onclick='openHidden({$key})'/></div>
        <div class='fourth'><form action='' method='post'><input type='hidden'name='key' value='{$key}'><input class='deletebutton' type='submit'name='delete'title='verwijderen' value=''></form></div>
        </div>
        <div class='container_center'>
        <div class='hidden_appointment_div' id='{$key}'>
            <form id='form{$key}' action='' method='post'>
            <div id='form_update'>
                <input type='hidden'name='key' value='{$key}'>
                <input class='input' id='date-input' type='date' name='afspraak-date' value='{$this->date}'required>
                <input class='input' type='time' name='time' value='{$this->time}'required>
                <input class='input' type='text' name='first' placeholder='voornaam' value='{$this->firstname}'required>
                <input class='input' type='text' name='last' placeholder='achternaam' value='{$this->lastname}'required>
                <input class='input' type='email' name='email' placeholder='email' value='{$this->email}'required>
                <input class='input' type='text' name='phone' placeholder='telefoonnummer' value='{$this->phone}'required>
                <input class='input' type='text' name='subject' placeholder='onderwerp' value='{$this->subject}'required>
                <textarea class='input' name='description' id='text_area' cols='30' rows='5' placeholder='beschrijving'>{$this->description}</textarea>
                <input type='submit' id='submit_update' name='update' value='aanpassingen opslaan'>
            </div>
            </form>
        </div>
        </div>";
    }

    protected function sendMail($id)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try 
        {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.sendgrid.net';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'apikey';                             // SMTP username
            $mail->Password = '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';                      // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('leenheer@timonvanwaardhuizen.nl');
            $mail->addAddress($this->email);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC($this->email);
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->AddEmbeddedImage('/../images/logo.png', 'logo');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Conformatie afspraak Leenheer Administraties';
            
            if($id == 1)
            {
                $mail->Body    = 'Beste meneer/mevrouw '.$this->lastname.',
                <br><br>Uw afspraak is bevestigd en gepland op: <b>'.date("d-m-Y", strtotime($this->date)).'</b> om <b>'.$this->time.'</b> uur.
                <br>Klik <a href="https://www.google.com/calendar/render?action=TEMPLATE&sf=true&output=xml&text=Afspraak%20Leenheer%20Administraties&location=Aarnoudstraat%2036,%203084%20PB%20Rotterdam,%20Nederland&details=&dates='.$this->date.'T'.$this->time.'Z/'.$this->date. 'T'.$this->time.'Z">hier</a> om uw afspraak in Google Calendar te zetten.
                <br>U kunt contact opnemen om uw afspraak te wijzigen of te verwijderen.
                <br><br>Met vriendelijke groet,
                <br>Arielle Leenheer.
                <br><br><br><h2>contact</h2>
                <b>Telefoon: </b>010 254 0313<br>
                <b>Email: </b>info@leenheeradministraties.com<br>
                <b>Adres: </b>Nieuwe Binnenweg 91, 3014GG Rotterdam<br>';
            }
            else
            {
                $mail->Body    = 'Beste meneer/mevrouw '.$this->lastname.',
                <br><br>Uw afspraak gegevens zijn gewijzigd.
                <br>Uw afspraak gegevens zijn:
                <br><b>Voornaam: </b>'.$this->firstname.'
                <br><b>Achternaam: </b>'.$this->lastname.'
                <br><b>Email: </b>'.$this->email.'
                <br><b>Telefoonnummer: </b>'.$this->phone.'
                <br><b>Onderwerp: </b>'.$this->subject.'
                <br><b>Beschrijving: </b>'.$this->description.'
                <br><b>Datum: </b>'.date("d-m-Y", strtotime($this->date)).'
                <br><b>Tijd: </b>'.$this->time.'
                <br><br>Met vriendelijke groet,
                <br>Arielle Leenheer.
                <br><br><br><h2>contact</h2>
                <b>Telefoon: </b>010 254 0313<br>
                <b>Email: </b>info@leenheeradministraties.com<br>
                <b>Adres: </b>Nieuwe Binnenweg 91, 3014GG Rotterdam<br>';
            }
           
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            //echo $this->email;
            //echo 'Message has been sent';
        } 
        catch (Exception $e) 
        {
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
?>