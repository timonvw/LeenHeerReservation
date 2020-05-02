<?php
abstract class Validator
{
    protected $isvalid = true;
    protected $data = [];
    protected $errorMessages = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->isvalid = $this->validate();
    }

    public function getIsValid()
    {
        return $this->isvalid;
    }

    public function getErrors()
    {
        return $this->errorMessages;
    }

    protected function isEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    protected function isDate($date)
    {
        $format = "Y-m-d";
        $da = DateTime::createFromFormat($format, $date);

        if(!($da && $da->format($format) === $date))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    protected function isTime($time)
    {
        return preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})#", $time);
    }

    protected function isEmpty($variable)
    {
        if(empty($variable))
        {
            return true;
        }
        else
        {
           return false;
        }
    }

    protected abstract function validate(): bool;
}
?>