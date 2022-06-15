<?php
ob_start();
?>
<form method="POST" action="index.php?orden=Votar">
    <h2> Detalles </h2>
    <table>
        <tr>
            <td>Código de película </td>
            <td><input name="codigo_pelicula" type="text" value="<?= $pelicula[0] ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre </td>
            <td><input name="nombre" type="text" value="<?= $pelicula[1] ?>" readonly></td>
        </tr>
        <tr>
            <td>Director </td>
            <td><input name="director" type="text" value="<?= $pelicula[2] ?>" readonly></td>
        </tr>
        <tr>
            <td>Genero </td>
            <td><input name="genero" type="text" value="<?= $pelicula[3] ?>" readonly></td>
        </tr>
        <tr>
            <td>Imagen </td>
            <td> <img src="img/<?= $pelicula[4] ?>"></td>
        </tr>
        <tr>
            <td>Votar</td>
            <td><select name="voto" id="voto">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <input name="votostotales" type="text" value="<?= $pelicula[5] ?>" readonly>
                <?php if (isset($_SESSION['mensaje']) && $_SESSION['mensaje']!=null):?>
                    <p><?= $_SESSION['mensaje'] ?></p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Media</td>
            <td><input name="media" type="text" value="<?= $pelicula[6] / $pelicula[5] ?>" readonly></td>
        </tr>
    </table>

    <input type="submit" name="votar">
</form>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'">
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>