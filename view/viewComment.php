<?php $this->header = "Commentaire" ?>
<?php $this->subheader = 'Commentaire de ' . htmlspecialchars($comment->author(), ENT_QUOTES, 'UTF-8', false) ?>

<br>

  <!-- View Article -->
  <div class="container">
    <p><?= htmlspecialchars($comment->content(), ENT_QUOTES, 'UTF-8', false) ?><p>
        <input class="btn btn-primary" type="button" value="Retour" onclick="history.go(-1)">
  </div>

  <br>