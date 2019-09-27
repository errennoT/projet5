<?php $this->header = "Administrer les commentaires" ?>
<?php $this->subheader = "Tous les commentaires" ?>
<?php $this->nav = <<<HTML
<a style="margin-right: 10px;" class="btn btn-success" href="index.php?c=admincommentfilter#list">Afficher que les commentaires en attentes</a>
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
                    <th scope="row"><a href="index.php?c=comment&id=<?= htmlentities($comment->id()); ?>"><?= $this->cut($comment->content()) ?></a></th>
                    <td><a href="index.php?p=post&id=<?= htmlentities($comment->postId()); ?>">Lien vers l'article</a></td>
                    <td><?= htmlspecialchars($comment->author(), ENT_QUOTES, 'UTF-8', false) ?></td>
                    <td><?= htmlspecialchars($comment->date(), ENT_QUOTES, 'UTF-8', false) ?></td>
                    <td><?= $this->replaceBoolByName(htmlspecialchars($comment->status(), ENT_QUOTES, 'UTF-8', false), "comment") ?></td>

                    <?php if (htmlspecialchars($comment->status(), ENT_QUOTES, 'UTF-8', false) === "0") : ?>
                        <form class="container" action="index.php?c=unvalidate" method="POST">
                            <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                            <input type="hidden" name="id" value="<?= htmlentities($comment->id()) ?>" />
                            <td><button class="btn btn-success" type="submit">Validé</button></td>
                        </form>
                    <?php elseif (htmlentities($comment->status()) === "1") : ?>
                        <form class="container" action="index.php?c=validate" method="POST">
                            <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                            <input type="hidden" name="id" value="<?= htmlentities($comment->id()) ?>" />
                            <td><button class="btn btn-warning" type="submit">En attente</button></td>
                        </form>
                    <?php endif ?>

                    <form class="container" action="index.php?c=delete" method="POST" onsubmit="return confirm('Etes vous sur de vouloir supprimer le commentaire ?')">
                        <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                        <input type="hidden" name="id" value="<?= htmlentities($comment->id()) ?>" />
                        <td><button class="btn btn-danger" type="submit">Supprimer</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
            <tbody>
    </table>
</div>


</section>