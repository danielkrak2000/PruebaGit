<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php';

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */
function cltDescargarJSON()
{
    $peliculas = ModeloPeliDB::GetAll();
    $json = json_encode($peliculas);
    header("Content-Type: application/json");
    $bytes = file_put_contents("peliculas.json", $json);
    header('Location: index.php');
}

function  ctlPeliInicio()
{
    die(" No implementado.");
}

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        include_once 'plantilla/fnuevo.php';
    } else {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
        $director = isset($_POST['director']) ? $_POST['director'] : false;
        $genero = isset($_POST['genero']) ? $_POST['genero'] : false;

        if (!empty($_FILES['imagen']['name'])) {
            if ($msg = ErrordescargarPeli()) {
                include_once 'plantilla/fnuevo.php';
                return;
            } else {
                $imagen = $_FILES['imagen']['name'];
            }
        } else {
            $imagen = NULL;
        }
        $pelicula = ModeloPeliDB::PeliAdd($nombre, $director, $genero, $imagen);
        header('Location: index.php');
    }
}

function ErrordescargarPeli()
{
    $nombreFichero   =   $_FILES['imagen']['name'];
    $tipoFichero     =   $_FILES['imagen']['type'];
    $tamanioFichero  =   $_FILES['imagen']['size'];
    $temporalFichero =   $_FILES['imagen']['tmp_name'];
    $errorFichero    =   $_FILES['imagen']['error'];
    $msg = false;
    if ($errorFichero != 0) {
        $msg = "Error al subir el fichero $nombreFichero <br>";
    } else 
    if ($tipoFichero != "image/jpeg" && $tipoFichero != "image/png") {
        $msg = " Error el fichero no es una imagen jpeg o png";
    } else
    if (!move_uploaded_file($temporalFichero, 'app/img/' . $nombreFichero)) {
        $msg = "ERROR: el fichero no se puede copiar en imagenes";
        return;
    }
    return $msg;
}

/*
 *  Muestra y procesa el formulario de Modificación 
 */

function cltVotarPeli()
{

    if (isset($_POST['voto'])) {
        $puntuacionañadida = $_POST['voto'];
        $codigo_pelicula = $_POST['codigo_pelicula'];

        $pelicula = ModeloPeliDB::PeliDetalles($_POST['codigo_pelicula']);

        $votospeli = $pelicula[5];
        $puntuacionold = $pelicula[6];
        $votospeli += 1;

        $puntuacionNew = $puntuacionold + $puntuacionañadida;
        $media = $puntuacionNew / $votospeli;

        $media_num = number_format($media, 2);

        if (isset($_SESSION['usuario'])) {

            if (!isset($_COOKIE[$_SESSION['usuario']])) {
                setcookie($_SESSION['usuario'], 0, time() + 24 * 60 * 60);
            }

            if ((int)$_COOKIE[$_SESSION['usuario']] < 4) {
                ModeloPeliDB::PeliMedia($votospeli, $puntuacionNew, $codigo_pelicula);
                $usucoockie = (int)$_COOKIE[$_SESSION['usuario']] + 1;
                setcookie($_SESSION['usuario'], $usucoockie, time() + 24 * 60 * 60);
                $_SESSION['mensaje'] = null;
                header('Location: index.php?orden=Detalles&codigo=' . $codigo_pelicula);
            } else {
                $_SESSION['mensaje'] = 'ya has superado el numero de votos permitidos al dia';
                header('Location: index.php?orden=Detalles&codigo=' . $codigo_pelicula);
            }
        }

        if (isset($_SESSION['invitado'])) {
            if (!isset($_SESSION['invitado'])) {
                setcookie($_SESSION['invitado'], 0, time() + 24 * 60 * 60);
            }

            if ((int)$_COOKIE[$_SESSION['invitado']] < 4) {
                ModeloPeliDB::PeliMedia($votospeli, $puntuacionNew, $codigo_pelicula);
                $usucoockie = (int)$_COOKIE[$_SESSION['invitado']] + 1;
                setcookie($_SESSION['invitado'], $usucoockie, time() + 24 * 60 * 60);
                $_SESSION['mensaje'] = null;
                header('Location: index.php?orden=Detalles&codigo=' . $codigo_pelicula);
            } else {
                $_SESSION['mensaje'] = 'ya has superado el numero de votos permitidos al dia';
                header('Location: index.php?orden=Detalles&codigo=' . $codigo_pelicula);
            }
        }
    }
}

function ctlPeliModificar()
{

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['codigo'])) {
            $codigo = $_GET['codigo'];
            $peli = ModeloPeliDB::PeliDetalles($codigo);
            $codigo_pelicula = $peli[0];
            $nombre = $peli[1];
            $director = $peli[2];
            $genero = $peli[3];
            $imagen = $peli[4];
            include_once 'plantilla/fmodifica.php';
        }
    } else {
        /* Preguntar por que no funciona con el isset
        $codigo_pelicula = isset($_POST['codigo_pelicula']) ? $_POST['codigo_pelicula'] : false;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
        $director = isset($_POST['director']) ? $_POST['director'] : false;
        $genero = isset($_POST['genero']) ? $_POST['genero'] : false;*/

        $codigo_pelicula = $_POST['codigo_pelicula'];
        $nombre = $_POST['nombre'];
        $director = $_POST['director'];
        $genero = $_POST['genero'];

        //NO CONSIGO QUE COGA LA IMAGEN QUE HE SELECCIONADO $_FILES ME DA NULL POR QUE NO ENTRA EN EL IF
        if (!empty($_FILES['imagen']['name'])) {
            if ($msg = ErrordescargarPeli()) {
                include_once 'plantilla/fmodifica.php';
                return;
            } else {
                $imagen = $_FILES['imagen']['name'];
            }
        } else {
            $imagen = $_POST['imagenantigua'];
        }
        $peliculamodificada = ModeloPeliDB::ModificarPel($nombre, $director, $genero, $imagen, $codigo_pelicula);
        header('Location: index.php');
    }
}

/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles()
{

    //Hacemos este $_GET para poder el codigo de la pelicula que se ha pulsado en verpeliculas
    if (isset(($_GET['codigo']))) {
        $pelicula = ModeloPeliDB::PeliDetalles($_GET['codigo']);
        include_once 'plantilla/detalle.php';
    }
}
function ctlPeliNombre()
{
    if (isset($_GET['valor'])) {
        $peliculas = ModeloPeliDB::PeliBuscarNombre($_GET['valor']);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlPeliDirector()
{
    if (isset($_GET['valor'])) {
        $peliculas = ModeloPeliDB::PeliBuscarDirector($_GET['valor']);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlPeliGenero()
{
    if (isset($_GET['valor'])) {
        $peliculas = ModeloPeliDB::PeliBuscarGenero($_GET['valor']);
        include_once 'plantilla/verpeliculas.php';
    }
}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar()
{
    if (isset($_GET['codigo'])) {
        $pelicula = ModeloPeliDB::PeliDel($_GET['codigo']);
    }
    header('Location:index.php');
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar()
{
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */
function ctlPeliVerPelis()
{
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll();
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
}

function ctlPeliVerPelisInvitado()
{
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll();
    // Invoco la vista 
    include_once 'plantilla/verpeliculasInvitado.php';
}
