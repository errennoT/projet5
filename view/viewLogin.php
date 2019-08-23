<!-- Page blog header -->
<?php $this->header = "S'identifier" ?>

<section class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Se connecter</h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
        <i class="fas fa-star"></i>
      </div>
    <div class="divider-custom-line"></div>
  </div>

<!-- Show error -->

  <?php if(isset($this->error['incorrect'])): ?>
    <div class="container alert alert-danger">
      <?= $this->error['incorrect'] ?>
    </div>
  <?php endif ?>

  <?php if(isset($this->error['ban'])): ?>
    <div class="container alert alert-danger">
      <?= $this->error['ban'] ?>
    </div>
  <?php endif?> 

<!-- Register form -->
  <form class="container" action="" method="POST">
    <div class="form-group">
      <label for="login">Pseudo</label>
      <input type="text" class="form-control" name="login" placeholder="Pseudo">
    </div>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" class="form-control" name="password" placeholder="Mot de passe">
    </div>
    <div class="form-group">
        <a href="index.php?u=add">Pas de compte ?</a> 
    </div>
    <button class="btn btn-primary" type="submit">Se connecter</button>
</form>

</section>

