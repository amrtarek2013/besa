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
                    <h1><?= __('Fair Events') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Fair Events') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Fair Event') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($fairEvent, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php


                            echo $this->AdminForm->control('event_id', array('options' => $eventsList, 'empty' => 'Choose Event', 'class' => 'INPUT required', 'label' => 'Event'));
                            echo $this->AdminForm->control('title', ['type' => 'text']);
                            echo $this->AdminForm->control('locations', ['label' => 'Where', 'type' => 'text']);
                            echo $this->AdminForm->control('dates', ['label' => 'When', 'type' => 'textarea', 'class' => 'editor']);

                            echo $this->AdminForm->control('universities', array('options' => $universitiesList, 'multiple' => 'multiple', 'class' => 'INPUT select-multiple', 'label' => 'Universities'));
                            echo $this->AdminForm->control('countries', array('options' => $countriesList, 'multiple' => 'multiple', 'class' => 'INPUT select-multiple', 'label' => 'Countries'));


                            // echo $this->AdminForm->control('center_text', ['type' => 'textarea', 'class' => 'editor']);

                            // echo $this->AdminForm->control('style', array('options' => $centerBoxStyle, 'empty' => 'Choose Center Box Style', 'id' => 'font_color', 'class' => 'INPUT', 'label' => 'Center Box Style'));
                            // echo $this->AdminForm->control('text', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('video_right_text', ['type' => 'textarea', 'class' => 'editor']);

                            // echo $this->AdminForm->control('right_text', ['type' => 'textarea', 'class' => 'editor']);

                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);

                            $colors = array(
                                '#005BAA' => 'Blue',
                                '#ED1C24' => 'Red',
                                '#58585B' => 'Gray',
                                '#ffffff' => 'White',
                                '#fff000' => 'Yellow',
                                '#D3D3D3' => 'Light grey',
                                '#30db30' => 'Light green',
                                '#000000' => 'Black',
                                '#ffa500' => 'orange',
                            );

                            echo $this->AdminForm->control('font_color', array('options' => $colors, 'empty' => 'Choose Font Color', 'id' => 'font_color', 'class' => 'INPUT', "style" => "background-color:black;color:" . $fairEvent->font_color . " !important; ", 'label' => 'Font Color'));

                            echo $this->AdminForm->control('background_color', array('options' => $colors, 'empty' => 'Choose Background Color', 'id' => 'background_color', 'class' => 'INPUT', "style" => "color:black;background-color:" . $fairEvent->background_color . " !important; ", 'label' => 'Background Color'));


                            ?>
                            <!-- <select name="st" -->
                            <?php

                            /*

                            echo $this->AdminForm->control('main_image', ['label' => 'Main Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $fairEvent,
                                'field' => 'main_image',
                                'info' => [
                                    'width' => $uploadSettings['main_image']['width'],
                                    'height' => $uploadSettings['main_image']['height'],
                                    'path' => $uploadSettings['main_image']['path']

                                ],
                            ])]);

                            echo $this->AdminForm->control('image', ['label' => 'Image One', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $fairEvent,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);
                            */
                            ?>
                            <?php

                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$fairEvent->isNew()) {

                                echo $this->element('save_as_new', array($fairEvent));
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
        $('.select-single').select2({});
        $('.select-multiple').select2({});
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