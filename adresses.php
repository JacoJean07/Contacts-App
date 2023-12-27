<?php
//llamamos al file database para que se conecte
require "database.php";
//llamar a la funcion sesion para identificar las sesiones
session_start();
//si la sesion no existe, mandar al login.php y dejar de ejecutar el resto; se puede hacer un required para ahorra codigo
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

//llamar los contactos de la base de datos y especificar que sean los que tengan el user_id de la funcion sesion_start
$adresses = $conn->query("SELECT * FROM adresses WHERE user_id = {$_SESSION['user']['id']}");

?>

<?php require("./partials/header.php"); ?>
<?php require("./partials/navbar.php"); ?>
  


<div class="container pt-4 p-3">
  <?php require("./partials/msgFlash.php"); ?>
  <div class="row">
    <!-- si el array asociativo $adresses no tiene nada dentro, entonces imprimir el siguiente div -->
    <?php if ($adresses->rowCount() == 0): ?>
      <div class= "col-md-4 mx-auto">
        <div class= "card card-body text-center">
          <p>No adress saved yet</p>
          <a href="newAdress.php" style="color: #ff9900;">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <!-- sirve para hacer una targeta por cada valor que tenga el array asociativo $adresses -->
    <?php foreach ($adresses as $adress): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center" style="background-color: #363636;">
          <div class="card-body"> 
            <h3 class="card-title text-capitalize"> <?= $adress["name_adress"]?> </h3>
            <p class="m-2"><?= $adress["adress"]?></p>
            <!-- LLAMAMOS AL EDIT.PHP Y LE ASIGNAMOS EL ID CON UN ARRAY ASOCIATIVO AL ID QUE PERTENEZCA EL CONTACTO EN EL BUCLE FOREACH -->
            <a href="editAdress.php?id= <?= $adress["id"] ?> " class="btn btn-secondary mb-2">Edit Adress</a>
            <!-- LLAMAMOS AL DELETE.PHP Y LE ASIGNAMOS EL ID CON UN ARRAY ASOCIATIVO AL ID QUE PERTENEZCA EL CONTACTO EN EL BUCLE FOREACH -->
            <a href="deleteAdress.php?id=<?= $adress["id"] ?>" class="btn btn-danger mb-2">Delete Adress</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>


<?php require("./partials/footer.php"); ?>
