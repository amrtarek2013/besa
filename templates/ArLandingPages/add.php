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
                        echo $this->AdminForm->create($arLandingPage);
                        echo $this->AdminForm->control('title', ['type' => 'text']);
                        echo $this->AdminForm->control('permalink', ['type' => 'text']);
                        echo $this->AdminForm->control('right_logo', ['type' => 'text']);
                        echo $this->AdminForm->control('left_image', ['type' => 'text']);
                        echo $this->AdminForm->control('section_1', ['type' => 'text']);
                        echo $this->AdminForm->control('section_2', ['type' => 'text']);
                        echo $this->AdminForm->control('section_3', ['type' => 'text']);
                        echo $this->AdminForm->control('section_4', ['type' => 'text']);
                        echo $this->AdminForm->control('section_5', ['type' => 'text']);
                        echo $this->AdminForm->control('section_6', ['type' => 'text']);
                        echo $this->AdminForm->control('section_7', ['type' => 'text']);
                        echo $this->AdminForm->control('section_8', ['type' => 'text']);
                        echo $this->AdminForm->control('section_9', ['type' => 'text']);
                        echo $this->AdminForm->control('section_10', ['type' => 'text']);
                        echo $this->AdminForm->control('footer', ['type' => 'text']);
                        echo $this->AdminForm->control('created', ['type' => 'text']);
                        echo $this->AdminForm->control('modified', ['type' => 'text']);

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