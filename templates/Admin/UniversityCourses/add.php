<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('University Course') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('University Course/') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' University Course') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($universityCourse, ['type' => 'file', 'id' => 'editForm']); ?>
                        <div class="card-body">
                            <?php
                            // echo $this->AdminForm->create($universityCourse, ['type' => 'file', 'id' => $action . 'Form']);


                            // echo $this->AdminForm->control('course_id', ['label' => 'Course', 'type' => 'select', 'empty' => 'Select Course', 'options' => $courses, 'class' => 'INPUT']);
                            // echo $this->AdminForm->control('code', ['type' => 'text', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('course_name', ['label' => 'University Course Name', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('duration', ['class' => 'INPUT required']);
                            echo $this->AdminForm->control('intake', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('fees', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('description', ['type' => 'textarea']);

                            // echo $this->AdminForm->control('service_id', ['label' => 'Service', 'type' => 'select', 'empty' => 'Select Category/Service', 'options' => $services, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('country_id', ['label' => 'Country', 'type' => 'select', 'empty' => 'Select Country', 'options' => $countries, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('university_id', ['label' => 'University', 'type' => 'select', 'empty' => 'Select Univesity', 'options' => $universities, 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('subject_area_id', ['label' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area', 'options' => $subjectAreas, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('study_level_id', ['label' => 'Study Level', 'type' => 'select', 'empty' => 'Select Study Level', 'options' => $studyLevels, 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('major_id', ['label' => 'Major', 'type' => 'select', 'empty' => 'Select Major', 'options' => $majors, 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('top_text', ['type' => 'textarea', 'class' => 'editor']);

                            // echo $this->AdminForm->control('why_text', ['type' => 'textarea', 'class' => 'editor']);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('display_order', ['class' => 'INPUT required']);

                            // echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $universityCourse,
                            //     'field' => 'image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);


                            echo $this->AdminForm->control('banner_image', ['label' => 'Banner Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $universityCourse,
                                'field' => 'banner_image',
                                'info' => [
                                    'width' => $uploadSettings['banner_image']['width'],
                                    'height' => $uploadSettings['banner_image']['height'],
                                    'path' => $uploadSettings['banner_image']['path']

                                ],
                            ])]);
                            ?>

                            <?php

                            // echo $this->AdminForm->control('is_full_height', ['type' => 'checkbox']);
                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'universityCourse_' . $id, $mainAdminToken);
                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$universityCourse->isNew()) {

                                echo $this->element('save_as_new', array($universityCourse));
                            }
                            ?>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<style type="text/css">
    .related-text {
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        // Attach the change event handler to the select element
        $('#course-id').change(function() {
            // Get the selected option's label
            var selectedLabel = $(this).find('option:selected').text();

            // Update the paragraph element with the selected label
            $('#course-name').val(selectedLabel);
        });
    });
    $('.related-text').each(function(i, obj) {
        var current_text = $(obj).text();
        $(obj).prev().find("label").after("<br><label>" + current_text + "</label");
    });
</script>