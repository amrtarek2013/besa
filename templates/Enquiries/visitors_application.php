<section class="main-banner register-banner Create-account-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg3.png" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Create</h1>
                    <h2 class="title text-left">Create an account</h2>
                </div>
            </div>


            <div class="col-md-12 mr">
                <?= $this->Form->create(null, array('id' => 'FormVisistorApp', 'class' => 'register')); ?>

                <div class="container-formBox">
                    <h4 class="title">Create an account to apply</h4>
                    <div class="grid-container">

                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'First Name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'First Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Last Name*', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <div class=" form-area">
                            <label for="">Mobile*</label>
                            <div class="grid-2col-mobile">
                                <?= $this->Form->control('mobile_code', [
                                    'placeholder' => 'Code', 'class' => 'form-control', 'label' => false, 'required' => true,
                                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                                ]) ?>

                                <?= $this->Form->control('mobile', [
                                    'placeholder' => 'Mobile', 'class' => 'form-control', 'label' => false, 'required' => true,
                                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                                ]) ?>
                            </div>
                        </div>

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

                    </div>
                    <p class="light-para">For the purpose of applying regulation, your details are required.</p>

                    <div class="container-submit">

                        <div class="checkboxes">
                            <div>
                                <input type="checkbox" name="terms" id="terms" required="required">
                                <label for="">I agree to <a href="#">terms & conditions</a> </label>
                            </div>
                            <div>
                                <input type="checkbox" name="is_subscribed" id="is_subscribed">
                                <label for="">Tick box to stay updated through BESA’s newsletter</label>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

                        <button type="submit" class="btn greenish-teal">Submit</button>
                    </div>
                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>