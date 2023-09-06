<link rel="preload" as="image" href="<?= WEBSITE_URL ?>img/Welcome-vis.png">
<link rel="preload" as="image" href="<?= WEBSITE_URL ?>img/dots-153.png">
<section class="main-banner Create-account-banner  visitors-application">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/Welcome-vis.png" alt="" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>

            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormVisitorApp', 'class' => 'register')); ?>
                <input type="hidden" id="type" name="type" value="visitors-application">
                <p class="light-para" style="line-height: 28px;">
                    <?= $visitorsApplicationToText ?>

                </p>
                <!-- <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->

                <div class="container-formBox">
                    <h4 class="title">Create an account to apply</h4>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'First Name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'First Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('surname', [
                            'placeholder' => 'Last Name*', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('school_name', [
                            'type' => 'text', 'placeholder' => 'School / University name', 'label' => 'School / University name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('study_level', [
                            'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('destination_id', [
                            'placeholder' => 'Study destination interested in*', 'type' => 'select', 'empty' => 'Select Study destination interested in*',
                            'options' => $destinationsList, 'label' => 'Study destination interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('fair_venue', [
                            'placeholder' => 'Fair Venue*', 'type' => 'select', 'empty' => 'Select Fair Venue*',
                            'options' => $fairVenues, 'label' => 'Fair Venue*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                    </div>

                    <div class="container-submit">

                        <div class="checkboxes">
                            <div class="terms-conditions">
                                <input type="checkbox" name="terms" id="terms" required="required">
                                <label for="">I agree to <a href="<?= Cake\Routing\Router::url('/content/terms-conditions') ?>">terms & conditions</a> </label>
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