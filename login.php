<?php

require "database.php";

$error = null;
//identifica el metodo que usa el server, en este caso si el metodo es POST procesa el if
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //validamos que los campos no se manden vacios
  if (empty($_POST["email"]) || empty($_POST["password"])){
    $error = "Please fill all fields(llena todo los campos).";
  // validamos que el email contenga @, hay que hacer una mejor validacion en caso de app verdadera y en caso de que el cliente o usuario no sea un navegador
  } else if (!str_contains($_POST["email"], "@")) {
    $error = "Email format is incorrect.";
  } else {
    //verificamos que el email existe
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $statement->bindParam(":email", $_POST["email"]);
    $statement->execute();
    //COMPROBAMOS QUE EL ID EXISTA, EN CASO DE QUE EL USUARIO NO SEA UN NAVEGADOR, Y SI NO EXISTE EL ID MANDAMOS UN ERROR
    if ($statement->rowCount() == 0) {
      $error = "Invalid Credentials";
    } else {
      //obtenemos los datos de usuario y asignamos a una variable user y lo pedimos en fetch assoc para que lo mande en un formato asociativo
      $user = $statement->fetch(PDO::FETCH_ASSOC);
      //comparamos si la contrasenia ingresada en el form es igual a la contrasenia que obtuvimos en la variable user
      if (!password_verify($_POST["password"], $user["password"])) {
        $error = "Invalid Credentials";
      } else {
        //borramos por asi decir la contrasenia del usuario en la secion para que no almacene ese valor y por seguridad
        unset($user["password"]);
        //iniciamos una sesion la cual es una cookie que es como un hash almacenado en el pc usuario para que almacene compruebe el usuario, asi la manera  de acceder a la sesion es por medio de la cockie y si alguien intenta hackear necesita el hash para poder hacer peticiones al servidor en lugar de solo necesitas el id
        session_start();
        //asignamos el usuario que se logueo a la secion iniciada
        $_SESSION["user"] = $user;
        

        //redirige al home.php
        header("Location: home.php");
      }
    }
  }
}


?>

<?php require("./partials/header.php"); ?>
<?php require("./partials/navbar.php"); ?>




<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center" style="background-color: #363636;">
        <div class="card-header" style="background-color: #ff9900;;">Login</div>
        <div class="card-body">
          <!-- si hay un error mandar un danger -->
          <?php if ($error): ?> 
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="login.php">

            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            <p>Don't have acount yet?</p>
            <a href="register.php" style="color: #ff9900;">Register!</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require("./partials/footer.php"); ?>
