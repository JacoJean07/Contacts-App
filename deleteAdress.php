<?php

require "database.php";
//llamar a la funcion sesion para identificar las sesiones
session_start();
//si la sesion no existe, mandar al login.php y dejar de ejecutar el resto; se puede hacer un required para ahorra codigo
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
// USAREMOS EL METODO GET PARA BUSCAR EL ROW QUE VAMOS A ELIMINAR
$id = $_GET["id"];
//PRIMERO LO SOLICITAMOS A LA BASE DE DATOS
$statement = $conn->prepare("SELECT * FROM adresses WHERE id = :id AND user_id = {$_SESSION['user']['id']}");
$statement->execute([":id" => $id]);
//COMPROBAMOS QUE EL ID EXISTA, EN CASO DE QUE EL USUARIO NO SEA UN NAVEGADOR, Y SI NO EXISTE EL ID MANDAMOS UN ERROR
if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}

//ELIMINAMOS EL ROW CON EL ID DE LA TARGETA SELECCIONADA, nos ahorramos dos statement y ejecutamos en la misma linea
$conn->prepare("DELETE FROM adresses WHERE id = :id")->execute([":id" => $id]);
//mensaje flash
$_SESSION["flash"] = ["message" => "Adress delete."];
//REDIRIGIMOShome
header("Location: adresses.php");
//acabamos el codigo aqui porque ya nos redirige al home, y si dejamos que el codigo siga ejecutandose entonces no aparecera el mensaje flash
return;
?>
