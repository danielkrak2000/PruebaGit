<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB
{

    private static $dbh = null;
    private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";

    private static $media_peli = "Update peliculas set votaciones=?, puntuacion=? where codigo_pelicula = ?";
    private static $consulta_peli_nombre = "Select * from peliculas where nombre like ?";
    private static $consulta_peli_director = "Select * from peliculas where director like ?";
    private static $consulta_peli_genero = "Select * from peliculas where genero like ?";

    private static $delete_peli   = "Delete from peliculas where codigo_pelicula = ?"; 
    private static $insert_peli   = "Insert into peliculas (nombre,director,genero,imagen)".
                                     " VALUES (?,?,?,?)";

    /* private static $update_user    = "UPDATE Usuarios set  clave=?, nombre =?, ".
                                     "email=?, plan=?, estado=? where id =?";
    */

    private static $update_peli = "Update peliculas set nombre=?, director=?, genero=?, imagen=?  
                                    where codigo_pelicula=?";
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
    public static function PeliMedia($votaciones, $puntuacion, $codigo_pelicula){
        $stmt = self::$dbh->prepare(self::$media_peli);
        $stmt->bindValue(1,$votaciones);
        $stmt->bindValue(2,$puntuacion);
        $stmt->bindValue(3,$codigo_pelicula);
        if ($stmt->execute()){
            return true;
        }
        return false; 
    }


    public static function PeliAdd($nombre, $director, $genero, $imagen):bool{
        $stmt = self::$dbh->prepare(self::$insert_peli);
        $stmt->bindValue(1,$nombre);
        $stmt->bindValue(2,$director);
        $stmt->bindValue(3,$genero);
        $stmt->bindValue(4,$imagen);
        if ($stmt->execute()){
           return true;
        }
        return false; 
    }

    public static function ModificarPel($nombre, $director, $genero, $imagen, $codigo_pelicula):bool{
        $stmt = self::$dbh->prepare(self::$update_peli);
        $stmt->bindValue(1,$nombre);
        $stmt->bindValue(2,$director);
        $stmt->bindValue(3,$genero);
        $stmt->bindValue(4,$imagen);
        $stmt->bindValue(5,$codigo_pelicula);
        
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

    public static function PeliDel($codigo_pelicula){
        $stmt = self::$dbh->prepare(self::$delete_peli);
        $stmt->bindValue(1,$codigo_pelicula);
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

    // Tabla de objetos con todas las peliculas
    public static function GetAll(): array
    {
        // Genero los datos para la vista que no muestra la contraseña

        $stmt = self::$dbh->query("select * from peliculas");

        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }

    
    public static function PeliDetalles($codigo_pelicula)
    {
        $datosuser = [];
        $stmt = self::$dbh->prepare(self::$consulta_peli);
        $stmt->bindValue(1,$codigo_pelicula);
        $stmt->execute();
        if ($stmt->rowCount() > 0 ){
            // Obtengo un objeto de tipo peli, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            $peliobj = $stmt->fetch();
            $datospeli = [
                         $peliobj->codigo_pelicula, 
                         $peliobj->nombre,
                         $peliobj->director,
                         $peliobj->genero,
                         $peliobj->imagen,
                         $peliobj->votaciones,
                         $peliobj->puntuacion
                         ];
            return $datospeli;
        }
        return null;    
    }

    public static function PeliBuscarNombre($nombre){
        $datosuser = [];
        $stmt = self::$dbh->prepare(self::$consulta_peli_nombre);
        $stmt->bindValue(1,$nombre."%");
        $stmt->execute();
        $tpelis = [];
        if ($stmt->rowCount() > 0 ){
            // Obtengo un objeto de tipo peli, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            while ($peliobj = $stmt->fetch()){
                $tpelis[] = $peliobj;       
            }
            return $tpelis;
        }
        return null;    
    }

    public static function PeliBuscarDirector($director){
        $datosuser = [];
        $stmt = self::$dbh->prepare(self::$consulta_peli_director);
        $stmt->bindValue(1,$director."%");
        $stmt->execute();
        $tpelis = [];
        if ($stmt->rowCount() > 0 ){
            // Obtengo un objeto de tipo peli, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            while ($peliobj = $stmt->fetch()){
                $tpelis[] = $peliobj;       
            }
            return $tpelis;
        }
        return null;    
    }
    public static function PeliBuscarGenero($genero){
        $datosuser = [];
        $stmt = self::$dbh->prepare(self::$consulta_peli_genero);
        $stmt->bindValue(1,$genero."%");
        $stmt->execute();
        $tpelis = [];
        if ($stmt->rowCount() > 0 ){
            // Obtengo un objeto de tipo peli, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            while ($peliobj = $stmt->fetch()){
                $tpelis[] = $peliobj;       
            }
            return $tpelis;
        }
        return null;    
    }

    /***

// Datos de una película para visualizar
public static function UserGet ($codigo){
    $datosuser = [];
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Usuario, pero devuelvo una tabla
        // Para no tener que modificar el controlador
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $uobj = $stmt->fetch();
        $datosuser = [ 
                     $uobj->clave,
                     $uobj->nombre,
                     $uobj->email,
                     $uobj->plan,
                     $uobj->estado
                     ];
        return $datosuser;
    }
    return null;    
    
}
     ***/
    public static function closeDB()
    {
        self::$dbh = null;
    }
} // class
