<?php 
class LoginValidator extends Validator 
{
    protected function validate(): bool
    {
        //kijken of alle velden niet leeg zijn
        if($this->isEmpty($this->data['username']))    $this->errorMessages[] = "vul uw gebruikersnaam of email in";
        if($this->isEmpty($this->data['password']))     $this->errorMessages[] = "vul uw wachtwoord in";

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

    //alle data van de POST in een appointment object zetten en returnen
    public function getUser(): User
    {
        return new User
        (
            $this->data['username'],
            $this->data['password']
        );
    }
}
?>