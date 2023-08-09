<section class="main-banner Create-account-banner  visitors-application">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/Welcome-vis.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>




            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('type' => 'file', 'id' => 'FormEducationalInstitution', 'class' => 'register')); ?>
                
                <input type="hidden" id="type" name="type" value="educational-institution">
                <!-- <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->

                <div class="container-formBox">
                    <!-- <h4 class="title">Create an account to apply</h4> -->
                    <div class="grid-container">

                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'First Name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'First Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Last Name*', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?php
                        /* 
                        $this->Form->control('mobile', [
                            'placeholder' => 'Mobile', 'label' => 'Mobile*', 'class' => 'form-control', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]);
                        */
                        ?>

                        <div class="form-area ">
                            <?= $this->Form->label('mobile', 'Mobile*') ?>
                            <?= $this->Form->control('mobile', [
                                'type' => 'tel', 'placeholder' => 'Mobile', 'label' => false, 'class' => 'form-control', 'required' => true
                            ]) ?>
                            <?= $this->Form->control('mobile_code', [
                                'placeholder' => 'Code', 'class' => 'country_code', 'label' => false, 'required' => true,
                                'type' => 'select', 'options' => $countriesCodesList
                            ]) ?>
                        </div>
                        <!--
                        <div class=" form-area">
                            <label for="">Mobile*</label>
                            <div class="grid-2col-mobile">
                               

                                
                            </div>
                        </div> -->

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('city', [
                            'type' => 'text', 'placeholder' => 'School Name', 'label' => 'School Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('study_level_id', [
                            'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload attending students details*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]); ?>
                        <?= $this->element('security_code', ['show_label'=>true]) ?>

                    </div>

                    <div class="container-submit">

                        <div class="checkboxes">
                            <div>
                                <input type="checkbox" name="terms" id="terms" required="required">
                                <label for="">I agree to <a href="#">terms & conditions</a> </label>
                            </div>
                            <div>
                                <input type="checkbox" name="is_subscribed" id="is_subscribed">
                                <label for="">I’d like being informed about latest news and tips</label>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

                    </div>
                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>