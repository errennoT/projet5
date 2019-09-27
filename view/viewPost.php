<?php $this->header = htmlspecialchars($post->title(), ENT_QUOTES, 'UTF-8', false) ?>

<section class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0"><?= htmlspecialchars($post->title(), ENT_QUOTES, 'UTF-8', false); ?></h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
      <i class="fas fa-star"></i>
    </div>
    <div class="divider-custom-line"></div>
  </div>

  <!-- View Article -->
  <div class="container">
    <?php if ($this->clean($post->updated()) === "00/00/0000 à 00h00") : ?>
      <h4>Posté le <?= htmlspecialchars($post->date()) ?></h4>
    <? else : ?>
      <h4>Modifié le <?= htmlspecialchars($post->updated()) ?></h4>
    <?php endif ?>
    <p>Par <strong><?= htmlspecialchars($post->author(), ENT_QUOTES, 'UTF-8', false) ?></strong></p>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <p><?= nl2br(htmlspecialchars($post->content(), ENT_QUOTES, 'UTF-8', false)); ?></p>
        <input class="btn btn-primary" type="button" value="Retour" onclick="history.go(-1)">
      </div>
    </div>
    <hr>
  </div>

  <br><br>
  <?php if (isset($this->error['content'])) : ?>
    <div class="container alert alert-danger">
      <?= htmlspecialchars($this->error['content']) ?>
    </div>
  <?php endif ?>

  <?php if (!empty($comments)) : ?>
    <h3 class="container">Liste des commentaires</h3>
  <?php endif ?>
  <br>

  <div class="container">
    <?php foreach ($comments as $comment) : ?>
      <div class='row'>
        <div class='col-lg-12 col-md-12 mx-auto'>
          <a href="index.php?p=post&id=<?= htmlentities($comment->id()); ?>"></a>
          <p>Commenté par <strong><?= htmlspecialchars($comment->author(), ENT_QUOTES, 'UTF-8', false) ?></strong> le <?= htmlspecialchars($comment->date()) ?></p>
          <p><?= htmlspecialchars($comment->content(), ENT_QUOTES, 'UTF-8', false) ?> <br>
            _________________________________________</p>
        </div>
      </div>
      <br>
    <?php endforeach; ?>
  </div>

  <?php if ($this->superGlobal->undirectUseSession('user') || $this->superGlobal->undirectUseSession('admin')) : ?>
    <form class="container" action="index.php?c=addcomment&id=<?= htmlentities($post->id()) ?>" method="POST">
      <div class="form-group">
        <label for="content">Commentaire</label>
        <textarea type="text" class="form-control" name="contentComment" placeholder="Votre commentaire..." rows="5"></textarea>
      </div>
      <button class="btn btn-danger" name="sendComment" type="submit">Envoyé</button>
    </form>
  <?php endif ?>

</section>