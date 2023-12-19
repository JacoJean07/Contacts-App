<?php
//identifica el metodo que usa el server, en este caso si el metodo es POST procesa el if
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //variable contact para almacenar los valores del form
  $contact = [
    "name" => $_POST["name"],
    "phone_number" => $_POST["phone_number"],
  ];
  //usamos la misma logica que en el index.php, si existe el archivo, lo decodificamos, obtenemos los datos, y a la hora de guardar obtendra el otro dato y lo pondra debajo, con esto evitmos sobreescribir el archivo
  if (file_exists("contacts.json")) {
    $contacts = json_decode(file_get_contents("contacts.json"), true);
  //sino definir la variable contactos como vacia, o la lista en este caso
  } else {
    $contacts = [];
  }
  // en php se asigna valores de esta manera, entonces cada vez que la variable contact almacene un contacto se aniadira a la lista contacts
  //array asociativo (nombre de la lista en php)
  $contacts[] = $contact;
  //enviamos el contenido al .json, entonces nombramos el nombre del .json y luego asignamos la lista, diccionario, o variable que queremos introducir en el .json
  file_put_contents("contacts.json", json_encode($contacts));
  //creamos una cabecera para redirigir al index, en lugar de darnos el 200 ok (contrario del 404 not found) nos dara el header location redirigiendonos al index.php (302 found)
  header("Location: index.php");
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
  </main>


</body>
</html>
