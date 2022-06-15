<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg)) ? $msg : "" ?></b></div>
<form name='ALTA' method="POST" enctype="multipart/form-data" action="index.php?orden=Modificar">
<table>
<tr><td>Código</td><td><input name="codigo_pelicula" type="text" value="<?=$codigo?>" readonly > </td></tr>
<tr><td>Nombre : </td><td><input type="text" name="nombre" value="<?= $nombre ?>"></td></tr>
<tr><td>Director : </td><td><input type="text" name="director" value="<?= $director ?>"></td></tr>
<tr><td>Genero : </td><td><input type="text" name="genero" value="<?= $genero ?>"></td></tr>
<tr>
    <td>Imagen :</td>
    <td>
        <img src="img/<?=$imagen?>" alt="Imagen no disponible"><br>
        <input name="imagenantigua" type="hidden" value="<?=$imagen?>">
        <input name="imagen" type="file">
    </td>
</tr>
</table>
<input type="submit" value="Guardar">
<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'">
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>