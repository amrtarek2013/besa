<section class="main-banner Create-account-banner  visitors-application book-appointment">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/book_appointment.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Book </h1>
                    <h2 class="title text-left">Book an <br />appointment</h2>
                </div>
            </div>




            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'type' => 'file', 'id' => 'FormBookAppointment', 'class' => 'register')); ?>

                <input type="hidden" id="type" name="type" value="book-appointment">
                <p class="light-para">
                    Access study abroad counseling conveniently from any location and at your own pace. If you're seeking guidance on studying abroad but prefer to avoid in-person meetings or face challenges like traffic, we have the perfect solution for you. Reach out to us to schedule a remote counseling session with IDP's knowledgeable education counselors. They will provide comprehensive support to help you reach your dream destination. From analyzing your study options and selecting the ideal destination, university, and course, to assisting with application submissions, visa guidance, accommodation services, and more – all of this can be conveniently accessed online. Don't let barriers hold you back; take advantage of our remote counseling services today.
                </p>

                <div class="container-formBox">
                    <p class="light-para">For the purpose of applying regulation, your details are required.</p>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'Full Name*', 'label' => 'Full Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                       

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

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

                        <?= $this->Form->control('destination_id', [
                            'placeholder' => 'Study destination interested in*', 'type' => 'select', 'empty' => 'Select Study destination interested in*',
                            'options' => $destinationsList, 'label' => 'Study destination interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('subject_area_id', [
                            'placeholder' => 'Subject area interested in*', 'type' => 'select', 'empty' => 'Select Subject area interested in*',
                            'options' => $subjectAreasList, 'label' => 'Subject area interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}" id="subject-area">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('study_level', [
                            'placeholder' => 'Study level interested in*', 'type' => 'select', 'empty' => 'Select Study level interested in*',
                            'options' => $mainStudyLevels, 'label' => 'Study level interested in*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?php /*$this->element('security_code', ['show_label' => true])*/ ?>

                    </div>
                            <!--
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

                    </div> -->
                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>