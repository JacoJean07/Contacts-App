<?php

require "database.php";

$error = null;
//identifica el metodo que usa el server, en este caso si el metodo es POST procesa el if
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //se valida que no se envien datos vacios
  if (empty($_POST["name"]) || empty($_POST["phone_number"])) {
    $error = "POR FAVOR RELLENA LOS CAMPOS";
    //validacion del numero de telefono para que no sea menor a 9 numeros
  } elseif (strlen($_POST["phone_number"]) < 9){
    $error = "Numero invalido, minimo 10 caracteres";
  } else {
    //declara variables y las asigna a los name de los input del form en caso de que el usuario no sea el navegador
    $name = $_POST["name"];
    $phoneNumber = $_POST["phone_number"];
    
    //mandar los datos a la base de datos
    $statement = $conn->prepare("INSERT INTO contacts (name, phone_number) VALUES (:name, :phone_number)");
    //sanitizar valores para inyecciones sql
    $statement->bindParam(":name", $_POST["name"]);
    $statement->bindParam(":phone_number", $_POST["phone_number"]);
    //ahora lo ejecutamos
    $statement->execute();

      //redirige al home.php
    header("Location: home.php");
  }
}

?>

<?php require("./partials/header.php"); ?>
<?php require("./partials/navbar.php"); ?>



<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center" style="background-color: #363636;">
        <div class="card-header" style="background-color: #ff9900;;">Add contacts</div>
        <div class="card-body">
          <!-- si hay un error mandar un danger -->
          <?php if ($error): ?> 
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require("./partials/footer.php"); ?>
