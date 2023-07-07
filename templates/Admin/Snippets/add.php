<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Snippets') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Snippets') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Snippet') ?></h3>
                        </div>

                        <?= $this->AdminForm->create($snippet, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            if (isset($snippet->editor_type) && $snippet->editor_type == 1) {
                                $class = 'editor basicEditor';
                            } elseif (isset($snippet->editor_type) && $snippet->editor_type == 2) {
                                $class = 'editor ';
                            } else {
                                $class = ' ';
                            }
                            $editor_types = [
                                0 => 'No Editor',
                                1 => 'Basic Editor',
                                2 => 'Full Editor',

                            ];
                            echo $this->AdminForm->control('name');
                            echo $this->AdminForm->control('title');
                            echo $this->AdminForm->control('category', ['empty' => 'Please select Category', 'options' => $categories]);
                            echo $this->AdminForm->control('content', ['class' => $class .' addFrontCss']);
                            echo $this->AdminForm->control('editor_type', ['empty' => 'Please select editor type', 'options' => $editor_types]);
                            // echo $this->AdminForm->control('single');
                            echo $this->AdminForm->control('active');
                            echo $this->AdminForm->control('display_order');
                            // echo $this->AdminForm->control('ads', ['label' => 'Ads as Json {key:value}']);

                            echo $this->AdminForm->enableEditors('.editor');

                            // echo $this->AdminForm->control('image', ['label' => 'PopupImage', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $snippet,
                            //     'field' => 'image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);

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
<!-- <script src="//cdn.ckeditor.com/4.20.1/basic/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script> -->