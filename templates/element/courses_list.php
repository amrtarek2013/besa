<section class="result">
    <div class=" row-result">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid-container-3col">
                        <?php

                        // print_r($courses);

                        use Cake\Routing\Router;

                        if (!empty($courses)) : ?>
                            <?php foreach ($courses as $course) :

                                if (isset($_GET['dk']))
                                    debug($course);
                            ?>
                                <div class="box-result" id="box-result-<?= $course['id'] ?>">
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
                                            <p class="green"><?= $course['study_level']['title'] ?></p>
                                        </div>
                                        <div class="right">
                                            <p>Total course fee</p>
                                            <p class="green">USD <?= number_format($course['fees'], 2) ?></p>
                                        </div>

                                    </div>
                                    <div class="icons">
                                        <div class="addingwish" data-courseid="<?= $course['id'] ?>" data-action="<?= isset($wishLists[$course['id']]) ? 'delete' : 'add' ?>">
                                            <div class="circle-icon">
                                                <img id="wish-<?= $course['id'] ?>" src="<?= WEBSITE_URL ?>img/icon/<?= isset($wishLists[$course['id']]) ? 'wish-list-marked.svg' : 'wish-list.svg' ?>" alt="">
                                            </div>
                                            <span class="green">Wish List</span>
                                        </div>

                                        <div>


                                            <a href="javascript:void(0)" class="course-details" data-courseid="<?= $course['id'] ?>">
                                                <div class="circle-icon wish-red">
                                                    <img src="<?= WEBSITE_URL ?>img/icon/more-details.svg" alt="">
                                                </div>
                                                <span class="green">More Details</span>
                                            </a>
                                        </div>

                                        <div class="addingApp" data-courseid="<?= $course['id'] ?>" data-action="<?= isset($appCourses[$course['id']]) ? 'delete' : 'add' ?>">
                                            <div class="circle-icon">
                                                <!-- <img src="<?= WEBSITE_URL ?>img/icon/aplly-now-green.svg" alt=""> -->
                                                <img id="app-<?= $course['id'] ?>" src="<?= WEBSITE_URL ?>img/icon/<?= isset($appCourses[$course['id']]) ? 'aplly-now-marked.svg' : 'aplly-now-green.svg' ?>" alt="">
                                            </div>
                                            <span class="green apply-text-<?= $course['id'] ?>"><?= isset($appCourses[$course['id']]) ? 'Remove' : 'Apply Now' ?></span>

                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>

                </div>
                <div class="col-md-12">
                    <?php if (isset($pagging)) : ?>
                        <br /><br /><br />
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->first(' << ') ?>
                                <?= $this->Paginator->prev(' < ') ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(' > ') ?>
                                <?= $this->Paginator->last(' >> ') ?>
                            </ul>
                            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="button-next-prev">
        <a href="#">
            <img src="<?= WEBSITE_URL ?>img/icon/chevron-circle-prev.svg" alt="">
        </a>
        <a href="#">
            <img src="<?= WEBSITE_URL ?>img/icon/chevron-circle-next.svg" alt="">

        </a>

    </div> -->
</section>

<div class="remodal courseDetailsModal" data-remodal-id="courseDetails">
    <button data-remodal-action="close" class="remodal-close"></button>
    <!-- <h1 id="msgTitle"></h1> -->
    <div class="box-result" id="box-result-3922">
        <h4 class="title-result" id="title-result">Course Name</h4>
        <p class="education">Lincoln</p>
        <p class="address">
            <span class="underline">
                <a href="#">
                </a>
            </span>
            <span class="normal" id="rank">THE world university rank: </span>
        </p>
        <div class="courses">
            <div class="left">
                <p>Course Qualification</p>
                <p class="green" id="degree"> Bachelor Degree</p>
            </div>
            <div class="right">
                <p>Total course fee</p>
                <p class="green" id="fees">USD 14,400.00</p>
            </div>

        </div>
    </div>
    <!-- <p id="msgText">

    </p> -->
    <br>
    <!-- <button data-remodal-action="cancel" style="display: none;" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button> -->
</div>

<script>
    var coursesDetails = <?= json_encode($coursesDetails) ?>;
    var inst = $('[data-remodal-id=courseDetails]').remodal();
    $('.course-details').on('click', function() {

        // $('.courseDetails .remodal-cancel').show();
        courseID = $(this).data('courseid');
        $('.courseDetailsModal #title-result').html(coursesDetails[courseID].course_name);

        inst.open();

    });
</script>
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

                window.location.assign('<?= Router::url('/') ?>user/register');
            });
        } else if (!busy) {
            let el = this;
            busy = true;
            let courseid = $(el).data('courseid');
            $.ajax({
                url: "/wish-lists/add/" + courseid + "/" + $(el).data('action'),
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
                        $('img#wish-' + courseid).attr('src', '/img/icon/wish-list-marked.svg');
                    } else {
                        $(el).data('action', 'add');

                        $(el).attr('data-action', 'add');
                        $(el).prop('data-action', 'add');
                        $('img#wish-' + courseid).attr('src', '/img/icon/wish-list.svg');

                        if (current_controller == 'wishlists')
                            $('#box-result-' + courseid).hide(3000);

                    }
                    // alert(result.message);

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
            $('.modalMsg #msgText').html('Ready to start your application? Need some more help? please register first');
            var inst = $('[data-remodal-id=modalMsg]').remodal();
            inst.open();

            $(document).on('confirmation', '.modalMsg', function(e) {

                window.location.assign('<?= Router::url('/') ?>user/register');
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

                        window.location.assign('<?= Router::url('/') ?>applications');
                    });

                }
            });
        }
    });
</script>