<section class="main-banner  inner-serv unitedKingdom-banner">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <img src="<?= $career['image_path'] ?>" alt="">
            </div>
            <!-- <div class="col-md-12" style="padding:30px">
                <h1 class="title" style="font-size: 35px;"><?= $career['title'] ?></h1>
            </div> -->
        </div>
    </div>

</section>
<section class="tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title" style="font-size: 35px;"><?= $career['title'] ?></h1>

                <div class="gridTabes">
                    <a class="btn clear-blue foundation" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['pages.careerapply'] . '/' .  $career['id'] . '/' . $career['title']) ?>">Apply Now</a>

                    <a class="btn gold-tips master" href="#newsletter">Newsletter Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $career['text'] ?>
<?= $career['requirments'] ?>