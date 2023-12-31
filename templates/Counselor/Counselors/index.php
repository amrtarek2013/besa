<?php

use Cake\Routing\Router;
?>
<section class="main-banner register-banner Create-account-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/school_councelor_portal_bg.png" alt="" style="z-index: 2;"  width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Portal</h1>
                    <h2 class="title text-left">School Counselors Portal</h2>
                </div>
            </div>


            <div class="col-md-8 mr">
                <!-- <h4 class="title">Create an account to apply</h4>

                <p class="light-para">For the purpose of applying regulation, your details are required.</p> -->
                <?= $school_counselors_portal ?>


            </div>
            <div class="col-md-4 ml">
                <!-- <div class="container-formBox blue-border ">
                    <form action="/counselor/login" class="login" method="post">

                        <?= $this->Form->create($counselor, array('url' => '/counselor/login', 'id' => 'FormLogin', 'class' => 'login')); ?>
                        <h4 class="title">Log in</h4>
                        <div class="grid-container">
                            <div class="form-area">
                                <label for="email">Email*</label>
                                <input type="email" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-area">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="password">
                            </div>
                            <div class="form-area">
                <button type="submit" class="btn clear-blue">LOG IN</button>
            </div>
        </div>
        </form>
    </div>
    <br /><br /> -->
                <div class="container-formBox blue-border ">
                    <!-- <form action="/counselor/register" class="login" method="post"> -->

                    <?= $this->Form->create($counselor, array('url' => '/counselor/register', 'id' => 'FormRegister', 'class' => 'login')); ?>
                    <h5 class="title">Together, let's create a brighter future for your students!</h5>
                    <p class="light-para">For the purpose of applying regulation, your details are required.</p>
                    <div class="grid-container">
                        <?= $this->Form->control('name', [
                            'placeholder' => 'Full Name', 'label' => 'Full Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                        ]) ?>

                        <!-- <div class="form-area ">
                            <?= $this->Form->label('mobile', 'Mobile*') ?>
                            <?= $this->Form->control('mobile', [
                                'type' => 'tel', 'placeholder' => 'Mobile', 'label' => false, 'class' => 'form-control', 'required' => true
                            ]) ?>
                            <?= $this->Form->control('mobile_code', [
                                'placeholder' => 'Code', 'class' => 'country_code', 'label' => false, 'required' => true,
                                'type' => 'select', 'options' => $countriesCodesList,
                            ]) ?>
                        </div> -->
                        <?= $this->element('mobile_with_code') ?>
                        <?= $this->Form->control('school_name', [
                            'placeholder' => 'School name', 'label' => 'School name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->element('security_code') ?>

                        <div class="form-area">
                            <a href="<?= Router::url('/counselor/login') ?>" class="forgot-link">Login</a>
                            <br />
                            <button type="submit" class="btn clear-blue">SUBMIT</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</section>