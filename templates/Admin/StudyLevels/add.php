<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Study Levels') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Study Levels') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . '  Study Level') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($studyLevel, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php


                            echo $this->AdminForm->control('title', ['type' => 'text', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('main_study_level_id', [
                                'placeholder' => 'Main Level of study', 'type' => 'select', 'empty' => 'Select Main Level of study*',
                                'options' => $mainStudyLevels, 'label' => 'Main Level of study*', 'required' => true,
                            ]);
                            // echo $this->AdminForm->control('text', ['type' => 'textarea', 'class' => 'editor']);

                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            echo $this->AdminForm->control('display_order', []);
                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'studyLevel_' . $id, $mainAdminToken);
                            // echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$studyLevel->isNew()) {

                                echo $this->element('save_as_new', array($studyLevel));
                            }
                            ?>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>

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