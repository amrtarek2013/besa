<?php
// $image_path = 'uploads' . DS . 'courses' . DS . $course['image'];
// debug(WWW_ROOT . $image_path);
// debug($course);

// debug(file_exists(WWW_ROOT . $image_path));
?>
<section class="hero-country hero-course-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <img src="<?=$course['banner_image_path']?>" alt="Default banner">
                </div>
                <div class="text-container">
                    <a class="" href="#">
                        <h4><?= trim(str_replace('?', '', $course['course_name'])) ?></h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="infromation-about-course">
                <div class="title-box">
                    <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="  Icon">
                    <h4><?= $course['university']['university_name'] ?></h4>
                </div>
                <p>
                    <?= $course['university']['short_description'] ?>
                    <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['universities.details']) . '/' . $course['university']['permalink'] ?>" class="link">Read more</a>
                </p>
                <div class="container-about-course">
                    <div class="item-course">
                        <h5 class="title-course">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/clock-icon.svg" alt="  Icon">
                            Duration
                        </h5>
                        <p class="description"><?= $course['duration'] ?> Years</p>
                    </div>
                    <div class="item-course">
                        <h5 class="title-course">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/double-arrow-icon.svg" alt="  Icon">
                            Next Intake
                        </h5>
                        <p class="description"><?= $course['intake'] ?> </p>
                    </div>
                    <div class="item-course">
                        <h5 class="title-course">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/graduation-icon.svg" alt="  Icon">
                            Course Qualification
                        </h5>
                        <p class="description"><?= !empty($course['study_level']['title']) ? $course['study_level']['title'] : '---' ?></p>
                    </div>
                    <div class="item-course">
                        <h5 class="title-course">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/price-icon.svg" alt="  Icon">
                            Fees per year
                        </h5>
                        <p class="description">$<?= $course['fees'] ?></p>
                    </div>
                </div>
                <div class="controle-container">

                    <a href="#" class="btn MainBtn addingApp" data-courseid="<?= $course['id'] ?>" data-action="<?= isset($appCourses[$course['id']]) ? 'delete' : 'add' ?>">Start your application <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow-right-white.svg" alt="arrow  Icon"> </a>
                    <div class="icon-favorite addingwish" data-courseid="<?= $course['id'] ?>" data-action="<?= isset($wishLists[$course['id']]) ? 'delete' : 'add' ?>">
                        <i id="wish-<?= $course['id'] ?>" class="<?= isset($wishLists[$course['id']]) ? 'fa-solid' : 'fa-regular' ?> fa-heart fa-2x"></i>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var current_controller = '<?= strtolower($this->request->getParam('controller')) ?>';
    var current_action = '<?= strtolower($this->request->getParam('action')) ?>';
    var busy = false;
    var isLoggedIn = '<?= isset($_SESSION['Auth']['User']) ? 1 : 0 ?>';
    // console.log(isLoggedIn);

    $(document).on('click', '.addingwish', function(e) {

        if (isLoggedIn == 0) {
            $('.modalMsg .remodal-cancel').show();
            $('.modalMsg #msgText').html('Please register first!');
            var inst = $('[data-remodal-id=modalMsg]').remodal();
            inst.open();

            $(document).on('confirmation', '.modalMsg', function(e) {

                window.location.assign('<?= Cake\Routing\Router::url('/') ?>user/register');
            });
        } else if (!busy) {
            let el = this;
            busy = true;
            let courseid = $(el).data('courseid');
            console.log(courseid);
            console.log($(el).data('action'));
            $.ajax({
                url: "/wish-lists/add/" + courseid + "/" + $(el).data('action'),
                method: "get",
                data: {},
                success: function(result) {

                    console.log(result);

                    result = JSON.parse(result);

                    if (result.status != 'deleted') {
                        $(el).data('action', 'delete');

                        $(el).attr('data-action', 'delete');
                        $(el).prop('data-action', 'delete');
                        $('i#wish-' + courseid).removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        $(el).data('action', 'add');

                        $(el).attr('data-action', 'add');
                        $(el).prop('data-action', 'add');
                        $('i#wish-' + courseid).removeClass('fa-solid').addClass('fa-regular');

                        if (current_controller == 'wishlists')
                            $('#box-result-' + courseid).hide(3000);

                    }

                    $('.modalMsg #msgText').html(result.message);
                    var inst = $('[data-remodal-id=modalMsg]').remodal();
                    inst.open();

                    busy = false;

                }
            });
        }
    });

    $(document).on('click', '.addingApp', function(e) {

        if (isLoggedIn == 0) {
            $('.modalMsg .remodal-cancel').show();
            $('.modalMsg #msgText').html('To proceed with your course application,    kindly register an account first');
            var inst = $('[data-remodal-id=modalMsg]').remodal();
            inst.open();

            $(document).on('confirmation', '.modalMsg', function(e) {

                window.location.assign('<?= Cake\Routing\Router::url('/') ?>user/register');
            });
        } else if (!busy) {
            let el = this;
            busy = true;
            let courseid = $(el).data('courseid');
            $.ajax({
                url: "/applications/add-course-to-application/" + courseid + "/" + $(el).data('action'),
                method: "get",
                data: {},
                success: function(result) {
                    // $$(el).html(data);
                    // console.log(result);

                    result = JSON.parse(result);
                    // console.log(esult);
                    if (result.status != 'deleted') {
                        $(el).data('action', 'delete');

                        $(el).attr('data-action', 'delete');
                        $(el).prop('data-action', 'delete');
                        $('img#app-' + courseid).attr('src', '/img/icon/aplly-now-marked.svg');
                        $('sapn#apply-text-' + courseid).text('Remove');
                    } else {
                        $(el).data('action', 'add');

                        $(el).attr('data-action', 'add');
                        $(el).prop('data-action', 'add');
                        $('img#app-' + courseid).attr('src', '/img/icon/aplly-now-green.svg');

                        $('sapn#apply-text-' + courseid).text('Apply Now');

                        if (current_controller == 'applications')
                            $('#box-result-' + courseid).hide(3000);

                    }
                    // alert(result.message);
                    $('.modalMsg #msgText').html(result.message);
                    var inst = $('[data-remodal-id=modalMsg]').remodal();
                    inst.open();


                    busy = false;

                    $(document).on('confirmation', '.modalMsg', function(e) {

                        window.location.assign('<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['applications.index']) ?>');
                    });

                }
            });
        }
    });
</script>
<?php
/*
<section class="main-banner british-banner <?= $course['style'] ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class=" ">

                    <?php $tt = explode(' ', trim($course['course_name'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $course['course_name'] ?></h2>
                    <h4 class="title-result"><?= $course['course_name'] ?></h4>

                    <p class="education"><?= $course['university']['university_name'] ?></p>
                    <p class="address">
                        <span class="underline">
                            <a href="#">
                                <?= $course['university']['address'] ?>
                            </a>
                        </span>
                        <span class="normal">THE world university rank: <?= $course['university']['rank'] ?></span>
                    </p>
                    <div class="courses">
                        <div class="left">
                            <p>Course Qualification</p>
                            <p class="green"><?= !empty($course['service']['title']) ? $course['service']['title'] : '---' ?></p>
                        </div>
                        <div class="right">
                            <p>Total course fee</p>
                            <p class="green">USD <?= $course['fees'] ?></p>
                        </div>

                    </div>
                    <p class="relative-textP">
                        <?= $course['description'] ?>
                    </p>

                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="text">
                    <p class="descrp">

                        <?= $course['description'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <section class="youtube-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridContainerYoutube">
                    <div class="video">
                        <?php
                        $course['video'] = !empty($course['video']) ? $course['video'] : 'https://www.youtube.com/v/D0UnqGm_miAF';
                        ?>
                        <object width="767" height="432" data="<?= $course['video'] ?>" type="application/x-shockwave-flash">
                            <param name="src" value="<?= $course['video'] ?>" />
                        </object>
</div>
<div class="text">

    <?= $course['video_right_text'] ?>
</div>
</div>
</div>
</div>
</div>
</section> -->
<!-- <?php if (sizeof($courseImages) > 0) : ?>
    <section class="slider-photoGalley">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title-photoGalley">Photo Galley</h2>
                </div>
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme photoGalley-slider">
                        <?php
                        foreach ($courseImages as $courseImage) {
                        ?>
                            <div class="item">
                                <div class="image">
                                    <img src="<?= $courseImage['image_path'] ?>" alt="<?= $courseImage['title'] ?>">
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?> -->
<!-- 
<section class="tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title" style="color: #fff;">To know more about <?= $course['title'] ?>, guidelines and <br> registration, contact our office for more details.</h3>
                <div class="gridTabes">
                    <a href="#" class="btn clear-blue foundation">Course Subscription</a>
                    <a href="#" class="btn greenish-teal master">Become a Sponsor</a>

                </div>
            </div>
        </div>
    </div>
</section> -->

*/
?>