<?php
class PrivilegioUsuario
{
    private $db;
    private $id;
    private $idUsuario;
    private $idObjeto;

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

    public function getIdObjeto() {
        return $this->idObjeto;
    }
     
    public function setIdObjeto($idObjeto) {
        $this->idObjeto = $idObjeto;
    }

    //Creates    
    public function create()
    {
        $sql = "INSERT INTO privilegio_usuario (id_usuario,id_objeto) VALUES (:idUsuario,:idObjeto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idUsuario", $this->getIdUsuario(), PDO::PARAM_INT); //Entero forzado
        $stmt->bindValue(":idObjeto", $this->getIdObjeto(), PDO::PARAM_INT); //Entero forzado        
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
        $sql = "SELECT * FROM privilegio_usuario WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT); //Entero forzado
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxUser()
    {
        $sql = "SELECT * FROM privilegio_usuario WHERE id_usuario = :idUsuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idUsuario", $this->getIdUsuario(), PDO::PARAM_INT); //Entero forzado
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllxObjeto()
    {
        $sql = "SELECT * FROM privilegio_usuario WHERE id_objeto = :idObjeto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idObjeto", $this->getIdObjeto(), PDO::PARAM_INT); //Entero forzado        
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function update($campo,$valor){        
        $sql = "UPDATE privilegio_usuario SET $campo = $valor WHERE id = :id";                
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
        $sql = "DELETE FROM privilegio_usuario WHERE id = :id";
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
