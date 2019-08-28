<?php $this->header = "Administrer les commentaires" ?>

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
        <a style="margin-right: 10px;" class="btn btn-success" href="index.php?c=admincommentfilter#list">Afficher que les commentaires en attentes</a>
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