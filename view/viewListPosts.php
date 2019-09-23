<?php $this->header = "Blog" ?>

<!-- Page blog header -->
<section class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Liste des articles</h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
      <i class="fas fa-star"></i>
    </div>
    <div class="divider-custom-line"></div>
  </div>

  <div class="container">
    <?php foreach ($posts as $post) : ?>
    <div class='row'>
      <div class='col-lg-12 col-md-12 mx-auto'>
        <a href="index.php?p=post&id=<?= htmlentities($post->id()); ?>">
          <h2><?= htmlspecialchars($post->title(), ENT_QUOTES, 'UTF-8', false); ?></h2>
          <?php if (htmlspecialchars($post->updated(), ENT_QUOTES, 'UTF-8', false) === "00/00/0000 à 00h00") : ?>
            </a><?= 'Posté le ' . htmlspecialchars($post->date(), ENT_QUOTES, 'UTF-8', false); ?>
          <? else : ?>
            </a><?= 'Modifié le ' . htmlspecialchars($post->updated(), ENT_QUOTES, 'UTF-8', false); ?>
          <?php endif ?>
        <p>Par <strong><?= htmlspecialchars($post->author(), ENT_QUOTES, 'UTF-8', false) ?></strong></p>
        <!--Mis en place du chapo -->
        <p><?= substr($this->clean($post->chapo()), 0, 200) . '...'; ?></p>
      </div>
    </div>
    <br>
    <?php endforeach; ?>
  </div>


</section>