<?php

    class FormBuilder
    {
        
        /*  */
        static function createInputElement($type = 'text', $name, $placeHolder = '', $value = '', $classes = [], $id = '')
        {
            #
            echo    '<input type="'.$type.'" name="'.$name.'" value="'.$value.
                    '" placeholder="'.$placeHolder.'" class ="'.self::generateClassString($classes).'"
                    id="'.$id.'">';
        }
        
        static function createButton($name, $value, $classes = [], $id = '')
        {
            
            #
            echo    '<button name="'.$name.'" value="'.$value.'"
                    class="'.self::generateClassString($classes).'" id="'.$id.'" </button>';
        }
        
        static function createTextArea($name, $value = '', $placeholder = '', $classes = [], $id = '')
        {
            echo    '<textarea name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.
                    '" class="'.self::generateClassString($classes).'" id="'.$id.'"';
        }
        
        static function createSelectElement($name, $options = [], $classes = [], $id='')
        {
            echo '<select name="'.$name.'" class="'.self::generateClassString($classes).'" id="'.$id.'">';
            self::generateSelectOptions($options);
            echo '</select>';
        }
        
        private function generateClassString($classes = [])
        {
            $classString = "";
            foreach($classes as $class)
            {
                $classString .= $class. " ";
            }
            
            #
            return $classString;
        }
        private function generateSelectOptions($options = [])
        {
            foreach($options as $value => $placeHolder)
            {
                echo '<option value="'.$value.'">'.$placeHolder.'</option>';
                echo '<br>';
            }
        }
    }