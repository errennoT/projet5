<?php $this->header = "Répondre au message" ?>
<?php $this->subheader = 'Message de ' . $this->clean($message->surname()) . ' ' . $this->clean($message->name()) ?>

<br>

<!-- View Article -->
<div class="container">
  <h4>Message du <?= $this->clean($message->date()) ?></h4>
  Ecrit par : <?= $this->clean($message->surname()) ?>
  <p>@ mail : <?= $this->clean($message->email()) ?></p>
</div>

<br>

<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 mx-auto">
      <p><?= nl2br($this->clean($message->content())); ?></p>
    </div>
  </div>
  <hr>
</div>

<br><br>

<form class="container" action="index.php?m=answermessage&id=<?= $message->id() ?>" method="POST">
  <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
  <div class="form-group">
    <h5>Répondre à <?= $this->clean($message->surname()) ?></h5>
    <input type="text" class="form-control" name="email" value="<?= $this->clean($message->email()) ?>" readonly>
  </div>
  <div class="form-group">
    <textarea type="text" class="form-control" name="contentMessage" placeholder="Votre réponse..." rows="5" required></textarea>
  </div>
  <button class="btn btn-danger" type="submit">Répondre</button>
  <a class="btn btn-primary" href="index.php?m=listmessage">Retour</a>
</form>