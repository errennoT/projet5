<?php $this->header = "Commentaire" ?>
<?php $this->subheader = 'Commentaire de ' . $this->clean($comment->author()) ?>

<br>

  <!-- View Article -->
  <div class="container">
    <p><?= $this->clean($comment->content()) ?><p>
        <input class="btn btn-primary" type="button" value="Retour" onclick="history.go(-1)">
  </div>

  <br>