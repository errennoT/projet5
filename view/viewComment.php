<?php $this->header = "Commentaire" ?>

<section class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Commentaire de <?= htmlspecialchars($comment->author(), ENT_QUOTES, 'UTF-8', false) ?></h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
      <i class="fas fa-star"></i>
    </div>
    <div class="divider-custom-line"></div>
  </div>

  <!-- View Article -->
  <div class="container">
    <p><?= htmlspecialchars($comment->content(), ENT_QUOTES, 'UTF-8', false) ?><p>
        <input class="btn btn-primary" type="button" value="Retour" onclick="history.go(-1)">
  </div>

  <br>