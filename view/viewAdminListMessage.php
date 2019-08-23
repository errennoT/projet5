<?php $this->header = "Administrer les messages utilisateurs" ?>

<!-- Page blog header -->
<section id="list" class="page-section">
  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Administration</h2>

  <div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
      <i class="fas fa-star"></i>
    </div>
    <div class="divider-custom-line"></div>
  </div>

  <div class="container">
    <div class="row justify-content-md-center">
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?u=adminuser">Utilisateurs</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?p=adminpost">Articles</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?c=admincommentfilter#list">Commentaires</a>
      <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?m=listmessage#list">Messages</a>
    </div>
  </div>

  <br>

  <div class="container">
    <?php foreach ($messages as $message) : ?>
    <div class='row'>
      <div class='col-lg-12 col-md-12 mx-auto'>
        <a href="index.php?m=message&id=<?= $this->clean($message->id()); ?>">
          <h2><?= $this->clean($message->surname()) . ' ' . $this->clean($message->name()) ?></h2>
        </a>
        </a><?= 'Message du ' . $this->clean($message->date()); ?>
        <p><?= substr($this->clean($message->content()), 0, 200) . '...'; ?></p>
      </div>
    </div>
    <br>
    <?php endforeach; ?>
  </div>


</section>