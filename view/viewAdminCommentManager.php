<?php $this->header = "Administrer les commentaires" ?>
<?php $this->subheader = "Commentaires en attentes" ?>
<?php $this->nav = <<<HTML
<a style="margin-right: 10px;" class="btn btn-success" href="index.php?c=admincomment#list">Afficher tous les commentaires</a>
HTML
?>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Commentaire</th>
                <th scope="col">Article</th>
                <th scope="col">Auteur</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Changer status en</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <?php foreach ($comments as $comment) : ?>
            <tbody>
                <tr>
                    <th scope="row"><a href="index.php?c=comment&id=<?= $this->clean($comment->id()); ?>"><?= substr($this->clean($comment->content()), 0, 20) ?></a></th>
                    <td><a href="index.php?p=post&id=<?= $this->clean($comment->postId()); ?>">Lien vers l'article</a></td>
                    <td><?= $this->clean($comment->author()) ?></td>
                    <td><?= $this->clean($comment->date()) ?></td>
                    <td><?= $this->replaceBoolByName($this->clean($comment->status()), "comment") ?></td>

                    <?php if ($this->clean($comment->status()) === "0") : ?>
                        <form class="container" action="index.php?c=unvalidate" method="POST">
                            <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                            <input type="hidden" name="id" value="<?= $this->clean($comment->id()) ?>" />
                            <td><button class="btn btn-success" type="submit">Validé</button></td>
                        </form>
                    <?php elseif ($this->clean($comment->status()) === "1") : ?>
                        <form class="container" action="index.php?c=validate" method="POST">
                            <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                            <input type="hidden" name="id" value="<?= $this->clean($comment->id()) ?>" />
                            <td><button class="btn btn-warning" type="submit">En attente</button></td>
                        </form>
                    <?php endif ?>

                    <form class="container" action="index.php?c=delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer le commentaire ?')">
                        <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                        <input type="hidden" name="id" value="<?= $this->clean($comment->id()) ?>" />
                        <td><button class="btn btn-danger" type="submit">Supprimer</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
            <tbody>
    </table>
</div>


</section>