<?php $this->header = "Modifier un utilisateur" ?>
<?php $this->subheader = htmlentities($user->login()) ?>

    <!-- Show error -->
    <?php if (isset($this->error['doubleLoginEmail'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->error['doubleLoginEmail'] ?>
        </div>
    <?php endif ?>

    <?php if (isset($this->error['doubleLogin'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->error['doubleLogin'] ?>
        </div>
    <?php endif ?>

    <?php if (isset($this->error['doubleEmail'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->error['doubleEmail'] ?>
        </div>
    <?php endif ?>

    <?php if (!empty($this->error) && $this->error !== 'succes') : ?>
        <div class="container alert alert-danger">
            Le formulaire est mal rempli.
        </div>
    <?php endif ?>

    <?php if ($this->error == 'succes') : ?>
        <div class="container alert alert-success">
            Votre compte a bien été crée. <br>
            Vous pouvez vous connecter.
        </div>
    <?php endif ?>

    <!-- Edit form -->
<form class="container" action="index.php?u=edituser&id=<?= $user->id() ?>" method="POST">
<input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>"/>
    <div class="form-group">
      <label for="login">Pseudo</label>
      <input type="text" class="form-control <?= isset($this->error['login']) ? 'is-invalid' : ''; ?>" name="login" placeholder="<?= $user->login() ?>" value="<?php if(isset($_POST['login'])) { echo htmlentities($_POST['login']); } else { echo ""; }?>">
      <?php if (isset($this->error['login'])):?>
            <div class="invalid-feedback">
                <?= $this->error['login'] ;?>
            </div>
      <?php endif?>
    </div>
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input type="text" class="form-control <?= isset($this->error['email']) ? 'is-invalid' : ''?>" name="email"  placeholder="<?= $user->email() ?>" value="<?php if(isset($_POST['email'])) { echo htmlentities($_POST['email']); } else { echo ""; }?>">
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
    <input type="hidden" id="id" name="id" value="<?= $user->id() ?>">
    <button class="btn btn-success" type="submit">Modifier</button>
    <a class="btn btn-primary" href="index.php?u=adminuser">Retour</a>
</form>

</section>