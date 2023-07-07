<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Testimonials') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Testimonials') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Testimonial') ?></h3>
                        </div>

                        <?= $this->AdminForm->create($testimonial, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($testimonial, ['type' => 'file']);
                            echo $this->AdminForm->control('client_name', ['type' => 'text']);

                            echo $this->AdminForm->control('university', ['label' => 'University', 'type' => 'text']);
                            // echo $this->AdminForm->control('text', ['type' => 'text']);
                            echo $this->AdminForm->control('text', ['type' => 'textarea', 'class' => 'editor']);


                            // echo $this->AdminForm->control('date', ['type' => 'text', 'class' => 'hasDate']);
                            // echo $this->AdminForm->control('source', ['type' => 'text']);
                            // echo $this->AdminForm->control('source_url', ['type' => 'text']);
                            // echo $this->AdminForm->control('location', ['type' => 'text']);
                            // echo $this->AdminForm->control('rating', ['empty' => 'Please Select', 'type' => 'select', 'class' => 'rating', 'options' => array(0, 1, 2, 3, 4, 5)]);
                            echo $this->AdminForm->control('image', ['type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $testimonial,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);

                            echo $this->AdminForm->control('video_url', ['type' => 'text']);
                            echo $this->AdminForm->control('video_thumb', ['type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $testimonial,
                                'field' => 'video_thumb',
                                'info' => [
                                    'width' => $uploadSettings['video_thumb']['width'],
                                    'height' => $uploadSettings['video_thumb']['height'],
                                    'path' => $uploadSettings['video_thumb']['path']

                                ],
                            ])]);

                            // echo $this->AdminForm->control('keywords', ['type' => 'text', 'class' => 'keywords']);\

                            echo $this->AdminForm->control('display_order', []);

                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            echo $this->AdminForm->enableEditors('.editor');
                            // echo $this->AdminForm->enableAjaxUploads($id, 'testimonial_' . $id, $mainAdminToken);
                            ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>