<?php
class Utils
{
    public static function createLog($idUser, $description){
        $log = new LogGeneral();
        $log->setIdUsuario($idUser);
        $log->setDescripcion($description);
        return $log->create();
    }
}
