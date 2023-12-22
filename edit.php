<?php

require "database.php";

// USAREMOS EL METODO GET PARA BUSCAR EL ROW QUE VAMOS A ELIMINAR
$id = $_GET["id"];
//PRIMERO LO SOLICITAMOS A LA BASE DE DATOS, Y APARTE LIMITAMOS A QUE SOLO NOS DE UN ROW, EN CASO DE ALGUN ERROR EN LA BASE AUNQUE SEA IMPOSIBLE, APARTE AYUDA A QUE DE BIEN EL ARRAY ASOCIATIVO
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->execute([":id" => $id]);
//COMPROBAMOS QUE EL ID EXISTA, EN CASO DE QUE EL USUARIO NO SEA UN NAVEGADOR, Y SI NO EXISTE EL ID MANDAMOS UN ERROR
if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND (ID NO ENCONTRADO)");
  return;
}

//ASIGNAMOS LOS DATOS RECUPERADOS Y USAMOS UN FETCH PARA TRANSFORMALO A ALGO QUE NOSOTROS PODAMOS MANIPULAR, EN ESTE CASO EL ROW QUEREMOS QUE NOS LLEGUE DE MANERA ASOCIATIVA, UN ARRAY ASOCIATIVO
$contact = $statement->fetch(PDO::FETCH_ASSOC);

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
    
    //actualizar los datos a la base de datos
    $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id");
    $statement->execute([
      ":id" => $id,
      ":name" => $_POST["name"],
      ":phone_number" => $_POST["phone_number"],
    ]);

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
        <div class="card-header" style="background-color: #ff9900;;">Edit contacts</div>
        <div class="card-body">
          <!-- si hay un error mandar un danger -->
          <?php if ($error): ?> 
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <!-- pido el valor del id de nuevo para luego mandar los datos a actualizar -->
          <form method="POST" action="edit.php?id=<?= $contact["id"] ?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <!-- asignamos con el value los datos a editar -->
                <input value="<?= $contact["name"] ?>" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <!-- asignamos con el value los datos a editar -->
                <input value="<?= $contact["phone_number"] ?>" id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
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
