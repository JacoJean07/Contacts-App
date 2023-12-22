<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #363636;">
  <div class="container-fluid">
    <!-- si existe una sesion iniciada redirigir al home -->
    <?php if (isset($_SESSION["user"])) : ?>
    <a class="navbar-brand" href="home.php">
      <img src="static/img/logo.png " alt="" width="30" height="30" style="margin-right: 10px;">
      Contacts App
    </a>
    <!-- si no, mandar al index o tambien llamado welcome page -->
    <?php else : ?>
    <a class="navbar-brand" href="index.php">
      <img src="static/img/logo.png " alt="" width="30" height="30" style="margin-right: 10px;">
      Contacts App
    </a>
    <?php endif ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex justify-content-between w-100">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- si existe una sesion iniciada pon los siguientes hipervinculos (home y add contacts) -->
          <?php if (isset($_SESSION["user"])) : ?>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="add.php">Add Contact</a>
            </li>
            <li class="nav-item">
              <!-- llamamos al logout.php -->
              <a class="nav-link active" aria-current="page" href="logout.php" style="color: #ff9900;">Logout</a>
            </li>
          <!-- sino pon los de registrar y login -->
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="login.php">Login</a>
            </li>
          <?php endif ?>
        </ul>
      </div>
      <!-- si existe la variable global sesion con el valor user, entonces mostrar el siguiente div -->
      <?php if (isset($_SESSION["user"])): ?>
        <div class="p-2">
          <!-- ponemos el email del usuario que inicio sesion -->
          <?= $_SESSION["user"]["email"] ?>
        </div>
      <?php endif ?>
    </div>
  </div>
</nav>
<!-- espacio para que el nav no se mezcle -->
<div style="margin-top: 100px;"></div>
<!-- mensajes flash -->
<!-- si existe el contenido flash en la variable global sesion imprimir lo siguiente -->
<?php if (isset($_SESSION["flash"])): ?>
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
  </svg>

  <div class="container mt-4" >
    <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2"  width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div class="ml-2">
        <!-- llamar al valor flash que contiene al contenido 'message' -->
        <?= $_SESSION["flash"]["message"] ?>
      </div>
    </div>
  </div>
  <!-- remover el mensaje flash para que solo aparezca una vez (si recargas la pagina se borra) -->
  <?php unset($_SESSION["flash"]) ?>
<?php endif ?>

<main>
  