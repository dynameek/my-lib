<?php
	session_start();
	session_regenerate_id();
	
    #
    function __autoload($className)
    {
        #   
        if(file_exists('./app/core/'.$className.'.php'))
		{
           require_once('./app/core/'.$className.'.php');
		}
        elseif (file_exists('./app/classes/'.$className.'.php'))
		{
            require_once('./app/classes/'.$className.'.php');
		}
        elseif (file_exists('../classes/'.$className.'.php'))
		{
            require_once('../classes/'.$className.'.php');
		}
        else require_once('../core/'.$className.'.php');
    }
    