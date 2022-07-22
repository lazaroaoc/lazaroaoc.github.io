
<?php

class Usuarios_modelo
{

    private $db;
    private $datos;



    //Contructor 
    public function __construct()
    {
        require_once("conectar.php");
        $this->db = Conectar::conexion();

        $this->usuarios = array();
    }


    //Función leer los datos de la tabla Usuarios
    public function mostrarDatos() //InnerJoin para mostrar el texto del rol según el id
    {
        $sql = "SELECT usuarios.id,usuarios.username,usuarios.lastnames,usuarios.email,rol.nombre_rol,usuarios.rol,usuarios.servicio,servicio.nombre_servicio
        FROM usuarios  
        INNER JOIN rol  ON  usuarios.rol = rol.id_rol 
        INNER JOIN servicio ON usuarios.servicio = servicio.id_servicio 
        ORDER BY usuarios.id asc";
        
        $consulta = $this->db->query($sql);
    
        while ($registro = $consulta->fetch_assoc()) {
            $this->datos[] = $registro;
        }
       
        return $this->datos;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////


    //Función para hacer Login en la aplicación
    public function login($email,$password)
    {

      $clave = hash_hmac('haval256,5',$password, 'key_password');

     $sql = "SELECT username,lastnames,email,password FROM usuarios WHERE email = '" . $email . "' and password = '" . $clave . "'    ";
      //and password = '" . $password . "'   
        $consulta = $this->db->query($sql);
        $registro = $consulta->fetch_assoc();

    

 

    //if ($clave == $password){

        if (mysqli_num_rows($consulta) > 0) {
            return $registro;
        } else {
            return false;
        }


    //}else{
    //    return false;  
   // }

        
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    //Función para saber el Rol del usuario que Inicia Sesión
    public function rol($email)
    {
        $sql = "SELECT rol.nombre_rol 
        FROM usuarios  INNER JOIN rol  ON usuarios.rol = rol.id_rol WHERE usuarios.email = '" . $email . "'  ";
        $consulta = $this->db->query($sql);
        $registro = $consulta->fetch_assoc();

        if (mysqli_num_rows($consulta) > 0) {
            return $registro;
        } else return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    //Función para  registrarse en la aplicación
    public function registrarse($username, $lastnames, $email, $password)
    {
         $clave = hash_hmac('haval256,5',$password, 'key_password');

        $sql = "INSERT  INTO `usuarios`( `username`, `lastnames`, `email`,`password`,`rol`,`servicio`) 
        VALUES ('$username','$lastnames','$email','$clave','3','1')";

        

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////


    //Función para insertar un usuario en la base de Datos

    public function insertarUsuario($username, $lastnames, $email, $rol, $servicio, $password)
    {

         $clave = hash_hmac('haval256,5',$password, 'key_password');

        $sql = "INSERT  INTO `usuarios`( `username`, `lastnames`, `email`,`password`,`rol`,`servicio`) 
        VALUES ('$username','$lastnames','$email','$clave','$rol','$servicio')";


        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    //Función para modificar un usuario de la base de Datos

    public function modificarUsuario($id, $username, $lastnames, $email, $rol, $servicio, $password)
    {
      $clave = hash_hmac('haval256,5',$password, 'key_password');

        $sql = "UPDATE `usuarios` SET `username`='$username',`lastnames`='$lastnames',`email`='$email',`password`='$clave',`rol`='$rol',`servicio`='$servicio' WHERE id = $id";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    //Función para borrar un usuario de la Base de Datos
    public function borrarUsuario($id)
    {

        $sql = "DELETE FROM usuarios WHERE id = '" . $id . "'  ";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////








}

?>