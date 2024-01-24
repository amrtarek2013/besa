<?php

use Cake\Routing\Router;
?>


<div class="hero-section hero-counselors">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero icon-pencil-note">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-counselors.png" alt="hero Counselors Portal">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">School <span>Counselors Portal</span> </h1>
        </div>
    </div>
</div>

<section class="bottom-hero-section ">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="">
                <div class="title-bottom-hero">
                    <h2 class="title">Welcome to <br>the School Counselor Portal</h2>
                    <p class="bold-descrp">Register and Unlock Rewards for Your Students' Success</p>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="section-content-and-form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex">
                    <div class="content content-text">
                        <?= $school_counselors_portal ?>
                    </div>
                    <!-- <div class="container-formBox blue-border ">
                    <form action="/counselor/login" class="login" method="post">

                        <?= $this->Form->create($counselor, array('url' => '/counselor/login', 'id' => 'FormLogin', 'class' => 'login ')); ?>
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
                    <div class="container-formBox  sideform ">
                        <!-- <form action="/counselor/register" class="login" method="post"> -->

                        <?= $this->Form->create($counselor, array('url' => '/counselor/register', 'id' => 'FormRegister', 'class' => 'login')); ?>
                        <h5 class="title-form">Together, let's create a brighter future for your students!</h5>
                        <p class="white-para">For the purpose of applying regulation, your details are required.</p>
                        <div class="grid-container">
                            <?= $this->Form->control('name', [
                                'placeholder' => 'Your Full Name', 'label' => 'Full Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <?= $this->Form->control('email', [
                                'placeholder' => 'Your work-email', 'class' => 'form-control', 'label' => 'Work Email*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                            ]) ?>

                            <?= $this->element('mobile_with_code', ['phone_label' => 'Phone number']) ?>
                            <?= $this->Form->control('school_name', [
                                'placeholder' => 'You school name', 'label' => 'School name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                            ]) ?>
                            <?= $this->element('security_code') ?>

                            <div class="form-area">
                                <!-- <a href="<? php // Router::url('/counselor/login') 
                                                ?>" class="forgot-link">Login</a> -->
                                <br />
                                <button type="submit" class="btn clear-blue">SUBMIT</button>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="main-banner register-banner Create-account-banner">

    <div class="container">
        <div class="row">


            <div class="col-md-6 mr">




            </div>

        </div>
    </div>
</section>