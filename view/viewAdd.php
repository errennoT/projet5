<?php $this->header = "Bienvenue parmi nous" ?>

<section class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Créer un compte</h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
        <i class="fas fa-star"></i>
      </div>
    <div class="divider-custom-line"></div>
  </div>

<!-- Show error -->

<?php if(isset($this->error['doubleLoginEmail'])): ?>
    <div class="container alert alert-danger">
      <?= $this->error['doubleLoginEmail'] ?>
    </div>
  <?php endif ?>
  
<?php if(isset($this->error['doubleLogin'])): ?>
    <div class="container alert alert-danger">
      <?= $this->error['doubleLogin'] ?>
    </div>
  <?php endif ?>

  <?php if(isset($this->error['doubleEmail'])): ?>
    <div class="container alert alert-danger">
      <?= $this->error['doubleEmail'] ?>
    </div>
  <?php endif ?>

  <?php if(!empty($this->error) && $this->error !== 'succes'): ?>
    <div class="container alert alert-danger">
      Le formulaire est mal rempli.
    </div>
  <?php endif ?>

  <?php if($this->error == 'succes'): ?>
    <div class="container alert alert-success">
      Votre compte a bien été crée. <br>
      Vous pouvez vous <a href="index.php?u=login">connecter</a>.
    </div>
  <?php endif ?>

<!-- Register form -->
  <form class="container" action="" method="POST">
    <div class="form-group">
      <label for="login">Pseudo</label>
      <input type="text" class="form-control <?= isset($this->error['login']) ? 'is-invalid' : ''; ?>" name="login" placeholder="Pseudo" value="<?php if(isset($_POST['login'])) { echo htmlentities($_POST['login']); } else { echo ""; }?>">
      <?php if (isset($this->error['login'])):?>
            <div class="invalid-feedback">
                <?= $this->error['login'] ;?>
            </div>
      <?php endif?>
    </div>
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input type="text" class="form-control <?= isset($this->error['email']) ? 'is-invalid' : ''?>" name="email"  placeholder="E-mail" value="<?php if(isset($_POST['email'])) { echo htmlentities($_POST['email']); } else { echo ""; }?>">
      <div class="invalid-feedback">
        <?= $this->error['email'] ;?>
      </div>
    </div>
    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" class="form-control <?= isset($this->error['password']) ? 'is-invalid' : ''?>" name="password" placeholder="Mot de passe">
      <?php if (isset($this->error['password'])):?>
            <div class="invalid-feedback">
                <?= $this->error['password'] ;?>
            </div>
      <?php endif?>
    </div>
    <button class="btn btn-primary" type="submit">S'enregistrer</button>
</form>

</section>
