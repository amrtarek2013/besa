<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Sliders') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Sliders') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . '  Slider') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($slider, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php
                            
                            // echo $this->AdminForm->control('type', ['type' => 'select', 'option' => $types, 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('title', ['type' => 'text']);

                            echo $this->AdminForm->control('url', ['type' => 'text', 'label' => 'Left Button Url']);
                            echo $this->AdminForm->control('url_label', ['type' => 'text', 'label' => 'Left Button Label']);
                            echo $this->AdminForm->control('right_url', ['type' => 'text', 'label' => 'Right Button Url']);
                            echo $this->AdminForm->control('right_url_label', ['type' => 'text', 'label' => 'Right Button Label']);


                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $slider,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);



                            // echo $this->AdminForm->control('mobile_image', ['label' => 'PopupImage', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $slider,
                            //     'field' => 'mobile_image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);
                            // echo $this->AdminForm->control('image', ['type' => 'file']);
                            ?>
                            <!-- <div class="related-text">Image Size 1585px X 300px</div> -->
                            <?php
                            // echo $this->AdminForm->control('mobile_image', ['type' => 'file']);
                            ?>
                            <!-- <div class="related-text">Image Size 768px X 170px</div> -->
                            <?php
                            echo $this->AdminForm->control('text', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('html1', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('html2', ['type' => 'textarea', 'class' => 'editor']);
                            // echo $this->AdminForm->control('keywords',['type'=>'text']);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            // echo $this->AdminForm->control('is_full_height', ['type' => 'checkbox']);
                            // echo $this->AdminForm->enableAjaxUploads($id, 'slider_' . $id, $mainAdminToken);
                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$slider->isNew()) {

                                echo $this->element('save_as_new', array($slider));
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