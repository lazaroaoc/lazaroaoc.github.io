<?php

class Citas_modelo
{

    private $db;
    private $citas;
    private $misCitas;


    //Contructor 
    public function __construct()
    {
        require_once("conectar.php");
        $this->db = Conectar::conexion();

        $this->citas = array();
        $this->misCitas = array();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para recoger todos los datos de la tabla Citas
    public function getCitas()
    {
        $sql = "SELECT citas.citas_id,citas.citas_username,citas.citas_lastnames,citas.citas_dni,citas.citas_email,citas.citas_phone,servicio.nombre_servicio,citas.citas_service,citas.citas_date,citas.citas_hour,citas.citas_completada 
        FROM citas 
        INNER JOIN servicio ON  citas.citas_service = servicio.id_servicio
        ORDER BY citas.citas_id asc";

        $consulta = $this->db->query($sql);

        while ($registro = $consulta->fetch_assoc()) {
            $this->citas[] = $registro;
        }
        return $this->citas;
    }

      /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para recoger todos los datos de la tabla Citas dónde las citas están Pendientes
    public function citasPendientes()
    {
        $sql = "SELECT citas.citas_id,citas.citas_username,citas.citas_lastnames,citas.citas_dni,citas.citas_email,citas.citas_phone,servicio.nombre_servicio,citas.citas_service,citas.citas_date,citas.citas_hour,citas.citas_completada 
        FROM citas 
        INNER JOIN servicio   ON  citas.citas_service = servicio.id_servicio
        WHERE  citas.citas_completada = 'false'
        ORDER BY citas.citas_id asc";

        $consulta = $this->db->query($sql);

        while ($registro = $consulta->fetch_assoc()) {
            $this->citas[] = $registro;
        }
        return $this->citas;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para recoger todos los datos de la tabla Citas dónde las citas están completadas
    public function citasCompletadas()
    {
        $sql = "SELECT citas.citas_id,citas.citas_username,citas.citas_lastnames,citas.citas_dni,citas.citas_email,citas.citas_phone,servicio.nombre_servicio,citas.citas_service,citas.citas_date,citas.citas_hour,citas.citas_completada 
        FROM citas 
        INNER JOIN servicio   ON  citas.citas_service = servicio.id_servicio
        WHERE  citas.citas_completada = 'true'
        ORDER BY citas.citas_id asc";

        $consulta = $this->db->query($sql);

        while ($registro = $consulta->fetch_assoc()) {
            $this->citas[] = $registro;
        }
        return $this->citas;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////
    //Función para recoger las citas de un usuario
    public function misCitas($email)
    {

        $sql = "SELECT citas.citas_id,citas.citas_username,citas.citas_lastnames,citas.citas_dni,citas.citas_email,citas.citas_phone,servicio.nombre_servicio,citas.citas_service,citas.citas_date,citas.citas_hour,citas.citas_completada 
        FROM citas 
        INNER JOIN servicio   ON  citas.citas_service = servicio.id_servicio
        WHERE citas.citas_email ='$email' and citas.citas_completada = 'false'
        ORDER BY citas.citas_id asc";

        $consulta = $this->db->query($sql);

        while ($registro = $consulta->fetch_assoc()) {
            $this->citas[] = $registro;
        }
        return $this->citas;   
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para insertar una cita en la tabla Cita

    public function insertarCita($username, $lastnames, $dni, $email, $phone, $service, $date, $hour, $completada)
    {

        $sql = "INSERT INTO `citas`(`citas_username`, `citas_lastnames`, `citas_dni`, `citas_email`, `citas_phone`, `citas_service`, `citas_date`, `citas_hour`, `citas_completada`) 
        VALUES ('$username','$lastnames','$dni','$email','$phone','$service','$date','$hour','$completada')";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para modificar una cita de la tabla Citas
    public function modificarCita($id, $username, $lastnames, $dni, $email, $phone, $service, $date, $hour)
    {

        $sql = "UPDATE `citas` SET `citas_username`='$username',`citas_lastnames`='$lastnames',`citas_dni`='$dni',`citas_email`='$email',`citas_phone`='$phone',`citas_service`='$service',`citas_date`='$date',`citas_hour`='$hour' WHERE citas_id = $id";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Función para cambiar una Cita de Pendiente a Completada
    public function modificarPendiente($id)
    {

        $sql = "UPDATE `citas` SET `citas_completada`='1' WHERE citas_id = $id";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

      ////////////////////////////////////////////////////////////////////////////////////////////
    //Función para cambiar una Cita de Completada a Pendiente
    public function modificarCompletada($id)
    {

        $sql = "UPDATE `citas` SET `citas_completada`='0' WHERE citas_id = $id";

        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    //Función para borrar una cita de la tabla Citas
    public function borrarCita($id)
    {
        $citaBorrado = "DELETE FROM citas WHERE citas_id  = '" . $id . "'  ";

        if ($this->db->query($citaBorrado)) {
            return $this->db->query($citaBorrado);
        } else {
            return false;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////




}
