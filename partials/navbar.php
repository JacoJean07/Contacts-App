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
<main>
  