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
        <a href="index.php?p=post&id=<?= $this->clean($post->id()); ?>">
          <h2><?= $this->clean($post->title()); ?></h2>
          <?php if ($post->updated() === "00/00/0000 à 00h00") : ?>
            </a><?= 'Posté le ' . $this->clean($post->date()); ?>
          <? else : ?>
            </a><?= 'Modifié le ' . $this->clean($post->updated()); ?>
          <?php endif ?>
        <p>Par <strong><?= $this->clean($post->author()) ?></strong></p>
        <!--Mis en place du chapo -->
        <p><?= substr($this->clean($post->chapo()), 0, 200) . '...'; ?></p>
      </div>
    </div>
    <br>
    <?php endforeach; ?>
  </div>


</section>