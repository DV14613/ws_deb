<?php
class Usuario
{
    private $db;
    private $id;
    private $documento;
    private $nombre;
    private $login;
    private $clave;
    private $email;
    private $id_dependencia;
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

    public function getDocumento()
    {
        return $this->documento;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getLogin()
    {
        return $this->login;
    }
    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getClave()
    {
        return $this->clave;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getId_dependencia()
    {
        return $this->id_dependencia;
    }
    public function setId_dependencia($id_dependencia)
    {
        $this->id_dependencia = $id_dependencia;
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
        $sql = "INSERT INTO usuario (documento,nombre,login,clave,email,id_dependencia,estado) VALUES (:documento,:nombre,:login,:clave,:email,:id_dependencia,:estado)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":documento", $this->getDocumento(), PDO::PARAM_STR); //Entero forzado
        $stmt->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR); //Entero forzado
        $stmt->bindValue(":login", $this->getLogin(), PDO::PARAM_STR); //Entero forzado
        $stmt->bindValue(":clave", $this->getClave(), PDO::PARAM_STR); //Entero forzado
        $stmt->bindValue(":email", $this->getEmail(), PDO::PARAM_STR); //Entero forzado
        $stmt->bindValue(":id_dependencia", $this->getId_dependencia(), PDO::PARAM_INT); //Entero forzado
        $stmt->bindValue(":estado", 'A', PDO::PARAM_STR);
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
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT); //Entero forzado
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM usuario WHERE estado = 'A'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFull()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Updates
    public function update($campo,$valor){        
        $sql = "UPDATE usuario SET $campo = $valor WHERE id = :id";                
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
        $sql = "DELETE FROM usuario WHERE id = :id";
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
