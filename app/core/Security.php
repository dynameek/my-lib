<?php
    /*
     *  SECURITY CLASS
     *  *******************************************
     *  This class handles all security aspects of the application except SQL Injections
     *
    */
    class Security
    {
        private const tokenIdentifier = 'csrf_token';   #   Name by which tokens are saved in session variable
        
        /*  Generates a hashed random token */
        static function generateCSRFToken()
        {
            #   Generate Token
            return hash('sha256', rand(0, time()).random_bytes(15).time());
            
        }
        
        /*  */
        static function ensureLogIn($sess_marker)
        {
            if(!isset($_SESSION[$sess_marker])) header('location: ./');
        }
        /*
         *  Sets a token to a session variable
         *  It takes 1 parameter:
         *  1. The value to be saved
         *
         *  It has no return value
        */
        static function setCSRFSessionToken($token)
        {
            #   Set token to  a session variable
            $_SESSION[self::tokenIdentifier] = $token;
        }
        
        /*
         *  This generates a token
         *  Sets it in a session variable
         *  returns an input element of type = 'hidden'
         *
         *  It is to be used only in POST, PUT and DELETE forms
        */
        static function protectForm()
        {
            $token = self::generateCSRFToken();
            self::setCSRFSessionToken($token);
            
            return "<input type='hidden' name='".self::tokenIdentifier."' value='".$token."'>";
        }
        
        /*
         * This checks if a token is the same as that which is stored in the session varible
         * It takes on parameter:
         * 1. the token to be verified
         *
         * it returns true, if they are identical and false otherwise
        */
        static function verifyToken($token)
        {
            $retVal = false;
            if($_SESSION[self::tokenIdentifier] === $token)
                $retVal = true;
            
            #
            return $retVal;
        }
    }