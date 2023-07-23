<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Countries') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Countries') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Country') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($country, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php

                            // echo $this->AdminForm->control('type', ['type' => 'select', 'option' => $types, 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('country_name', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('country_code', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('green_section', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('text_header', ['type' => 'text', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('title', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('continent', ['type' => 'select', 'options' => $continents, 'empty' => 'Select continent', 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('code', ['type' => 'text']);



                            echo $this->AdminForm->control('flag', ['label' => 'Flag', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $country,
                                'field' => 'flag',
                                'info' => [
                                    'width' => $uploadSettings['flag']['width'],
                                    'height' => $uploadSettings['flag']['height'],
                                    'path' => $uploadSettings['flag']['path']

                                ],
                            ])]);



                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $country,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);



                            // echo $this->AdminForm->control('image_why_study', ['label' => 'Why Study Left Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $country,
                            //     'field' => 'image_why_study',
                            //     'info' => [
                            //         'width' => $uploadSettings['image_why_study']['width'],
                            //         'height' => $uploadSettings['image_why_study']['height'],
                            //         'path' => $uploadSettings['image_why_study']['path']

                            //     ],
                            // ])]);


                            echo $this->AdminForm->control('why_text', ['type' => 'textarea', 'class' => 'editor AddFrontCss']);

                            echo $this->AdminForm->control('top_text', ['type' => 'textarea', 'Label' => 'Content', 'class' => 'editor AddFrontCss']);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            echo $this->AdminForm->control('display_order', []);
                            // echo $this->AdminForm->control('is_full_height', ['type' => 'checkbox']);
                            echo $this->AdminForm->enableAjaxUploads($id, 'country_' . $id, $mainAdminToken);
                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$country->isNew()) {

                                echo $this->element('save_as_new', array($country));
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