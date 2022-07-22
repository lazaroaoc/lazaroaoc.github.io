<?php
require_once("citas_modelo.php");

function permisos()
{
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Credentials: true');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}

permisos();


$citas_modelo = new Citas_modelo();


$_POST = json_decode(file_get_contents("php://input"), true);


if (isset($_GET["option"])) {

  $opcion = $_GET["option"];


  $data = new stdClass();




  switch ($opcion) {
      //Mostrar los datos de la tabla Citas
    case "mostrar_citas":

      $citas = $citas_modelo->getCitas();

      $data = $citas;

      break;


      //Mostrar los datos de la tabla Citas
    case "citas_pendientes":

      $citas = $citas_modelo->citasPendientes();

      $data = $citas;

      break;

      //Mostrar los datos de la tabla Citas
    case "citas_completadas":

      $citas = $citas_modelo->citasCompletadas();

      $data = $citas;

      break;

      //Mostrar las citas de una personas
    case "mis_citas":

      $misCitas = $citas_modelo->misCitas($_POST['email']);

      $data = $misCitas;

      break;


      //Insertar una cita en la tabla Citas
    case "insertar_cita":

      $insertar = $citas_modelo->insertarCita($_POST['citas_username'], $_POST['citas_lastnames'], $_POST['citas_dni'],  $_POST['citas_email'], $_POST['citas_phone'], $_POST['citas_service'],  $_POST['citas_date'], $_POST['citas_hour'], $_POST['citas_completada']);

      break;

      //Modificar una cita de la tabla Citas
    case "modificar_cita":

      $modificar = $citas_modelo->modificarCita($_POST['citas_id'], $_POST['citas_username'], $_POST['citas_lastnames'], $_POST['citas_dni'],  $_POST['citas_email'], $_POST['citas_phone'], $_POST['citas_service'],  $_POST['citas_date'], $_POST['citas_hour']);

      $data = $modificar;
      break;

      //Cambiar una cita de Pendiente a Completada
    case "modificar_pendiente":

      $modificarPen = $citas_modelo->modificarPendiente($_POST['citas_id']);

      $data = $modificarPen;
      break;


      //Cambiar una cita de Completada a Pendiente
    case "modificar_completada":

      $modificarCom = $citas_modelo->modificarCompletada($_POST['citas_id']);

      $data = $modificarCom;
      break;

      //Eliminar una cita de la tabla Citas
    case "borrar_cita":

      $borrar = $citas_modelo->borrarCita($_POST['id_cita']);

      $data = $borrar;

      break;
  }
  print json_encode($data, JSON_UNESCAPED_UNICODE);
}
