<?php
//llamamos al file database para que se conecte
require "database.php";
//llamar los contactos de la base de datos
$contacts = $conn->query("SELECT * FROM contacts");

?>

<?php require("./partials/header.php"); ?>
<?php require("./partials/navbar.php"); ?>
  


<div class="container pt-4 p-3">
  <div class="row">
    <!-- si el array asociativo $contacts no tiene nada dentro, entonces imprimir el siguiente div -->
    <?php if ($contacts->rowCount() == 0): ?>
      <div class= "col-md-4 mx-auto">
        <div class= "card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="add.php" style="color: #ff9900;">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <!-- sirve para hacer una targeta por cada valor que tenga el array asociativo $contacts -->
    <?php foreach ($contacts as $contact): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center" style="background-color: #363636;">
          <div class="card-body"> 
            <h3 class="card-title text-capitalize"> <?= $contact["name"]?> </h3>
            <p class="m-2"><?= $contact["phone_number"]?></p>
            <!-- LLAMAMOS AL EDIT.PHP Y LE ASIGNAMOS EL ID CON UN ARRAY ASOCIATIVO AL ID QUE PERTENEZCA EL CONTACTO EN EL BUCLE FOREACH -->
            <a href="edit.php?id= <?= $contact["id"] ?> " class="btn btn-secondary mb-2">Edit Contact</a>
            <!-- LLAMAMOS AL DELETE.PHP Y LE ASIGNAMOS EL ID CON UN ARRAY ASOCIATIVO AL ID QUE PERTENEZCA EL CONTACTO EN EL BUCLE FOREACH -->
            <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>


<?php require("./partials/footer.php"); ?>
