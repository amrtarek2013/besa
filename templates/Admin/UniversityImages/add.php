<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __($universityTitle . ' Images') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __($universityTitle . ' Images') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action'))  . ' ' . $universityTitle . ' Image') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($universityImage, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php

                            echo $this->AdminForm->control('university_id', ['label' => 'University', 'type' => 'select', 'option' => $universities, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('title', ['type' => 'text']);

                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $universityImage,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);

                            // echo $this->AdminForm->control('description', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('display_order', []);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);


                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'universityImage_' . $id, $mainAdminToken);
                            // echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            // if (!$universityImage->isNew()) {

                            //     echo $this->element('save_as_new', array($universityImage));
                            // }
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
    // $('.related-text').each(function(i, obj) {
    //     var current_text = $(obj).text();
    //     $(obj).prev().find("label").after("<br><label>" + current_text + "</label");
    // });


    // $('#background_colour').change(function() {
    //     $('#background_colour').css('background-color', $(this).val());
    //     if ($(this).val() == "#ffffff") {
    //         $('#background_colour').css('color', "black");
    //     } else {
    //         $('#background_colour').css('color', "white");
    //     }
    // });
</script>