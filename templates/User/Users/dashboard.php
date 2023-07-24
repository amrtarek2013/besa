<section class="main-banner register-banner profile-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/new-images/Resume-bg2.png" alt="" style="z-index: 2;">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-7">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Profile</h1>
                    <h2 class="title text-left">My Profile</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="grid-container-profile">
                    <div class="left-box">
                        <div class="circle-img">
                            <img src="<?= $data['image_path'] ?>" alt="">
                        </div>
                        <h2 class="name-profile"><?= strtoupper($auth->user('first_name') . ' ' . $auth->user('last_name')) ?></h2>
                        <span class="status"><?= $data['email_confirmed'] ? 'APPROVED' : 'PENDING' ?></span>
                        <a href="/study?steps=1" class="btn clear-blue">START A NEW APPLICATION</a>

                    </div>
                    <div class="right-box">
                        <div class="container-formBox blue-border ">

                            <ul class="listOfPage">

                                <?= $this->AdminSideMenu->render($sideMenus, 'user', true); ?>
                                <!-- <li>
                                    <a href="#">Edit account details</a>
                                </li>
                                <li>
                                    <a href="#">Security</a>
                                </li>
                                <li>
                                    <a href="#">Register to attend the fair</a>
                                </li>
                                <li>
                                    <a href="#">Opt in for newsletter</a>
                                </li>
                                <li>
                                    <a href="#">App support</a>
                                </li>
                                <li>
                                    <a href="#">Contact support team</a>
                                </li>
                                <li>
                                    <a href="#">Track & view your application</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>