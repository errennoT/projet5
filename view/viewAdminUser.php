<?php $this->header = "Administrer les utilisateurs" ?>
<?php $this->subheader = "Utilisateurs" ?>

<div class="container">
    <div class="table-responsive">
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

                        <form action="index.php?u=edituser" method="POST">
                            <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                            <td><button class="btn btn-primary" type="submit">Modifier</button></td>
                        </form>

                        <?php if ($this->clean($user->status()) === "0") : ?>
                            <form action="index.php?u=unban" method="POST">
                                <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                                <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                                <td><button class="btn btn-success" type="submit">Débannir</button></td>
                            </form>
                        <?php elseif ($this->clean($user->status()) === "1") : ?>
                            <form action="index.php?u=ban" method="POST">
                                <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                                <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                                <td><button class="btn btn-warning" type="submit">Bannir</button></td>
                            </form>
                        <?php endif ?></td>

                        <form action="index.php?u=delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer l\'utilisateur ?')">
                            <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                            <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                            <td><button class="btn btn-danger" type="submit">Supprimer</button></td>
                        </form>

                        <?php if ($this->clean($user->admin()) === "0") : ?>
                            <form action="index.php?u=newadmin" method="POST">
                                <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                                <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                                <td><button class="btn btn-success" type="submit">Administrateur</button></td>
                            </form>
                        <?php elseif ($this->clean($user->admin()) === "1") : ?>
                            <form action="index.php?u=deleteadmin" method="POST">
                                <input type="hidden" name="<?= \Volnix\CSRF\CSRF::TOKEN_NAME ?>" value="<?= \Volnix\CSRF\CSRF::getToken() ?>" />
                                <input type="hidden" name="id" value="<?= $this->clean($user->id()) ?>" />
                                <td><button class="btn btn-warning" type="submit">Utilisateur</button></td>
                            </form>
                        <?php endif ?>
                    </tr>
                <tbody>
                <?php endforeach; ?>
        </table>
    </div>
</div>

</section>