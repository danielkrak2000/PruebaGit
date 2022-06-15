<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta">
<table>
<tr><td>Título del la película    </td><td>   <input name="nombre" type="text"> </td></tr>
<tr><td>Director  </td><td>  <input name="director" type="text"> </td></tr>
<tr><td>Genero    </td><td>  <input name="genero" type="text"></td></tr>
<tr><td>Imagen    </td><td>   <input name="imagen" type="file">
</table>
<input type="submit" value="Almacenar">
<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>