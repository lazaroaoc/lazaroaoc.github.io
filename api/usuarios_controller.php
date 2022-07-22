<?php
require_once("usuarios_modelo.php");

if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
			// may also be using PUT, PATCH, HEAD etc
			header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
	}

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
			header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
	}
	exit(0);
}

function permisos() {  
  if (isset($_SERVER['HTTP_ORIGIN'])){
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: *");
      header('Access-Control-Allow-Credentials: true');    
      header('Access-Control-Max-Age: 1000');  
  }  
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: *");
    exit(0);
  }
}
permisos();

$usuario_modelo = new Usuarios_modelo();





$_POST = json_decode(file_get_contents("php://input"), true);
if (isset($_GET["option"])) {

  $opcion = $_GET["option"];


  $data = new stdClass();

  


  switch ($opcion) {

     //Mostrar los datos de la tabla Usuarios
     case "mostrar_datos":

      $datos = $usuario_modelo->mostrarDatos();

      $data = $datos;

      break;


    //Para Iniciar Sesión en la aplicación
    case "iniciar_sesion":

      
      //Usuario
      $user= $usuario_modelo->login($_POST['email'],$_POST['pass']);

      if ($user != false) {

        $data->nombre =  $user['username'];
        $data->apellidos = $user['lastnames'];
        $data->email = $user['email'];
          

        //Rol
        $rol = $usuario_modelo->rol($user['email']);

        $data->rol =  $rol['nombre_rol'];
      } else {
        return header("HTTP/1.0 404 Login Data Not Found");
      }

     
      break;

    //Para Registrarse en la aplicación
    case "registrarse":

       

      $registrarse = $usuario_modelo->registrarse($_POST['name'], $_POST['lastnames'], $_POST['email'],$_POST['pass']);

      $data =  $registrarse;

      $para      = $_POST['email'] ;
      $titulo    = 'Registro Completado en Clínicas Ortega';
      $mensaje   = "CREDENCIALES \n"."Usuario: ".$_POST['name']."\n Apellidos: ".$_POST['lastnames']."\n Correo Electrónico: " .$_POST['email']."\n Contraseña: ".$_POST['pass'];
      $cabeceras = 'From: lazaro_ortega@gmail.com' . "\r\n" .
          'Reply-To: administrador@clinicasortega.com' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();
            mail($para, $titulo, $mensaje, $cabeceras);

      break;

     

        //Insertar un usuario en la tabla Usuarios
        case "insertar_usuario":


          $insertar = $usuario_modelo->insertarUsuario($_POST['username'], $_POST['lastnames'], $_POST['email'],$_POST['rol'],$_POST['servicio'],$_POST['pass'] );
  
          $data = $insertar;
          break; 
          
          //Modificar un usuarios de la tabla Usuarios
        case "modificar_usuario":

        

          $modificar = $usuario_modelo->modificarUsuario($_POST['id'],$_POST['username'], $_POST['lastnames'], $_POST['email'],$_POST['rol'],$_POST['servicio'],$_POST['pass']);
  
          $data = $modificar;
          break;  



        //Para eliminar un usuario de la tabla Usuarios
        case "borrar_usuario":

          $borrar= $usuario_modelo->borrarUsuario($_POST['id']);
  
          $data = $borrar;
  
          break;
  
  }
   // echo var_dump($data);

//$str = mb_convert_encoding($data,"UTF-8","Windows-1252");
//echo json_encode($str ,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

echo json_encode($data,JSON_UNESCAPED_UNICODE);
 
 



}
