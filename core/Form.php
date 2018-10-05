<?php
    /*  FORM CLASS
     *  **********
     *  This class handles basic form data sanitization
     *  It is extended by Controllers
    */
    class Form
    {
        public $formError = ''; #   Holds any errors encountered
        
        /*
         *  Hash Passwords
         *  It returns a hashed password
        */
        static function hashPassword($password)
        {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => 20]);
        }
        
        /*
         *  Checks if passwords are a match
         *  It takes two parameters:
         *  1. the hashed password
         *  2. the password to check
         *
         *  It returns true, if they match and false otherwise
        */
        static function doPasswordsMatch($hash, $password)
        {
            $retVal = false;
            if(password_verify($password, $hash)) $retVal = true;
            
            #
            return $retVal;
        }
        
        /*
         *  Checks if a variable is long enough
         *  It takes 2 parameters:
         *  1. the variable to check
         *  2. the length to check against
         *
         *  it returns true, if password is long enough and false otherwise
         *
        */
        static function isLongEnough($var, $min_length)
        {
            $retVal = false;
            if(strlen($var) >= $min_length) $retVal = true;
            #
            return $retVal;
        }
        
        /*
         *  @method bool checkEmptiness(mixed $arr)
         *  Checks if any of alement is empty
         *  It takes one parameter:
         *  1. array for variables
         *
         *  Returns true, if all elements are not empty, false otherwise.
         *
        */
        static function checkEmptiness($mixed = [])
        {
            $retVal = true;
            foreach($mixed as $value)
            {
                if(empty($value))
                {
                    $retVal = false;
                    break;
                }
            }
            
            return $retVal;
        }
        
        /*
         *  Checks if email adress meets the global standard
         *  It takes 1 parameter:
         *  1. The email address to be checked
         *
         *  It returns true, if email is valid and false otherwise
        */
        static function isEmailValid($email)
        {
            $retVal = false;
            $unwantedCharPattern = "/[^\w\@\.]/";                               #   Any character(s) other than this is unwanted
            $structurePattern = "/\w+\.*\@(\w+\.)+[^(\.\.)]([A-Za-z0-9]*)$/";   #   Outlines the valid structure of the email
            if(!preg_match($unwantedCharPattern, $email) && preg_match($structurePattern, $email))
                $retVal = true;
            
            #
            return $retVal;
        }
    }