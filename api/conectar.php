<?php

class Conectar{

   public static function conexion(){
        
        try{
            $conexion = new mysqli("bbdd.clinicasortega.com","ddb187335","Carlitos012010","ddb187335");
        }catch(Exception $e){
            die('Error: '.$e->get_message());
        }
        return $conexion;
    }

  
    
       
    

}
