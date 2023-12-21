<?php

require "database.php";
// USAREMOS EL METODO GET PARA BUSCAR EL ROW QUE VAMOS A ELIMINAR
$id = $_GET["id"];
//PRIMERO LO SOLICITAMOS A LA BASE DE DATOS
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->execute([":id" => $id]);
//COMPROBAMOS QUE EL ID EXISTA, EN CASO DE QUE EL USUARIO NO SEA UN NAVEGADOR, Y SI NO EXISTE EL ID MANDAMOS UN ERROR
if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND (ID NO ENCONTRADO)");
  return;
}

//ELIMINAMOS EL ROW CON EL ID DE LA TARGETA SELECCIONADA, nos ahorramos dos statement y ejecutamos en la misma linea
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);
//REDIRIGIMOS AL INDEX.PHP
header("Location: index.php");

?>
