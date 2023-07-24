<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Courses') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Courses') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Course') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($course, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php
                            


                            echo $this->AdminForm->control('course_name', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('code', ['type' => 'text', 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('duration', ['class' => 'INPUT required']);
                            // echo $this->AdminForm->control('intake', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('fees', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('description', ['type' => 'textarea']);

                            echo $this->AdminForm->control('country_id', ['label' => 'Country', 'type' => 'select', 'empty' => 'Select Country', 'options' => $countries, 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('university_id', ['label' => 'University', 'type' => 'select', 'empty' => 'Select Univesity', 'options' => $universities, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('subject_area_id', ['label' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area', 'options' => $subjectAreas, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('study_level_id', ['label' => 'Study Level', 'type' => 'select', 'empty' => 'Select Study Level', 'options' => $studyLevels, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('service_id', ['label' => 'Service', 'type' => 'select', 'empty' => 'Select Category/Service', 'options' => $services, 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('top_text', ['type' => 'textarea', 'class' => 'editor']);

                            // echo $this->AdminForm->control('why_text', ['type' => 'textarea', 'class' => 'editor']);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('display_order', ['class' => 'INPUT required']);

                            // echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $course,
                            //     'field' => 'image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);


                            // echo $this->AdminForm->control('banner_image', ['label' => 'Banner Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $course,
                            //     'field' => 'banner_image',
                            //     'info' => [
                            //         'width' => $uploadSettings['banner_image']['width'],
                            //         'height' => $uploadSettings['banner_image']['height'],
                            //         'path' => $uploadSettings['banner_image']['path']

                            //     ],
                            // ])]);
                            ?>

                            <?php

                            // echo $this->AdminForm->control('is_full_height', ['type' => 'checkbox']);
                            // echo $this->AdminForm->enableAjaxUploads($id, 'course_' . $id, $mainAdminToken);
                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$course->isNew()) {

                                echo $this->element('save_as_new', array($course));
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
    $('.related-text').each(function(i, obj) {
        var current_text = $(obj).text();
        $(obj).prev().find("label").after("<br><label>" + current_text + "</label");
    });
</script>