<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Blogs') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Blogs') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Blog') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($blog, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php
                            
                            // echo $this->AdminForm->control('type', ['type' => 'select', 'option' => $types, 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('title', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('short_text', ['type' => 'text', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('image', ['label' => 'Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $blog,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ])]);
                            
                            echo $this->AdminForm->control('header_image', ['label' => 'Header Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $blog,
                                'field' => 'header_image',
                                'info' => [
                                    'width' => $uploadSettings['header_image']['width'],
                                    'height' => $uploadSettings['header_image']['height'],
                                    'path' => $uploadSettings['header_image']['path']

                                ],
                            ])]);
                            
                            $class = 'editor';
                            echo $this->AdminForm->control('content_text', ['class' => $class .' addFrontCss']);
                            
                            // echo $this->AdminForm->control('single');
                            echo $this->AdminForm->control('active');
                            echo $this->AdminForm->control('display_order');
                            // echo $this->AdminForm->control('ads', ['label' => 'Ads as Json {key:value}']);

                            echo $this->AdminForm->enableEditors('.editor');
                            // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'blog_' . $id, $mainAdminToken);
                            
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$blog->isNew()) {

                                echo $this->element('save_as_new', array($blog));
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