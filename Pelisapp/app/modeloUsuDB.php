<?php

include_once 'config.php';
include_once 'Usuario.php';

class ModeloUsuDB
{

    private static $dbh = null;
    private static $consulta_usuario = "Select * from usuarios where id = ?";
    private static $delete_usuario   = "Delete from usuarios where id = ?"; 
    private static $insert_usuario   = "Insert into usuarios (id,nombre,contraseña,rol,correo,plan)".
                                     " VALUES (?,?,?,?,?,?)";

    /* private static $update_user    = "UPDATE Usuarios set  clave=?, nombre =?, ".
                                     "email=?, plan=?, estado=? where id =?";
    */
    private static $login_user = "Select * from usuarios where nombre = ? and contraseña = ?";

    private static $update_user = "Update usuarios set id=?,nombre=?, contraseña=?,rol=?,correo=?,plan=?
                                    where id=?";
    public static function init()
    {

        if (self::$dbh == null) {
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME . ";charset=utf8";
                self::$dbh = new PDO($dsn, DBUSER, DBPASSWORD);
                // Si se produce un error se genera una excepción;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión " . $e->getMessage();
                exit();
            }
        }
    }
    public static function Usulogin($nombre,$contraseña){
        $stmt = self::$dbh->prepare(self::$login_user);

        $stmt->bindValue(1,$nombre);
        $stmt->bindValue(2,$contraseña);
        $stmt->execute();

        if ($stmt->rowCount() > 0 ){
           
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
            
            //var_dump($usuario);
            return true;

        }else return false;
         
    }

    public static function UsuAdd($id, $nombre, $contraseña, $correo, $plan):bool{
        $stmt = self::$dbh->prepare(self::$insert_usuario);

        $stmt->bindValue(1,$id);
        $stmt->bindValue(2,$nombre);
        $stmt->bindValue(3,$contraseña);
        $stmt->bindValue(4,"user");
        $stmt->bindValue(5,$correo);
        $stmt->bindValue(6,$plan);
        if ($stmt->execute()){
           return true;
        }
        return false; 
    }

    public static function ModificarUsu($id, $nombre, $contraseña, $correo, $plan, $idusu):bool{
        $stmt = self::$dbh->prepare(self::$update_user);

        $stmt->bindValue(1,$id);
        $stmt->bindValue(2,$nombre);
        $stmt->bindValue(3,$contraseña);
        $stmt->bindValue(4,"user");
        $stmt->bindValue(5,$correo);
        $stmt->bindValue(6,$plan);
        $stmt->bindValue(7,$idusu);
        
        if ($stmt->execute()){
           return true;
        }
        return false; 
    }
        // Añadir un nuevo usuario (boolean)
    /*public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$update_usernopw);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$update_user);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }*/

    public static function UsuDel($id){
        $stmt = self::$dbh->prepare(self::$delete_usuario);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        if ($stmt->rowCount() > 0 ){
            return true;
        }
        return false;
    }
    /***
// Borrar un usuario (boolean)
public static function UserDel($userid){
    $stmt = self::$dbh->prepare(self::$delete_user);
    $stmt->bindValue(1,$userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}


// Actualizar un nuevo usuario (boolean)
// GUARDAR LA CLAVE CIFRADA
public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$update_usernopw);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$update_user);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }
    return false; 
}
     ****/

    // Tabla de objetos con todos los usuarios
    public static function GetAll(): array
    {
        // Genero los datos para la vista que no muestra la contraseña

        $stmt = self::$dbh->query("select * from usuarios");

        $tUsu = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        while ($usu = $stmt->fetch()) {
            $tUsu[] = $usu;
        }
        return $tUsu;
    }

    public static function closeDB()
    {
        self::$dbh = null;
    }
} // class
