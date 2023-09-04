<section class="main-banner Create-account-banner visitors-application educational-institution  british-Trophy">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">

                    <img src="<?= WEBSITE_URL ?>img/customer-support-flat.png" alt="customer support"  width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Trophy</h1>
                    <h2 class="title text-left">The British<br />Trophy Event<br />Subscription</h2>
                    <!-- <h2 class="title text-left-mobile">The British<br />Trophy Event<br />Subscription</h2> -->
                </div>
            </div>

            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormBritishTrophySubscription', 'class' => 'register')); ?>
                <input type="hidden" id="type" name="type" value="british-trophy-subscription">
                <!-- <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->

                <div class="container-formBox">
                    <!-- <h4 class="title">Create an account to apply</h4> -->
                    <div class="grid-container">

                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'School name', 'label' => 'School name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Contact person name*', 'label' => 'Contact person name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <!-- <div class="form-area ">
                            <?= $this->Form->label('mobile', 'Mobile*') ?>
                            <?= $this->Form->control('mobile', [
                                'type' => 'tel', 'placeholder' => 'Mobile', 'label' => false, 'class' => 'form-control', 'required' => true
                            ]) ?>
                            <?= $this->Form->control('mobile_code', [
                                'placeholder' => 'Code', 'class' => 'country_code', 'label' => false, 'required' => true,
                                'type' => 'select', 'options' => $countriesCodesList
                            ]) ?>
                        </div> -->

                        <!-- <div class="form-area ">
                            <?= $this->Form->label('phone', 'Mobile*') ?>
                            <?= $this->Form->control('phone', [
                                'type' => 'tel', 'placeholder' => 'Mobile', 'label' => false, 'class' => 'form-control', 'required' => true
                            ]) ?>
                            <?= $this->Form->control('phone_code', [
                                'placeholder' => 'Code', 'class' => 'country_code mobile_code', 'label' => false, 'required' => true,
                                'type' => 'select',
                            ]) ?>
                        </div> -->


                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload attending students details*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]); ?>
                        <?php /* $this->element('security_code', ['show_label' => true]) */ ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                        <div class="form-area check-en">
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
                        </div>
                    </div>


                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>
<?php if ($this->request->is('mobile')) { ?>
    <script>
        $(document).ready(function(){

            let text = $('.title .text-left').html();
            text = text.replace('<br/>', ' ');
            $('.title .text-left').html(text);
        });
    </script>
<?php } ?>