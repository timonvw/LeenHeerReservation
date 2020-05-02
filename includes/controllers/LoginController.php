<?php
class LoginController
{
    // public function __constructor()
    // {

    // }

    public function login($request)    
    {
        $validator = new LoginValidator($request);

        if($validator->getIsValid())
        {
            $user = $validator->getUser();
            return [$user->login()];
        }
        else
        {
            return $validator->getErrors();
        }
    }

    public function logout()
    {
        //uitloggen
    }
}
?>