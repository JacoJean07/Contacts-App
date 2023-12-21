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

      //redirige al index.php
    header("Location: index.php");
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boostrap -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/darkly/bootstrap.min.css" 
    integrity="sha512-JjQ+gz9+fc47OLooLs9SDfSSVrHu7ypfFM7Bd+r4dCePQnD/veA7P590ovnFPzldWsPwYRpOK1FnePimGNpdrA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
  <script 
    defer
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous">
  </script>
  <title>Contacts App</title>
</head>
<body style="background-color: rgb(75, 60, 46);">
  
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #363636;">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="static/img/logo.png " alt="" width="30" height="30" style="margin-right: 10px;">
        Contacts App
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Add Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Regresar al Portfolio</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-warning" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>


  <main>
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
  </main>


</body>
</html>
