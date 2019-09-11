<?php $this->header = "Administrer les articles" ?>
<?php $this->subheader = "Articles" ?>
<?php $this->nav = <<<HTML
<a style="margin-right: 10px;" class="btn btn-success" href="index.php?p=addpost#write">Ajouter un article</a>
HTML
?>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titre</th>
                <th scope="col">Auteur</th>
                <th scope="col">Date de création</th>
                <th scope="col">Modifié</th>
                <th scope="col">Status</th>
                <th scope="col">Modifier</th>
                <th scope="col">Changer status en</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <?php foreach ($posts as $post) : ?>
            <tbody>
                <tr>
                    <th scope="row"><a href="index.php?p=post&id=<?= $this->clean($post->id()); ?>"><?= $this->clean($post->title()); ?></a></th>
                    <td><?= $this->clean($post->author()) ?></td>
                    <td><?= $this->clean($post->date()) ?></td>
                    <td><?= $this->clean($post->updated()) === "00/00/0000 à 00h00" ? "Non modifié" : $this->clean($post->updated()) ?></td>
                    <td><?= $this->replaceBoolByName($this->clean($post->status()), "post") ?></td>

                    <form class="container" action="index.php?p=editpost" method="POST">
                        <input type="hidden" name="id" value="<?= $post->id() ?>" />
                        <td><button class="btn btn-primary" type="submit">Modifier</button></td>
                    </form>

                    <?php if ($this->clean($post->status()) === "0") : ?>
                        <form class="container" action="index.php?p=unpublish" method="POST">
                            <input type="hidden" name="id" value="<?= $post->id() ?>" />
                            <td><button class="btn btn-success" type="submit">Publié</button></td>
                        </form>
                    <?php elseif ($this->clean($post->status()) === "1") : ?>
                        <form class="container" action="index.php?p=publish" method="POST">
                            <input type="hidden" name="id" value="<?= $post->id() ?>" />
                            <td><button class="btn btn-warning" type="submit">Brouillon</button></td>
                        </form>
                    <?php endif ?>

                    <form class="container" action="index.php?p=delete" method="POST">
                        <input type="hidden" name="id" value="<?= $post->id() ?>" />
                        <td><button class="btn btn-danger" type="submit">Supprimer</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
            <tbody>
    </table>
</div>

</section>