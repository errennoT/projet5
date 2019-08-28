<?php

$this->header = "Modifier un article" ?>

<!-- Page blog header -->
<section id="write" class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Administration</h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
      <i class="fas fa-star"></i>
    </div>
    <div class="divider-custom-line"></div>
  </div>

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

  <div class="container">
    <div class="row justify-content-md-center">
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?u=adminuser">Utilisateurs</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?p=adminpost">Articles</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?c=admincommentfilter#list">Commentaires</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?m=listmessage#list">Messages</a>
    </div>
  </div>

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