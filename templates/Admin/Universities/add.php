<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Universities') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Universities') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' University') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($university, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($university, ['type' => 'file', 'id' => $action . 'Form']);


                            echo $this->AdminForm->control('university_name', ['type' => 'text', 'class' => 'INPUT required', 'required' => true]);
                            // echo $this->AdminForm->control('code', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('title', ['type' => 'text']);

                            echo $this->AdminForm->control('country_id', ['label' => 'Country', 'type' => 'select', 'empty' => 'Select Country', 'options' => $countries, 'required' => true, 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('state', ['type' => 'text']);
                            // echo $this->AdminForm->control('city', ['type' => 'text']);
                            // echo $this->AdminForm->control('street', ['type' => 'text']);
                            // echo $this->AdminForm->control('postcode', ['type' => 'text']);
                            // echo $this->AdminForm->control('address', ['type' => 'text']);
                            // echo $this->AdminForm->control('telephone', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('email', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('website', ['type' => 'text']);

                            echo $this->AdminForm->control('short_description', ['label' => 'Description', 'type' => 'textarea', 'required' => true, 'class' => 'required']);

                            // echo $this->AdminForm->control('why_text', ['type' => 'textarea', 'class' => 'editor']);
                            echo $this->AdminForm->control('active', ['type' => 'checkbox', 'class' => 'INPUT']);
                            echo $this->AdminForm->control('display_order', ['class' => 'INPUT']);
                            echo $this->AdminForm->control('show_on_destination', ['type' => 'checkbox', 'class' => 'INPUT']);
                            echo $this->AdminForm->control('logo', ['label' => 'logo', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $university,
                                'field' => 'logo',
                                'info' => [
                                    'width' => $uploadSettings['logo']['width'],
                                    'height' => $uploadSettings['logo']['height'],
                                    'path' => $uploadSettings['logo']['path']

                                ],
                            ])]);

                            // echo $this->AdminForm->control('flag', ['label' => 'flag', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $university,
                            //     'field' => 'flag',
                            //     'info' => [
                            //         'width' => $uploadSettings['flag']['width'],
                            //         'height' => $uploadSettings['flag']['height'],
                            //         'path' => $uploadSettings['flag']['path']

                            //     ],
                            // ])]);



                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $university,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);


                            // echo $this->AdminForm->control('banner_image', ['label' => 'Banner Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $university,
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
                            echo $this->AdminForm->enableAjaxUploads($id, 'university_' . $id, $mainAdminToken);
                            echo $this->AdminForm->enableEditors('.editor');
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$university->isNew()) {

                                echo $this->element('save_as_new', array($university));
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