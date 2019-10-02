<?php $this->header = "Administrer les messages" ?>
<?php $this->subheader = "Messages" ?>

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