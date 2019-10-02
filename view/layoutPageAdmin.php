<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $this->clean($title) ?></title>

  <!-- Custom fonts for this theme -->
  <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <?php $file = 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'freelancer.min.css'; ?>
  <link href="<?= $this->clean($file) ?>" rel="stylesheet">


</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="index.php">Projet n°5</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/projet5/#portfolio">Portfolio</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/projet5/#about">A Propos</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/projet5/#contact">Contact</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="index.php?p=listpost">Blog</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <?php if ($this->superGlobal->undirectUseSession('user')) : ?>
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="index.php?u=logout">Se déconnecter</a>
            <?php elseif ($this->superGlobal->undirectUseSession('admin')) : ?>
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="index.php?u=admin">Administration</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="index.php?u=logout">Se déconnecter</a>
          <?php else : ?>
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="index.php?u=login">Se connecter</a>
          <?php endif ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
      <?= $this->clean($logo) ?>
      <h1 class="masthead-heading text-uppercase mb-0"><?= $this->clean($header) ?></h1>
    </div>
  </header>

  <!-- Page blog header -->
  <section id="list" class="page-section">
    <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0"><?= $this->clean($subheader) ?></h2>

    <div class="divider-custom">
      <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
        <i class="fas fa-star"></i>
      </div>
      <div class="divider-custom-line"></div>
    </div>

    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <?= html_entity_decode($nav) ?>
          <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?u=adminuser">Utilisateurs</a>
          <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?p=adminpost">Articles</a>
          <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?c=admincommentfilter">Commentaires</a>
          <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?m=listmessage">Messages</a>
        </div>
      </div>
    </div>

    <br>

    <!-- Content -->
    <div>
      <?= $content ?>
    </div>

  </section>

  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <div class="row">

        <!-- Footer Location -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Localisation</h4>
          <p class="lead mb-0">2, rue Jean de la Fontaine
            <br>32000 AUCH</p>
        </div>

        <!-- Footer Social Icons -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">CV et profil LinkedIn</h4>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-linkedin-in"></i>
          </a>

        </div>

        <!-- Footer About Text -->
        <div class="col-lg-4">
          <h4 class="text-uppercase mb-4">Projet 5</h4>
          <p class="lead mb-0">Ceci est le projet n°5 avec l'aide
            <a href="https://openclassrooms.com/">d'OpenClassrooms</a>.</p>
        </div>

      </div>
    </div>
  </footer>

  <!-- Copyright Section -->
  <section class="copyright py-4 text-center text-white">
    <div class="container">
      <small>&copy; Copyright 2019 - Romain GUIBAUD </small>
    </div>
  </section>

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="public/vendor/jquery/jquery.min.js"></script>
  <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="public/js/jqBootstrapValidation.js"></script>
  <script src="public/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="public/js/freelancer.min.js"></script>

</body>

</html>