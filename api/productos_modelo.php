
<?php



class Productos_modelo
{


    private $db;
    private $productos;



    //Contructor 
    public function __construct()
    {
        require_once("conectar.php");
        $this->db = Conectar::conexion();

        $this->productos = array();
    }


    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para recoger todos los datos de la tabla Productos
    public function get_productos()
    {
        $sql = "SELECT *  FROM productos";

        $consulta = $this->db->query($sql);

        while ($registro = $consulta->fetch_assoc()) {
            $this->productos[] = $registro;
        }
        return $this->productos;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para insertar un producto en la tabla Productos

    public function insertarProducto($name, $price, $quantity, $product)
    {

        $sql = "INSERT INTO `productos`( `product_name`, `product_price`, `product_quantity`,`imagen`) 
        VALUES ('$name','$price','$quantity','$product')";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para modificar un producto de la tabla Productos
    public function modificarProducto($id_product, $product_name, $product_price, $product_quantity, $imagen)
    {
        if($imagen != null){
            $sql = "UPDATE `productos` SET `product_name`='$product_name',`product_price`='$product_price',`product_quantity`='$product_quantity',`imagen`='$imagen' WHERE id_product = $id_product";
        }
        else if ($imagen == null){
            $sql = "UPDATE `productos` SET `product_name`='$product_name',`product_price`='$product_price',`product_quantity`='$product_quantity' WHERE id_product = $id_product";
        }
        

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para borrar un producto de la tabla Productos
    public function borrarProducto($id)
    {

        $prodBorrado = "DELETE FROM productos WHERE id_product = '" . $id . "'  ";

        if ($this->db->query($prodBorrado)) {
            return $this->db->query($prodBorrado);
        } else {
            return false;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

}

?>