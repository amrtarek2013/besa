<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('University Courses List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('University Courses') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <?php
                        $session = $this->getRequest()->getSession();
                        echo $this->List->filter_form($universityCourses, $filters, [], [], $parameters, $session) ?>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('University Courses List') ?></h3>
                            <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= ADMIN_LINK ?>/university-courses/add">
                                <?= __('Add new') ?>
                            </a>
                        </div>
                        <?php

                        $fields = [
                            'basicModel' => 'universityCourses',
                            'id' => [],
                            // 'course_name' => [],
                            'course.course_name' => ['title' => 'Course'], //, 'format' => 'get_from_array', 'options' => ['items_list' => $courses]],
                            // 'code' => [],
                            'country.country_name' => ['title' => 'Country'], //'format' => 'get_from_array', 'options' => ['items_list' => $countries]],
                            'university.university_name' => ['title' => 'University'], //, 'format' => 'get_from_array', 'options' => ['items_list' => $universities]],
                            'university_title' => [],
                            // 'service_id' => ['title' => 'Service/Degree', 'format' => 'get_from_array', 'options' => ['items_list' => $services]],
                            'study_level.title' => ['title' => 'Study Level'], //, 'format' => 'get_from_array', 'options' => ['items_list' => $studyLevels]],
                            'subject_area.title' => ['title' => 'Subject Area'], //, 'format' => 'get_from_array', 'options' => ['items_list' => $subjectAreas]],
                            // 'major_id' => ['title' => 'Major', 'format' => 'get_from_array', 'options' => ['items_list' => $majors]],

                            // 'permalink' => [],
                            // 'dealerships'=>[],
                            'active' => ['format' => 'bool'],
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );


                        $actions = [
                            // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                            'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                            'delete' => $this->Html->link(

                                __('Delete'),
                                ['action' => 'delete', '%id%'],
                                [
                                    'confirm' => 'Are you sure you wish to delete this?',
                                    'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                                ]
                            )
                        ];


                        echo $this->List->adminIndex($fields, $universityCourses, $actions, false, $multi_select_actions, $parameters);

                        $url_query = [];
                        if (isset($parameters['?'])) {
                            $url_query = $parameters['?'];
                        }

                        ?>

                        <h3 class="more_option">
                            <a onclick="document.getElementById('sms_sender').style.display = 'none'; document.getElementById('email_sender').style.display = 'none'; document.getElementById('exporter').style.display = 'block';document.getElementById('unsubscriber').style.display = 'none';" href="javascript:void(0)">
                                Export to csv</a><a></a>
                        </h3>
                        <div style="display: block;" id="exporter" class="more_option_box">
                            <form action="<?php echo Cake\Routing\Router::url(array('controller' => "university-courses", 'action' => 'export', '?' => $url_query)) ?>" method="get">
                                <!-- Delimited:
                                <select name="delimited">
                                    <option value="comma">Comma ( , )</option>
                                    <option value="tab">Tab</option>
                                    <option value="semi">Semicolon(;)</option>
                                </select> -->
                                <?php

                                // dd($url_query);
                                foreach ($url_query as $key => $value) :
                                ?>
                                    <input type="hidden" value="<?php echo $value ?>" name="<?php echo $key ?>">

                                <?php endforeach; ?>
                                <input value="Dump CSV File" type="submit">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
echo $this->Html->css(array('select2'));
echo $this->Html->script(array('select2'));
?>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/js-yaml/3.13.1/js-yaml.min.js"></script> -->

<script>
    $("#subject-area-id, #country-id, #university-id").select2({
        // allowClear: true,

        // minimumResultsForSearch: -1,
        // width: 600
    });
    //$('#mySelect2').val(null).trigger('change');
</script>