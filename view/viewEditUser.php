<?php $this->header = "Modifier un utilisateur" ?>
<?php $this->subheader = $this->clean($user->login()) ?>

    <!-- Show error -->
    <?php if (isset($this->error['doubleLoginEmail'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->clean($this->error['doubleLoginEmail']) ?>
        </div>
    <?php endif ?>

    <?php if (isset($this->error['doubleLogin'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->clean($this->error['doubleLogin']) ?>
        </div>
    <?php endif ?>

    <?php if (isset($this->error['doubleEmail'])) : ?>
        <div class="container alert alert-danger">
            <?= $this->clean($this->error['doubleEmail']) ?>
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
<form class="container" action="index.php?u=edituser&id=<?= $this->clean($user->id()) ?>" method="POST">
<input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>"/>
    <div class="form-group">
      <label for="login">Pseudo</label>
      <input type="text" class="form-control <?= isset($this->error['login']) ? 'is-invalid' : ''; ?>" name="login" placeholder="<?= $this->clean($user->login()) ?>" value="<?php if(filter_input(INPUT_POST, 'login')) { echo filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); } else { echo ""; }?>">
      <?php if (isset($this->error['login'])):?>
            <div class="invalid-feedback">
                <?= $this->clean($this->error['login']) ;?>
            </div>
      <?php endif?>
    </div>
    <div class="form-group">
      <label for="email">Adresse mail</label>
      <input type="text" class="form-control <?= isset($this->error['email']) ? 'is-invalid' : ''?>" name="email"  placeholder="<?= $this->clean($user->email()) ?>" value="<?php if(filter_input(INPUT_POST, 'email')) { echo filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); } else { echo ""; }?>">
      <div class="invalid-feedback">
        <?= $this->clean($this->error['email']) ;?>
      </div>
    </div>
    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" class="form-control <?= isset($this->error['password']) ? 'is-invalid' : ''?>" name="password" placeholder="Mot de passe">
      <?php if (isset($this->error['password'])):?>
            <div class="invalid-feedback">
                <?= $this->clean($this->error['password']) ;?>
            </div>
      <?php endif?>
    </div>
    <input type="hidden" id="id" name="id" value="<?= $this->clean($user->id()) ?>">
    <button class="btn btn-success" type="submit">Modifier</button>
    <a class="btn btn-primary" href="index.php?u=adminuser">Retour</a>
</form>

</section>