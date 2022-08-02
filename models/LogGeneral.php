<?php
class LogGeneral
{
    private $db;
    private $id;
    private $idUsuario;
    private $fechaCreacion;
    private $descripcion;
    
    function __construct()
    {        
        $this->db = Database::Connect();
    }

    public function getId() {
        return $this->id;
    }     
    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }     
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }     
    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }     
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


    //Creates    
    public function create()
    {
        $sql = "INSERT INTO log_general (id_usuario,fecha_creacion,descripcion) VALUES (:idUsuario,NOW(),:descripcion)";
        $stmt = $this->db->prepare($sql);        
        $stmt->bindValue(":idUsuario", $this->getIdUsuario(), PDO::PARAM_INT);
        $stmt->bindValue(":descripcion", $this->getDescripcion(), PDO::PARAM_STR);
        $stmt->execute();
        if ($id = $this->db->lastInsertId()) {
            $response[] = ['status' => "created",'id' => $id];        
        } else {            
            die("Fatal Error: data cannot be saved in the Log");
        }
        return $response;
    }

    //Readers
    public function getOne()
    {
        $sql = "SELECT * FROM log_general WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT); //Entero forzado
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFull()
    {
        $sql = "SELECT * FROM log_general";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function update($campo,$valor){        
        $sql = "UPDATE log_general SET $campo = $valor WHERE id = :id";                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT); //Entero forzado
        if ($stmt->execute()) {
            $response[] = ['status' => "updated"];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }        
        return $response;
    }

    //Deletes
    public function delete()
    {
        $sql = "DELETE FROM log_general WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT); //Entero forzado         
        if ($stmt->execute()) {            
            $response[] = ['status' => "deleted"];            
        } else {            
            $response[] = ['status' => "error", 'description' => "Failed to delete"];
        }        
        return $response;
    }


}
