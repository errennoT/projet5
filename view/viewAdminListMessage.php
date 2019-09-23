<?php $this->header = "Administrer les messages" ?>
<?php $this->subheader = "Messages" ?>

<div class="container">
  <?php foreach ($messages as $message) : ?>
    <div class='row'>
      <div class='col-lg-12 col-md-12 mx-auto'>
        <a href="index.php?m=message&id=<?= htmlentities($message->id()); ?>">
          <h2><?= htmlspecialchars($message->surname(), ENT_QUOTES, 'UTF-8', false) . ' ' . htmlspecialchars($message->name(), ENT_QUOTES, 'UTF-8', false) ?></h2>
        </a>
        </a><?= 'Message du ' . htmlspecialchars($message->date(), ENT_QUOTES, 'UTF-8', false); ?>
        <p><?= substr(htmlspecialchars($message->content(), ENT_QUOTES, 'UTF-8', false), 0, 200) . '...'; ?></p>
      </div>
    </div>
    <br>
  <?php endforeach; ?>
</div>

</section>