
<?php
require_once("productos_modelo.php");

function permisos()
{
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    // header("Access-Control-Allow-Headers: *");
    header('Access-Control-Allow-Credentials: true');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    // header("Access-Control-Allow-Headers: *");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}


permisos();


$productos_modelo = new Productos_modelo();




$_POST = json_decode(file_get_contents("php://input"), true);


if (isset($_GET["option"])) {

  $opcion = $_GET["option"];


  $data = new stdClass();




  switch ($opcion) {

      //Mostrar los datos de la tabla Productos
    case "mostrar_productos":

      $productos = $productos_modelo->get_productos();

      $data = $productos;

      break;

      //Insertar un producto en la tabla Productos
    case "insertar_producto":
  
      $insertar = $productos_modelo->insertarProducto($_POST['nombre'], $_POST['precio'], $_POST['cantidad'],  $_POST['imagen']);

      break;

       //Modificar un producto en la tabla Productos
       case "modificar_producto":

        $modificar = $productos_modelo->modificarProducto($_POST['id_product'],$_POST['product_name'], $_POST['product_price'], $_POST['product_quantity'],$_POST['imagen']);

        $data = $modificar;
        break;  



      //Eliminar un producto de la tabla Productos
    case "borrar_producto":

      $borrar = $productos_modelo->borrarProducto($_POST['id_producto']);

      $data = $borrar;

      break;
  }
  print json_encode($data, JSON_UNESCAPED_UNICODE);
}

?>