<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Enquiries') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Enquiries') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Enquiry') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($enquiry, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($enquiry, ['type' => 'file', 'id' => $action . 'Form']);

                            echo $this->AdminForm->control('name', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('address', ['type' => 'text', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('country', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('state', ['type' => 'text', 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('city', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('street', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('postcode', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('phone', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('mobile', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('email', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('postcode', ['type' => 'text', 'class' => 'INPUT required']);

                            // echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $enquiry,
                            //     'field' => 'image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);

                            // echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            // echo $this->AdminForm->control('display_order', []);

                            
                            // echo $this->AdminForm->control('facebook', []);
                            // echo $this->AdminForm->control('youtube', []);
                            // echo $this->AdminForm->control('instagram', []);
                            // echo $this->AdminForm->control('linkedin', []);
                            // echo $this->AdminForm->control('twitter', []);
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$enquiry->isNew()) {

                                echo $this->element('save_as_new', array($enquiry));
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