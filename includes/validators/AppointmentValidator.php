<?php 
class AppointmentValidator extends Validator 
{
    public $fileArray = [];

    protected function validate(): bool
    {
        $blockedDate = new blockeddate();
        $dates = $blockedDate->getAllBlockedDates();
        $takenDates = $blockedDate->getAllTakenDates();
        $times = $blockedDate->getAllTimes();
        $subjects = $blockedDate->getAllSubjects();

        //kijken of alle velden niet leeg zijn
        if($this->isEmpty($this->data['first']))    $this->errorMessages[] = "vul uw voornaam in";
        if($this->isEmpty($this->data['last']))     $this->errorMessages[] = "vul uw achternaam in";
        if($this->isEmpty($this->data['phone']))    $this->errorMessages[] = "vul uw telefoonnummer in";

        //kijken of de datum niet leeg is
        if(!$this->isEmpty($this->data['afspraak-date']))
        {
            //kijken of de datum een datum is
            if($this->isDate($this->data['afspraak-date']))
            {
                //kijken of de datum niet geblokkeerd is
                foreach($dates as $date)
                {
                    if($date['date'] == $this->data['afspraak-date']) $this->errorMessages[] = " deze datum is niet beschikbaar, kies een andere datum";
                }
            }
            else
            {
                $this->errorMessages[] = $this->data['afspraak-date']." is geen geldige datum";
            }
        }
        else
        {
            $this->errorMessages[] = "selecteer een datum";
        }

        //kijken of de tijd niet leeg is
        if(!$this->isEmpty($this->data['hiddenTime']))
        {
            //kijken of de tijd een tijd is
            if($this->isTime($this->data['hiddenTime']))
            {
                //kijken of de tijd wel een beschikbare tijd is
                if(in_array($this->data['hiddenTime'], $times))
                {
                    //kijk of de datum en de daarbij horende tijd niet al bezet is
                    foreach($takenDates as $date)
                    {
                        if($date['date'] == $this->data['afspraak-date'])
                        {
                            if($date['time'] == $this->data['hiddenTime']) $this->errorMessages[] = $this->data['time']." dit tijdstip is niet beschikbaar, kies een andere tijd";
                        }
                    }
                }
                else
                {
                    $this->errorMessages[] = "tijd bestaat niet, kies een andere tijd";
                }
            }
            else
            {
                $this->errorMessages[] = $this->data['hiddenTime']." is geen geldige tijd";
            }
        }
        else
        {
            $this->errorMessages[] = "selecteer een tijd";
        }

        //kijken of de email niet leeg is
        if(!$this->isEmpty($this->data['email']))
        {
            //kijken of de email een email is
            if(!$this->isEmail($this->data['email']))  $this->errorMessages[] = $this->data['email']." is geen geldige email";
        }
        else
        {
            $this->errorMessages[] = "vul uw email in";
        }

        //check op subject uit de database
        if(!$this->isEmpty($this->data['subject']))
        {
            if(!in_array($this->data['subject'], $subjects))
            {
                $this->errorMessages[] = $this->data['subject']." onderwerp bestaat niet, kies een ander onderwerp";
            }
        }
        else
        {
            $this->errorMessages[] = "kies een onderwerp";
        }

        //<==============FILEEEEE==================>
        if(isset($this->data['file']))
        {
            echo "LOL";
        }


        //kijken of er error messages zijn
        if($this->isEmpty($this->errorMessages))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function validateFile($file)
    {
        $f_name = $file['file']['name'];
        $f_size = $file['file']['size'];
        $f_tmp  = $file['file']['tmp_name'];
        $f_type = $file['file']['type'];
        $f_ext  = pathinfo($f_name, PATHINFO_EXTENSION);
        
        if($f_ext == "pdf")
        {
            if($f_size < 2000000)
            {
                $counter = 0;
                $rawName = pathinfo($f_name, PATHINFO_FILENAME);
                $extension = pathinfo($f_name, PATHINFO_EXTENSION);

                while(file_exists("../files/".$f_name)) 
                {
                    $f_name = $rawName.$counter.'.'.$extension;
                    $counter++;
                };
                
                //move_uploaded_file($f_tmp,"../files/".$f_name);

                $this->fileArray[0] = $f_tmp;
                $this->fileArray[1] = $f_name;
            }
            else
            {
                $this->errorMessages[] = "bestandgrootte mag niet groter zijn dan 2mb";
            }
        }
        else
        {
            $this->errorMessages[] = "alleen pdf bestanden kunnen geupload worden";
        }
    }

    //alle data van de POST in een appointment object zetten en returnen
    public function getAppointment(): Appointment
    {
        return new Appointment
        (
            $this->data['first'],
            $this->data['last'],
            $this->data['email'],
            $this->data['phone'],
            $this->data['subject'],
            $this->data['description'],
            $this->data['afspraak-date'],
            $this->data['hiddenTime'],
            null,
            $this->fileArray
        );
    }
}
?>