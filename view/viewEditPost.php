<?php $this->header = "Administrer les articles" ?>
<?php $this->subheader = "Modifier un article" ?>

  <?php if (isset($this->error['title'])) : ?>
  <div class="container alert alert-danger">
    <?= $this->error['title'] ?>
  </div>
  <?php endif ?>

  <?php if (isset($this->error['author'])) : ?>
  <div class="container alert alert-danger">
    <?= $this->error['author'] ?>
  </div>
  <?php endif ?>

  <?php if (isset($this->error['chapo'])) : ?>
  <div class="container alert alert-danger">
    <?= $this->error['chapo'] ?>
  </div>
  <?php endif ?>

  <?php if (isset($this->error['content'])) : ?>
  <div class="container alert alert-danger">
    <?= $this->error['content'] ?>
  </div>
  <?php endif ?>

  <form class="container" action="index.php?p=editpost&id=<?= $post->id() ?>" method="POST">
    <div class="form-group">
      <label for="title">Titre</label>
      <input type="text" class="form-control" name="title" value="<?= $post->title() ?>">
    </div>
    <div class="form-group">
      <label for="title">Auteur</label>
      <input type="text" class="form-control" name="author" value="<?= $post->author() ?>">
    </div>
    <div class="form-group">
      <label for="title">Introduction</label>
      <input type="text" class="form-control" name="chapo" maxlength="200" value="<?= $post->chapo() ?>">
    </div>
    <div class="form-group">
      <label for="content">Contenu</label>
      <textarea type="text" class="form-control" name="content" rows="15"><?= $post->content() ?></textarea>
    </div>
    <input type="hidden" id="id" name="id" value="<?= $post->id() ?>">
    <button class="btn btn-success" name="publish" type="submit">Publié</button>
    <button class="btn btn-primary" name="unpublish" type="submit">Brouillon</button>
    <a class="btn btn-primary" href="index.php?p=adminpost">Retour</a>
  </form>

</section>