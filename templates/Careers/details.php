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

<div class="title-header-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title" style="font-size: 35px; text-align:center; color:var(--bs-white)"><?= $career['title'] ?> <h1>
                <h3 class="title" style="font-size: 25px; text-align:center; color:var(--bs-white)"> <?= $career['country'] ?> - <?= $career['state'] ?></h3>

            </div>
        </div>
    </div>
</div>


<?= $career['text'] ?>
<?= $career['requirments'] ?>

<section class="tabes british-tabes">
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