<section class="main-banner register-banner profile-banner school-counselors-profile">

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="background-banner-color">
                    <img src="<?=WEBSITE_URL?>img/new-images/Resume-bg2.png" alt="" style="z-index: 2;"  width="">
                    <img src="<?=WEBSITE_URL?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-7">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Profile</h1>
                    <h2 class="title text-left">School Counselors Profile</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="grid-container-profile">
                    <div class="left-box">
                        <div class="circle-img">
                            <img src="<?=$auth->user('image_path')?>" alt="">
                        </div>
                        <h2 class="name-profile"><?= strtoupper($auth->user('first_name') . ' ' . $auth->user('last_name')) ?></h2>
                        <span class="status online">ONLINE</span>
                        <a href="#" class="btn clear-blue">START A NEW APPLICATION</a>

                    </div>
                    <div class="right-box">
                        <div class="container-formBox blue-border ">

                            <ul class="listOfPage">

                                <?= $this->AdminSideMenu->render($sideMenus, 'counselor', true); ?>
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

            <div class="col-md-12">
                <div class="counselor-points">
                    <div class="d-flex">
                        <div class="box-points">
                            <div class="item">
                                <div class="circle-point">5</div>
                                <h4>Joined Successfully</h4>
                            </div>
                            <div class="item">
                                <div class="circle-point">25</div>
                                <h4>Applied</h4>
                            </div>
                            <div class="item">
                                <div class="circle-point">55</div>
                                <h4>Points Acquired</h4>
                            </div>
                            <div class="item">
                                <div class="circle-point text-success">$500</div>
                                <h4>Total Gain</h4>
                            </div>
                        </div>

                        <div class="box-text">
                            <a href="#">Withdraw</a>
                            <a href="#">Counselor Points</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>