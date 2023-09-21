<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Events') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Events') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Event') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($event, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php

                            // echo $this->AdminForm->control('type', ['type' => 'select', 'option' => $types, 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('title', ['type' => 'text']);
                            echo $this->AdminForm->control('sub_title', ['type' => 'text']);

                            ?>
                            <!-- <select name="st" -->
                            <?php


                            echo $this->AdminForm->control('icon', ['label' => 'Icon', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $event,
                                'field' => 'icon',
                                'info' => [
                                    'width' => $uploadSettings['icon']['width'],
                                    'height' => $uploadSettings['icon']['height'],
                                    'path' => $uploadSettings['icon']['path']

                                ],
                            ])]);

                            echo $this->AdminForm->control('main_image', ['label' => 'Main Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $event,
                                'field' => 'main_image',
                                'info' => [
                                    'width' => $uploadSettings['main_image']['width'],
                                    'height' => $uploadSettings['main_image']['height'],
                                    'path' => $uploadSettings['main_image']['path']

                                ],
                            ])]);

                            echo $this->AdminForm->control('image', ['label' => 'Image One', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $event,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);
                            echo $this->AdminForm->control('image2', ['label' => 'Image Two', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $event,
                                'field' => 'image2',
                                'info' => [
                                    'width' => $uploadSettings['image2']['width'],
                                    'height' => $uploadSettings['image2']['height'],
                                    'path' => $uploadSettings['image2']['path']

                                ],
                            ])]);

                            // echo $this->AdminForm->control('banner_image', ['label' => 'Banner Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $event,
                            //     'field' => 'banner_image',
                            //     'info' => [
                            //         'width' => $uploadSettings['banner_image']['width'],
                            //         'height' => $uploadSettings['banner_image']['height'],
                            //         'path' => $uploadSettings['banner_image']['path']

                            //     ],
                            // ])]);



                            // echo $this->AdminForm->control('mobile_image', ['label' => 'PopupImage', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $event,
                            //     'field' => 'mobile_image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);
                            // echo $this->AdminForm->control('image', ['type' => 'file']);
                            // echo $this->AdminForm->control('video', ['Video Url','type' => 'text']);



                            // echo $this->AdminForm->control('video_thumb', ['label' => 'Video Thumb', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $event,
                            //     'field' => 'video_thumb',
                            //     'info' => [
                            //         'width' => $uploadSettings['video_thumb']['width'],
                            //         'height' => $uploadSettings['video_thumb']['height'],
                            //         'path' => $uploadSettings['video_thumb']['path']

                            //     ],
                            // ])]);
                            ?>
                            <!-- <div class="related-text">Image Size 768px X 170px</div> -->

                            <?php
                            if (!empty($event) && $event->id == 7) {
                                echo $this->AdminForm->control('left_text', ['title' => 'Upcoming Top Section', 'type' => 'textarea', 'class' => 'editor']);
                            }
                            echo $this->AdminForm->control('center_text', ['type' => 'textarea', 'class' => 'editor']);

                            echo $this->AdminForm->control('style', array('options' => $centerBoxStyle, 'empty' => 'Choose Center Box Style', 'id' => 'font_color', 'class' => 'INPUT', 'label' => 'Center Box Style'));
                            echo $this->AdminForm->control('text', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('video_right_text', ['type' => 'textarea', 'class' => 'editor']);

                            // echo $this->AdminForm->control('right_text', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('html2', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('keywords',['type'=>'text']);
                            // echo $this->AdminForm->control('active', ['type' => 'checkbox']);

                            // echo $this->AdminForm->control('show_on_home', ['type' => 'checkbox']);

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

                            echo $this->AdminForm->control('font_color', array('options' => $colors, 'empty' => 'Choose Font Color', 'id' => 'font_color', 'class' => 'INPUT', "style" => "background-color:black;color:" . $event->font_color . " !important; ", 'label' => 'Font Color'));

                            echo $this->AdminForm->control('background_color', array('options' => $colors, 'empty' => 'Choose Background Color', 'id' => 'background_color', 'class' => 'INPUT', "style" => "color:black;background-color:" . $event->background_color . " !important; ", 'label' => 'Background Color'));

                            // echo $this->AdminForm->control('is_full_height', ['type' => 'checkbox']);
                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'event_' . $id, $mainAdminToken);

                            // echo $this->AdminForm->enableAjaxFileUpload(['video'], ['video'], true);

                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$event->isNew()) {

                                echo $this->element('save_as_new', array($event));
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


    $('#background_color').change(function() {
        $('#background_color').css('background-color', $(this).val());
        // if ($('#font_color').val() == "#ffffff") {
        $('#background_color').css('color', $('#font_color').val());
        // } else {
        //     $('#background_color').css('color', "white");
        // }
    });
    $('#font_color').change(function() {
        $('#background_color').css('color', $(this).val());

        $('#font_color').css('background-color', $('#font_color').val());
        if ($(this).val() == "#ffffff") {
            $('#font_color').css('color', "black");
        } else {
            $('#font_color').css('color', "white");
        }
    });
</script>