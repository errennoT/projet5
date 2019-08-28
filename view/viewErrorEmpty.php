<?php $this->header = "Formulaire mal rempli" ?>

<!-- Page blog header -->
<section class="page-section">
    <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Un problème est survenu</h2>

    <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
    </div>

    <div class="container alert alert-danger">
        Le formulaire doit être rempli entièrement.
    </div>
    <div class="container">
        <input class="btn btn-primary" type="button" value="Retour" onclick="history.go(-1)">
    </div>

</section>