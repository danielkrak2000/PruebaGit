<?php
include_once 'app/Pelicula.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];

?>
<!--Preguntar por que GET aunque imagino que es para se envie el formulario en cuanto se cargque la pagina y
se linkea con el index.php para poder usar todos los metodos creados-->
<form action="index.php" method="GET">
     &#128270 <input type="text" name="valor" placeholder="Valor a buscar.." required ><th>
	<input type='submit' name='orden' value='BuscarNombre'>
	<input type='submit' name='orden' value='BuscarDirector'>
	<input type='submit' name='orden' value='BuscarGenero'>
</form>
<table>
<th>Código</th><th>Nombre</th><th>Director</th><th>Genero</th>
<!--$peliculas tiene un array con los datos de todas las peliculas que hemos sacado con getAll y ahora en funcion
de que metodo quieres usar para cada peli, puedes saberlo ya que tenemos los codigo_pelicula de cada una-->
<?php foreach ($peliculas as $peli) : ?>
<tr>	
<td><?= $peli->codigo_pelicula ?></td>
<td><?= $peli->nombre ?></td>
<td><?= $peli->director ?></td>
<td><?= $peli->genero ?></td>
<?php if(isset($_SESSION['usuario'])):?>
<td><a href="#"
			onclick="confirmarBorrar('<?= $peli->nombre."','".$peli->codigo_pelicula."'"?>);">Borrar</a></td>

<?php endif; ?>
<!--Si queremos visualizar por ejemplo los detalles de una pelicula en concreto igualamos la variable codigo
que hemos declarado en detalles "Detalles&codigo=" con el codigo_pelicula podremos recoger ese dato con un
$_GET['codigo'] para poder saber a que pelicula aplicar la funcion ctlPeliDetalles-->
<?php if(isset($_SESSION['usuario'])):?>
<td><a href="<?= $auto?>?orden=Modificar&codigo=<?=$peli->codigo_pelicula?>">Modificar</a></td>
<?php endif; ?>
<td><a href="<?= $auto?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula?>">Detalles</a></td>

</tr>
<?php endforeach; ?>
</table>
<br>
<form name='f2' action='index.php'>
<input type='hidden' name='orden' value='Alta'> 

<?php if(isset($_SESSION['usuario'])):?>
<button name="orden" value="Alta">Nueva Película</button>
<?php endif; ?>
<button name="orden" value="DescargarJSON">Descargar JSON</button>
<button name="orden" value="Salir">Salir</button>
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>