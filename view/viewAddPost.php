<?php $this->header = "Ajouter un article" ?>
<?php $this->subheader = "Nouvel article" ?>

  <?php if(isset($this->error['title'])): ?>
    <div class="container alert alert-danger">
      <?= htmlentities($this->error['title']) ?>
    </div>
  <?php endif ?>

  <?php if(isset($this->error['chapo'])): ?>
    <div class="container alert alert-danger">
      <?= htmlentities($this->error['chapo']) ?>
    </div>
  <?php endif?> 

  <?php if(isset($this->error['content'])): ?>
    <div class="container alert alert-danger">
      <?= htmlentities($this->error['content']) ?>
    </div>
  <?php endif?> 

    <form class="container" action="" method="POST">
    <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
    <div class="form-group">
      <label for="title">Titre</label>
      <input type="text" class="form-control" name="title" placeholder="Titre de l'article" value="<?php if(filter_input(INPUT_POST, 'title')) { echo filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); } else { echo ""; }?>">
    </div>
    <div class="form-group">
      <label for="title">Introduction</label>
      <input type="text" class="form-control" name="chapo" placeholder="Introduction" maxlength="200" value="<?php if(filter_input(INPUT_POST, 'chapo')) { echo filter_var($_POST['chapo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); } else { echo ""; }?>">
    </div>
    <div class="form-group">
      <label for="content">Contenu</label>
      <textarea type="text" class="form-control" name="content" placeholder="Votre article..." rows="15"><?php if(filter_input(INPUT_POST, 'content')) { echo filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); } else { echo ""; }?></textarea>
    </div>
    <button class="btn btn-success" name="publish" type="submit">Publié</button>
    <button class="btn btn-primary" name="unpublish" type="submit">Brouillon</button>
</form>

</section>