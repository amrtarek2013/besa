<style>
    p,
    h3,
    h4,
    h5,
    span {
        text-align: justify;
        line-height: 32px;
    }
</style>
<?php

if (false) {
?>
    <section class="main-banner  inner-serv unitedKingdom-banner">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <img src="<?= $career['image_path'] ?>" alt="" style="width: 100%;">
                </div>
                <!-- <div class="col-md-12" style="padding:30px">
                <h1 class="title" style="font-size: 35px;">Location<?= $career['title'] ?></h1>
            </div> -->
            </div>
        </div>

    </section>

    <div class="title-header-blue" style="padding-bottom:0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="font-size: 35px; text-align:center; color:var(--bs-white)"><?= $career['title'] ?> <h1>
                            <h3 class="title" style="font-size: 25px; text-align:center; color:var(--bs-white)"> <?= $career['country'] ?> - <?= $career['state'] ?></h3>
                            <?php

                            if (!isset($show_pdf)) {
                            ?>
                                <h3 style="text-align: center;">
                                    <a href="<?= Cake\Routing\Router::Url('/career-details/' . $permalink . '/' . $id . '/1') ?>" target="_blank" style="color: var(--bs-main);"><i class="fa-solid fa-file-pdf"></i> View Job Full Requirments</a>
                                </h3>
                            <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php
}
if (isset($show_pdf)) {
?>
    <embed src="<?= $career['file_path'] ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="800px" />
    
    <object data="<?= $career['file_path'] ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="800px"></object>

    <iframe src="<?= $career['file_path'] ?>" width="800" height="500"></iframe>

<?php } else { ?>
    <?= $career['text'] ?>
    <?= $career['requirments'] ?>
<?php } ?>


<section class=" tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="gridTabes">
                    <a class="btn clear-blue foundation" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['pages.careerapply'] . '/' .  $career['id'] . '/' . $career['title']) ?>">Apply Now</a>

                </div>
            </div>
        </div>
    </div>
</section>