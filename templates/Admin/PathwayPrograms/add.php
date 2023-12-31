<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Pathway Programs') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Pathway Programs') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Pathway Program') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        
                        $class = 'editor';
                        ?>
                        <?= $this->AdminForm->create($pathwayProgram, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php
                            
                            // echo $this->AdminForm->control('type', ['type' => 'select', 'option' => $types, 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('title', ['type' => 'text', 'class' => 'INPUT required']);
                            // echo $this->AdminForm->control('short_text', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('short_text', ['type' => 'textarea', 'class' => $class .' addFrontCss']);

                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $pathwayProgram,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);
                          
                            $class = 'editor';
                            echo $this->AdminForm->control('text', ['class' => $class .' addFrontCss']);
                            // echo $this->AdminForm->control('single');
                            echo $this->AdminForm->control('active');
                            echo $this->AdminForm->control('display_order');
                            // echo $this->AdminForm->control('ads', ['label' => 'Ads as Json {key:value}']);

                            echo $this->AdminForm->enableEditors('.editor');
                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'pathwayProgram_' . $id, $mainAdminToken);
                            
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$pathwayProgram->isNew()) {

                                echo $this->element('save_as_new', array($pathwayProgram));
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