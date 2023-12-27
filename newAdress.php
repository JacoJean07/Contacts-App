<?php

require "database.php";
//llamar a la funcion sesion para identificar las sesiones
session_start();
//si la sesion no existe, mandar al login.php y dejar de ejecutar el resto; se puede hacer un required para ahorra codigo
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$error = null;
//identifica el metodo que usa el server, en este caso si el metodo es POST procesa el if
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //se valida que no se envien datos vacios
  if (empty($_POST["name_adress"]) || empty($_POST["adress"])) {
    $error = "POR FAVOR RELLENA LOS CAMPOS";
  } else {
    //declara variables y las asigna a los name_adress de los input del form en caso de que el usuario no sea el navegador
    $nameAdress = $_POST["name_adress"];
    $adress = $_POST["adress"];
    
    //mandar los datos a la base de datos y tambien obtener el valor del user_id para mandarlo, no se hace un bindParam porque con la funcion sesion_start ya se obtiene el user
    $statement = $conn->prepare("INSERT INTO adresses (user_id, name_adress, adress) VALUES ({$_SESSION['user']['id']}, :name_adress, :adress)");
    //sanitizar valores para inyecciones sql
    $statement->bindParam(":name_adress", $_POST["name_adress"]);
    $statement->bindParam(":adress", $_POST["adress"]);
    //ahora lo ejecutamos
    $statement->execute();

    //mensaje flash
    $_SESSION["flash"] = ["message" => "Adress {$_POST['name_adress']} added."];

      //redirige al adresses.php
    header("Location: adresses.php");
    //acabamos el codigo aqui porque ya nos redirige al adresses, y si dejamos que el codigo siga ejecutandose entonces no aparecera el mensaje flash
    return;
  }
}

?>

<?php require("./partials/header.php"); ?>
<?php require("./partials/navbar.php"); ?>




<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center" style="background-color: #363636;">
        <div class="card-header" style="background-color: #ff9900;;">Add adress</div>
        <div class="card-body">
          <!-- si hay un error mandar un danger -->
          <?php if ($error): ?> 
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="newAdress.php">
            <div class="mb-3 row">
              <label for="name_adress" class="col-md-4 col-form-label text-md-end">Name of adress</label>

              <div class="col-md-6">
                <input id="name_adress" type="text" class="form-control" name="name_adress" required autocomplete="name_adress" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="adress" class="col-md-4 col-form-label text-md-end">Adress</label>

              <div class="col-md-6">
                <input id="adress" type="tel" class="form-control" name="adress" required autocomplete="adress" autofocus>
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
