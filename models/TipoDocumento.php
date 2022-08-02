<?php
class TipoDocumento
{
    private $db;
    private $id;
    private $nombre;
    private $estado;

    function __construct()
    {        
        $this->db = Database::Connect();
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    //Creates    
    public function create()
    {
        $sql = "INSERT INTO tipo_documento (nombre) VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
        $stmt->execute();
        if ($id = $this->db->lastInsertId()) {
            $response[] = ['status' => "created",'id' => $id];        
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to create"];
        }
        return $response;
    }

    //Readers
    public function getOne()
    {
        $sql = "SELECT * FROM tipo_documento WHERE id = :idTipoDocumento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idTipoDocumento", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tipo_documento WHERE estado = 'A' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFull()
    {
        $sql = "SELECT * FROM tipo_documento ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function updateOne(){        
        $sql = "UPDATE tipo_documento SET nombre=:nombre, estado=:estado WHERE id = :id";                
        $stmt = $this->db->prepare($sql);        
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":estado", $this->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "updated",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }        
        return $response;
    }

    public function update($campo,$valor){        
        $sql = "UPDATE tipo_documento SET $campo = $valor WHERE id = :id";                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "updated",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to updated"];
        }        
        return $response;
    }

    //Deletes
    public function delete()
    {
        $sql = "DELETE FROM tipo_documento WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response[] = ['status' => "deleted",'id' => $this->getId()];
        } else {
            $response[] = ['status' => "error", 'description' => "Failed to delete"];
        }        
        return $response;
    }
}
?>
