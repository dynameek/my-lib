<?php
    /*
     *  *****************
     *  *   ASSET CLASS *
     *  *****************
     *  This class is responsible for including app assets.
     *  By default, the supported assets are:
     *  1. Cascading StyleSheets (.css)
     *  2. JavaScript (.js)
     *  3. Media files (images)
     *
     *  This class, as with other classes can be extended and modified as per app needs
    */
    class Asset
    {
        const imageBasePath = '../app/assets/images/';   #   Base URI for images
        const styleBasePath = '../app/assets/css/';      #   Base URI for stylesheets
        const scriptBasePath = '../app/assets/js/';      #   Base uri for Javascript
        const viewElementPath = '../app/assets/viewElements/';      #   Base uri for viewElement
        
        /*
         *  This loads a HTML img element for the supplied image name
         *  It takes 3 parameters:
         *  1. The image name (e.g xyz.png)
         *  2. alternate value for alt attribute (optional)
         *  3. array of class names for the img element (optional)
         *
         *  It returns a HTML img element
        */
        static function loadImage($image, $alt = '', $classes = [])
        {
            $class_str = '';
            foreach($classes as $class)
            {
                $class_str .= $class.' '; 
            }
            $img = "<img alt='".$alt."' class='".$class_str."'
                    src='".self::imageBasePath.$image."'>";
            return $img;
        }
        
        /*
         *  This loads the required styles for the webpage
         *  It takes a parameter:
         *  1. an array of the names style names (e.g general.css)
         *
         *  it returns no value
        */
        static function loadStyles($stylesheets = [])
        {
            foreach($stylesheets as $stylesheet)
            {
                $lnk = "<link rel='stylesheet'
                        href='".self::styleBasePath.$stylesheet.".css'>";
                echo $lnk;
            }
        }
        
       
        /*
         *  This loads the required JavaScript files for the webpage
         *  It takes a parameter:
         *  1. an array of the names script names (e.g general.js)
         *
         *  it returns no value
        */
        static function loadJavaScripts($scripts = [])
        {
            foreach($scripts as $script)
            {
                $script = "<script src='".self::scriptBasePath.$script.
                ".js'> </script>";
                
                echo $script;
            }
        }

        /*

        */
        static function loadViewElement($name)
        {
            if(file_exists(self::viewElementPath.$name.".php"))
                require_once self::viewElementPath.$name.".php";
        }
    }