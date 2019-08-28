<?php $this->header = "Administrer les articles" ?>

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
            <a style="margin-right: 10px;" class="btn btn-success" href="index.php?p=addpost#write">Ajouter un article</a>
            <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?u=adminuser">Utilisateurs</a>
            <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?p=adminpost">Articles</a>
            <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?c=admincommentfilter#list">Commentaires</a>
            <a style="margin-right: 10px;" class="btn btn-primary" href="index.php?m=listmessage#list">Messages</a>
        </div>
    </div>

    <br>

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
                        <th scope="row"><a href="index.php?p=post&id=<?= $this->clean($post->id());?>"><?= $this->clean($post->title()); ?></a></th>
                        <td><?= $this->clean($post->author()) ?></td>
                        <td><?= $this->clean($post->date()) ?></td>
                        <td><?= $this->clean($post->updated()) === "00/00/0000 à 00h00" ? "Non modifié" : $this->clean($post->updated()) ?></td>
                        <td><?= $this->replaceBoolByName($this->clean($post->status()), "post") ?></td>
                        <td><?= "<a class='btn btn-primary' href='index.php?p=editpost&id=" . $this->clean($post->id()) . "'>Modifier</a>"; ?></td>
                        <td><?php if($this->clean($post->status()) === "0") { echo "<a class='btn btn-success' href='index.php?p=unpublish&id=" . $this->clean($post->id()) . "'>Publié</a>"; } elseif ($this->clean($post->status()) === "1") { echo "<a class='btn btn-warning' href='index.php?p=publish&id=" . $this->clean($post->id()) . "'>Brouillon</a>";} ?></td>
                        <td><?= "<a class='btn btn-danger' href='index.php?p=delete&id=" . $this->clean($post->id()) . "'>Supprimer</a>"; ?></td>
                    </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
    </div>


</section>