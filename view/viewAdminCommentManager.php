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
                    <th scope="row"><a href="index.php?c=comment&id=<?= $this->clean($comment->id());?>"><?= substr($this->clean($comment->content()), 0, 20)?></a></th>
                        <td><?= $this->clean($comment->author()) ?></td>
                        <td><?= $this->clean($comment->date()) ?></td>
                        <td><?= $this->replaceBoolByName($this->clean($comment->status()), "comment") ?></td>
                        <td><?php if($this->clean($comment->status()) === "0") { echo "<a class='btn btn-success' href='index.php?c=unvalidate&id=" . $this->clean($comment->id()) . "&status=" . $this->clean($comment->status()) . "'>Validé</a>"; } elseif ($this->clean($comment->status()) === "1") { echo "<a class='btn btn-warning' href='index.php?c=validate&id=" . $this->clean($comment->id()) . "&status=" . $this->clean($comment->status()) . "'>En attente</a>";} ?></td>
                        <td><?= "<a class='btn btn-danger' href='index.php?c=delete&id=" . $this->clean($comment->id()) . "&status=" . $this->clean($comment->status()) . "'>Supprimer</a>"; ?></td>
                    </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
    </div>


</section>