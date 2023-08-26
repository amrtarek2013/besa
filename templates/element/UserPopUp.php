<!-- start remodal sections  -->
<div class="remodal comfirmDetails successModal" data-remodal-id="FlashMessagePop" id="FlashMessagePop" data-remodal-options="hashTracking: false, closeOnOutsideClick" style="display:none;">
    <div class="CDhead">
        <h2></h2>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div><!-- end head  -->
    <div class="CDbody">
        <div class="successSection">
            <img src="" alt="" class="showHideSuccess">
            <p>
            </p>
        </div>

    </div><!-- end body  -->
</div>

<div class="remodal modalMsg" data-remodal-id="modalMsg">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1 id="msgTitle"></h1>
    <p id="msgText">

    </p>
    <br>
    <button data-remodal-action="cancel" style="display: none;" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>

<div class="remodal lastSearchUrl" data-remodal-id="lastSearchUrl">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1 id="msgTitle"></h1>
    <p id="msgText">

    </p>
    <br>
    <button data-remodal-action="cancel" style="display: none;" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>

<div class="remodal removebg" data-remodal-id="login">
    <!-- <h1>Login</h1> -->
    <section class="register-banner Create-account-banner">

        <div class="">
            <div class="row">

                <div class="col-md-12">

                    <button data-remodal-action="close" class="remodal-close"></button>
                    <div class="container-formBox blue-border ">
                        <form action="/user/login" class="login" method="post">

                            <?= $this->Form->create(null, array('url' => '/user/login', 'id' => 'FormLogin', 'class' => 'login')); ?>
                            <h4 class="title">Log in</h4>
                            <div class="grid-container">
                                <div class="form-area">
                                    <label for="email">Email*</label>
                                    <input type="email" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <div class="form-area">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="password" required="required">
                                </div>
                                <div class="form-area">
                                    <button type="submit" class="btn clear-blue">LOG IN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <!-- <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button> -->
</div>

<div class="remodal removebg" data-remodal-id="register" style="max-width: 1060px !important;">

    <section class="register-banner Create-account-banner">

        <div class="">
            <div class="row">

                <div class="col-md-12">

                    <button data-remodal-action="close" class="remodal-close"></button>
                    <?= $this->Form->create(null, array('id' => 'FormRegister', 'class' => 'register')); ?>

                    <div class="container-formBox">
                        <h4 class="title">Create an account to apply</h4>
                        <div class="grid-container">

                            <?= $this->Form->control('first_name', [
                                'placeholder' => 'Name',
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>'], 'label' => 'Name*', 'required' => true
                            ]) ?>
                            <!-- <?= $this->Form->control('middle_name', ['placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false]) ?> -->
                            <?= $this->Form->control('last_name', [
                                'placeholder' => 'Surname*', 'label' => 'Surname*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <div class=" form-area">
                                <label for="">Date of Birth*</label>
                                <div class="grid-3col">
                                    <select name="day" id="day" placeholder="Day" required="required">
                                        <option value="">Day</option>

                                        <?php
                                        for ($i = 1; $i <= 31; $i++) {
                                            $d = $i; //date('M', strtotime("last day of +$i month"));
                                            echo "<option value='$d'>$d</option>";
                                        }
                                        ?>

                                    </select>
                                    <select name="month" id="month" placeholder="Month" required="required">
                                        <option value="">Month</option>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            $month = $i; // date('M', strtotime("last day of +$i month"));
                                            echo "<option value='$month'>$month</option>";
                                        }
                                        ?>
                                    </select>
                                    <select name="year" id="year" placeholder="Year" required="required">
                                        <option value="">Year</option>
                                        <?php
                                        for ($i = 1980; $i <= 2015; $i++) {
                                            $year = $i; //date('Y', strtotime("last day of +$i year"));
                                            echo "<option value='$year'>$year</option>";
                                        }
                                        ?>

                                        <!-- <option value="2001">2001</option> -->
                                    </select>
                                </div>
                            </div>
                            <?= $this->Form->control('email', [
                                'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>


                            <?= $this->Form->control('password', [
                                'type' => 'password', 'placeholder' => 'Password', 'label' => 'Password*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>
                            <?= $this->Form->control('passwd', [
                                'type' => 'password', 'placeholder' => 'Confirm Password', 'label' => 'Confirm Password*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>



                            <?= $this->Form->control('gender', [
                                'placeholder' => 'Gender*', 'label' => 'Gender*', 'required' => true,
                                'type' => 'select', 'empty' => 'Gender', 'options' => ['0' => 'Male', '1' => 'Female'],
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <?= $this->Form->control('student_type', [
                                'label' => 'I am a*', 'required' => true,
                                'type' => 'select', 'options' => ['0' => 'Student', '1' => 'Student2'],
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <!-- <?= $this->Form->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) ?>

            <?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'label' => 'Password*']) ?>
            <?= $this->Form->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

            <?= $this->Form->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true]) ?>

            <?= $this->Form->control('nationality', ['placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality*', 'required' => true]) ?>

            <?= $this->Form->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?>

            <?= $this->Form->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => true]) ?> -->

                        </div>
                        <p class="light-para">For the purpose of applying regulation, your details are required.</p>

                        <div class="container-submit">

                            <div class="checkboxes">
                                <div class="terms-conditions">
                                    <input type="checkbox" name="terms" id="terms" required="required">
                                    <label for="">I agree to <a href="<?= Cake\Routing\Router::url('/content/terms-conditions') ?>">terms & conditions</a> </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="is_subscribed" id="is_subscribed">
                                    <label for="">Tick box to stay updated through BESA’s newsletter</label>
                                </div>
                            </div>
                            <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

                            <button type="submit" class="btn greenish-teal">LOG IN</button>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>
            </div>
        </div>
    </section>
    <br>
    <!-- <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button> -->
</div>


<div class="remodal removebg" data-remodal-id="become-sponsor" style="max-width: 1060px !important;">

    <section class="register-banner Create-account-banner">

        <div class="">
            <div class="row">

                <div class="col-md-12">


                    <button data-remodal-action="close" class="remodal-close"></button>
                    <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormSponsor', 'class' => 'register')); ?>

                    <input type="hidden" id="type" name="type" value="become-sponsor">
                    <div class="container-formBox">

                        <h4 class="title">Become a Sponsor</h4>

                        <div class="grid-container">

                            <?= $this->Form->control('school_name', [
                                'placeholder' => 'Institution Name', 'label' => 'Institution Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                            ]) ?>
                            <?= $this->Form->control('school_counselor_name', [
                                'placeholder' => 'Contact Person Name*', 'label' => 'Contact Person Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                            ]) ?>


                            <?php //= $this->element('mobile_with_code') ?>
                            <?= $this->Form->control('email', [
                                'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <?= $this->element('security_code', ['show_label' => true]) ?>
                        </div>

                        <div class="container-submit container-submit-one-col">

                            <button type="submit" class="btn greenish-teal">SUBMIT</button>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>
            </div>
        </div>
    </section>
    <br>
    <!-- <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button> -->
</div>
<?php

$session = $this->getRequest()->getSession();

// debug($session->check('search_url'));
if ($session->check('search_url') && isset($_SESSION['Auth']['User'])) {
    $search_url = $session->read('search_url');

    $session->write('search_url', null);
    $session->delete('search_url');
    // $session->destroy('search_url');

?>

    <script>
        var inst = $('[data-remodal-id=lastSearchUrl]').remodal();
        $(document).ready(function() {

            $('.lastSearchUrl .remodal-cancel').show();
            $('.lastSearchUrl #msgText').html('Welcome again<br/> Do you want to open last search result page?');

            inst.open();


            $(document).on('confirmation', '.lastSearchUrl', function(e) {
                inst.close();

                window.location.assign('<?= Cake\Routing\Router::url($search_url, true) ?>');
            });
        });
    </script>
<?php } ?>


<?php echo $this->Html->script('new-js/jquery.validate'); ?>

<script type="text/javascript">
    var request_busy = false;
    $(function() {
        setInterval(function() {
            reLoadCaptchaV3();
        }, 2 * 60 * 1000);
        $('#FormSponsor').validate({
            rules: {
                'school_name': {
                    required: true,
                },
                'mobile': {
                    required: true,
                    minlength: 10,
                    maxlength: 13
                },
                'email': {
                    required: true,
                    email: true
                },
                'school_counselor_name': {
                    required: true,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function(form) {
                // form.submit();
                sponsorSubmitForm(form, true);
            }
        });

        sponsorSubmitForm = function(form, register) {

            if (!request_busy) {

                // $('body').LoadingOverlay("show");

                request_busy = true;
                // $('#registerbox .modal').append("<div class='remodal-loading'></div>");
                $.ajax({
                    type: "POST",
                    url: $(form).prop('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                }).done(function(data) {
                    request_busy = false;
                    $('.remodal-loading').remove();
                    console.log(data.status);
                    if (data.status) {


                        notification('success', data.message, data.title);


                        $('.error-message').remove();
                        $(form)[0].reset();

                        reLoadCaptchaV3();

                    } else {

                        // $('body').LoadingOverlay("hide");

                        notification('error', data.message, data.title);

                        var rmodal_id = 'modal';

                        // reLoadCaptchaV3();
                        $('.error-message').remove();
                        if (data['validationErrors']) {
                            for (i in data.validationErrors) {
                                if (typeof(data.validationErrors[i]) === 'object') {
                                    var errors_array = data.validationErrors[i];
                                    for (j in errors_array) {
                                        $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + errors_array[j] + '</div>');
                                    }
                                } else {
                                    $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + data.validationErrors[i] + '</div>');
                                }
                            }
                        }

                    }
                });

                // $('body').LoadingOverlay("hide");
            }
        }

    });
</script>