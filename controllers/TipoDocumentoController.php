<?php
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once 'models/TipoDocumento.php';
require_once 'models/LogGeneral.php';
require_once 'helpers/Utils.php';

class TipoDocumentoController
{
    private $table = "TipoDocumento";

    function __construct()
    {
        header("HTTP/1.1 200 OK");
        header("Content_Type: application/json");
    }

    public function create()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            $nombre = isset($_POST['nombre']) ? trim(strtoupper($_POST['nombre'])) : false;
            $idUser = isset($_POST['idUser']) ? filter_var(trim($_POST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
            //Creación de Objeto con datos // Almacenamiento de Datos
            if ($nombre) {
                $data = new $this->table();
                $data->setNombre($nombre);                
                $response = $data->create();
                //Registro en Log General
                foreach ($response as $value) {                    
                    if($value['status'] == "created"){                        
                        $description = 'Creado en Tabla: '.$this->table.', Registro id: '.$value['id'].', Valor: '.$nombre;
                        $saveLog=Utils::createLog($idUser,$description);                        
                        foreach ($saveLog as $data1) {                    
                            if($value['status'] != "created"){
                                $response[] = ['error' => "Log General " . $value['status']];
                                break;
                            }
                        }
                    }                    
                }                
            } else {
                $response = array();
                $response[] = ['error' => "nombre and idUser are Requiredes"];
            }
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
        }
        echo json_encode($response);
    }

    public function getOne()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $id = isset($_POST['id']) ? filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
        }
        //Obtención de datos
        if ($id) {
            $data = new $this->table();
            $data->setId($id);
            $response = $data->getOne();
        } else {
            $response = array();
            $response[] = ['error' => "id is Required"];
        }
        echo json_encode($response);
    }

    public function getAll()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {
            $data = new $this->table();
            $response = $data->getAll();
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
        }
        echo json_encode($response);
    }

    public function getAllFull()
    {
        //Evaluacion de método de recepcion // Formateo de Datos
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {
            $data = new $this->table();
            $response = $data->getAllFull();
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
        }
        echo json_encode($response);
    }

    public function updateOne()
    {
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $method == 'POST') {
            $id = isset($_REQUEST['id']) ? filter_var(trim($_REQUEST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $nombre = isset($_REQUEST['nombre']) ? trim($_REQUEST['nombre']) : false;            
            $estado = isset($_REQUEST['estado']) ? trim($_REQUEST['estado']) : false;
            $idUser = isset($_REQUEST['idUser']) ? filter_var(trim($_REQUEST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['error' => "Method Invalid"];
        }
        //Actualización de datos
        if ($id && $nombre && $estado && $idUser) {
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos de comparación
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $nombreSave = $value['nombre'];                
                $estadoSave = $value['estado'];
            }
            //Update one row
            $data->setNombre($nombre);            
            $data->setEstado($estado);
            $response = $data->updateOne();

            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "updated") {
                    //Adicion de cambios al Log
                    if ($nombreSave != $nombre) {
                        $campo = "nombre";
                        $dataSave = $nombreSave;
                        $newData = $nombre;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }

                    //Adicion de cambios al Log
                    if ($estadoSave != $estado) {
                        $campo = "estado";
                        $dataSave = $estadoSave;
                        $newData = $estado;
                        $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $newData";
                        $saveLog = Utils::createLog($idUser, $description);
                        foreach ($saveLog as $data1) {
                            if ($data1['status'] != "created") {
                                $response[] = ['error' => "Log General " . $data1['status']];
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            $response[] = ['error' => "id, nombre, estado and  idUser are Requiredes"];
        }
        echo json_encode($response);
    }    

    public function update()
    {
        //Evaluacion de método de recepcion // Formateo de Datos        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $campo = isset($_GET['campo']) ? trim($_GET['campo']) : false;
            $valor = isset($_GET['valor']) ? trim($_GET['valor']) : false;
            $idUser = isset($_GET['idUser']) ? filter_var(trim($_GET['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'POST') {
            $id = isset($_POST['id']) ? filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $campo = isset($_POST['campo']) ? trim($_POST['campo']) : false;
            $valor = isset($_POST['valor']) ? trim($_POST['valor']) : false;
            $idUser = isset($_POST['idUser']) ? filter_var(trim($_POST['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response[] = ['error' => "Method Invalid"];
        }
        //Actualización de datos
        if ($id && $campo && $valor && $idUser) {
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos para Log
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $dataSave = $value[$campo];
            }
            //fin consulta
            //Update
            $response = $data->update($campo, $valor);
            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "updated") {                    
                    $description = "Actualizado en Tabla: $this->table, Registro id: $id, Campo: $campo, Dato Anterior:$dataSave, Dato Nuevo: $valor";
                    $saveLog = Utils::createLog($idUser, $description);
                    foreach ($saveLog as $data1) {
                        if ($data1['status'] != "created") {
                            $response[] = ['error' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['error' => "id, campo, valor and  idUser are Requiredes"];
        }
        echo json_encode($response);
    }

    public function delete()
    {
        //Evaluacion de método de recepcion 
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET') {
            $id = isset($_GET['id']) ? filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idUser = isset($_GET['idUser']) ? filter_var(trim($_GET['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else if ($method == 'DELETE') {
            $id = isset($_DELETE['id']) ? filter_var(trim($_DELETE['id']), FILTER_SANITIZE_NUMBER_INT) : false;
            $idUser = isset($_DELETE['idUser']) ? filter_var(trim($_DELETE['idUser']), FILTER_SANITIZE_NUMBER_INT) : false;
        } else {
            $response = array();
            $response[] = ['error' => "Method Invalid"];
        }
        //Obtención de datos
        if ($id && $idUser) {            
            $data = new $this->table();
            $data->setId($id);
            //Consulta datos para Log
            $tupla = $data->getOne();
            foreach ($tupla as $value) {
                $searchValue = $value['nombre'];
            }
            //fin consulta
            $response = $data->delete();
            //Registro en Log General
            foreach ($response as $value) {
                if ($value['status'] == "deleted") {
                    $description = "Eliminado en Tabla: $this->table, Registro id: $id, Valor: $searchValue";
                    $saveLog = Utils::createLog($idUser, $description);
                    foreach ($saveLog as $data1) {
                        if ($data1['status'] != "created") {
                            $response[] = ['error' => "Log General " . $data1['status']];
                            break;
                        }
                    }
                }
            }
        } else {
            $response[] = ['error' => "id and idUser are Requiredes"];
        }
        echo json_encode($response);
    }
}
