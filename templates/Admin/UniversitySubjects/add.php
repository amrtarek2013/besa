<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<style type="text/css">
    .related-text {
        display: none;
    }

    .select2-container {
        height: calc(2.25rem + 2px);
        padding: 0;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: none !important;
    }

    .select2-container--default .select2-selection--multiple {
        background-color: transparent !important;
        border: none !important;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __($mainUniversityTitle . ' - Subject Area') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __($mainUniversityTitle . ' - Subject Area') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' ' . $mainUniversityTitle . ' - Subject Area') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($universitySubject, ['id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php


                            echo $this->AdminForm->control('university_id', array('type' => 'hidden', 'value' => $university_id, 'class' => 'INPUT required'));
                            echo $this->AdminForm->control('subject_area_id', array('options' => $subjectAreas, 'empty' => 'Choose Subject Area', 'class' => 'INPUT required select-single', 'label' => 'Subject Area'));
                            echo $this->AdminForm->control('rank', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('apply_rank', ['type' => 'number', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$universitySubject->isNew()) {

                                echo $this->element('save_as_new', array($universitySubject));
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


<?php

echo $this->Html->css(array('select2'));
echo $this->Html->script(array('select2'));
?>
<script>
    $(document).ready(function() {
        $('.select-single').select2({
            placeholder: "Select Item",
            allowClear: true
        });
        $('.select-multiple').select2({
            placeholder: "Select Items",
            allowClear: true
        });
    });
</script>
<script type="text/javascript">
    // $('.related-text').each(function(i, obj) {
    //     var current_text = $(obj).text();
    //     $(obj).prev().find("label").after("<br><label>" + current_text + "</label");
    // });


    // $('#background_color').change(function() {
    //     $('#background_color').css('background-color', $(this).val());
    //     // if ($('#font_color').val() == "#ffffff") {
    //     $('#background_color').css('color', $('#font_color').val());
    //     // } else {
    //     //     $('#background_color').css('color', "white");
    //     // }
    // });
    // $('#font_color').change(function() {
    //     $('#background_color').css('color', $(this).val());

    //     $('#font_color').css('background-color', $('#font_color').val());
    //     if ($(this).val() == "#ffffff") {
    //         $('#font_color').css('color', "black");
    //     } else {
    //         $('#font_color').css('color', "white");
    //     }
    // });
</script>