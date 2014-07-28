<?php

class DinamicFields {
    
    
    public static function checkCheckbox($value) {
        return $value ? 1 : 0;
    }
    
    public static function valueCheckbox($value) {
        return $value ? 'checked' : '';
    }
    
    
}