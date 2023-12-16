<?php

$contacts = [
  ["name" => "Jean", "phone_number" => "0981691319"],
  ["name" => "Pablo", "phone_number" => "98234634324"],
  ["name" => "Jesus", "phone_number" => "763549123213"],
  ["name" => "Shirley", "phone_number" => "13217685434"],
  ["name" => "Jordan", "phone_number" => "43575683465"],
];

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
      <a class="navbar-brand" href="#">
        <img src="static/img/logo.png " alt="" width="30" height="30" style="margin-right: 10px;">
        Contacts App
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="add.html">Add Contact</a>
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
    <div class="container pt-4 p-3">
      <div class="row">

        <?php foreach ($contacts as $contact): ?>
          <div class="col-md-4 mb-3">
            <div class="card text-center" style="background-color: #363636;">
              <div class="card-body"> 
                <h3 class="card-title text-capitalize"> <?= $contact["name"]?> </h3>
                <p class="m-2"><?= $contact["phone_number"]?></p>
                <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
                <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
              </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>
    </div>
  </main>
</body>
</html>
