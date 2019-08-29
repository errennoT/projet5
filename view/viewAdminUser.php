<?php $this->header = "Administrer les utilisateurs" ?>
<?php $this->subheader = "Utilisateurs" ?>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Etat compte</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Bannir</th>
                    <th scope="col">Supprimer</th>
                    <th scope="col">Définir comme</th>
                </tr>
            </thead>
            <?php foreach ($users as $user) : ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $this->clean($user->login()); ?></a></th>
                        <td><?= $this->clean($user->email()); ?></td>
                        <td><?= $this->replaceBoolByName($this->clean($user->status()), "user"); ?></td>
                        <td><?= $this->replaceBoolByName($this->clean($user->admin()), "admin"); ?></td>
                        <td><?= "<a class='btn btn-primary' href='index.php?u=edituser&id=" . $this->clean($user->id()) . "'>Modifier</a>"; ?></td>
                        <td><?php if($this->clean($user->status()) === "0") { echo "<a class='btn btn-success' href='index.php?u=unban&id=" . $this->clean($user->id()) . "'>Débannir</a>"; } elseif ($this->clean($user->status()) === "1") { echo "<a class='btn btn-warning' href='index.php?u=ban&id=" . $this->clean($user->id()) . "'>Bannir</a>";} ?></td>
                        <td><?= "<a class='btn btn-danger' href='index.php?u=delete&id=" . $this->clean($user->id()) . "'>Supprimer</a>"; ?></td>
                        <td><?php if($this->clean($user->admin()) === "0") { echo "<a class='btn btn-success' href='index.php?u=newadmin&id=" . $this->clean($user->id()) . "'>Administrateur</a>"; } elseif ($this->clean($user->admin()) === "1") { echo "<a class='btn btn-warning' href='index.php?u=deleteadmin&id=" . $this->clean($user->id()) . "'>Utilisateur</a>";} ?></td>
                    </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
    </div>

</section>