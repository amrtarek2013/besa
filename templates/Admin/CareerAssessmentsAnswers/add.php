<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')).' Career Assessments Answer') ?></h3>
                        <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
                    </div>
                    <div class="card-body">
                        <?php
                           echo $this->AdminForm->create($careerAssessmentsAnswer);
echo $this->AdminForm->control('user_id',['type'=>'text']);
            echo $this->AdminForm->control('career_assessments_survey_id',['type'=>'text']);
            echo $this->AdminForm->control('question_id',['type'=>'text']);
            echo $this->AdminForm->control('answer_txt',['type'=>'text']);
            echo $this->AdminForm->control('answer_id',['type'=>'text']);
            echo $this->AdminForm->control('created',['type'=>'text']);
            echo $this->AdminForm->control('modified',['type'=>'text']);
            
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
