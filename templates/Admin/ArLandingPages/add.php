<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">
                    <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Ar Landing Page') ?></h3>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Ar Landing Page') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        echo $this->AdminForm->create($arLandingPage,['type' => 'file']);
                        echo $this->AdminForm->control('title', ['type' => 'text']);
                        echo $this->AdminForm->control('permalink', ['type' => 'text']);
                        echo $this->AdminForm->control('right_logo', ['label' => 'Right flag', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            'data' => $arLandingPage,
                            'field' => 'right_logo',
                            'info' => [
                                'width' => $uploadSettings['right_logo']['width'],
                                'height' => $uploadSettings['right_logo']['height'],
                                'path' => $uploadSettings['right_logo']['path']

                            ],
                        ])]);
                        echo $this->AdminForm->control('left_image', ['label' => 'Left Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            'data' => $arLandingPage,
                            'field' => 'left_image',
                            'info' => [
                                'width' => $uploadSettings['left_image']['width'],
                                'height' => $uploadSettings['left_image']['height'],
                                'path' => $uploadSettings['left_image']['path']

                            ],
                        ])]);
                        $class = 'editor landingcss ';
                        //addFrontCss

                        echo $this->AdminForm->control('section_1', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_2', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_3', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_4', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_5', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_6', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_7', ['class' => $class .' ']);
                        echo $this->AdminForm->control('section_8', ['class' => $class .' ']);
                        // echo $this->AdminForm->control('section_9', ['class' => $class .' ']);
                        // echo $this->AdminForm->control('section_10', ['class' => $class .' ']);
                        echo $this->AdminForm->control('footer', ['class' => $class .' ']); 
                        echo $this->AdminForm->enableEditors('.editor');

                        ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <?= $this->AdminForm->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>