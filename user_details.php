<?php

class user_details{
    var $fname;
    public $username;
    var $yob;
    protected $email_address;
    private $password;

    public function computer_user($fname){
        return $fname;

    }

    public function user_age($fname, $yob){
        $age = date('Y')- $yob;
        return "<h1>". $fname. " is ". $age ."</h1>";
    }

}




?>
// https://github.com/mundabenj/api_d.git