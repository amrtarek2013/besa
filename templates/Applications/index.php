<section class="main-banner register-banner  partiner-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="/img/new-images/partiner-background.png" alt="" style="z-index: 2;">
                    <img src="/img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">APPLAY</h1>
                    <h2 class="title text-left">APPLAY NOW</h2>
                </div>
            </div>

            <?php //= $partnership_with_besa 
            ?>
            <div class="col-md-12" style="padding: 0">
                <div class="title-banner-blue">
                    <h3>BESA: CONNECTING PEOPLE WORLDWIDE</h3>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <div class="container-iconsPartners">
                    <div class="boxPart">
                        <img src="/img/new-images/part-icon01.png" alt="">
                        <h4 class="titlePart">GROWTH</h4>
                        <p class="descrip">BESA is your trusted partner, <br> together we will fulfill student’s <br> ambitions internationally</p>
                    </div>
                    <div class="boxPart">
                        <img src="/img/new-images/part-icon02.png" alt="">
                        <h4 class="titlePart">ACCESS</h4>
                        <p class="descrip">Partnering with BESA means access to a wide range of resources and opportunities in the industry</p>
                    </div>
                    <div class="boxPart">
                        <img src="/img/new-images/part-icon03.png" alt="">
                        <h4 class="titlePart">EVENTS</h4>
                        <p class="descrip">BESA’s events are not to be missed! An opportunity for our partners to grow their presence and join us in exciting ventures</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <div class="line-stained">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'appCourses' => $appCourses]); ?>

<section class="main-banner register-banner  partiner-banner">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <form action="" class="">
                    <div class="container-formBox">
                        <div class="gray-box">
                            <p>Submit this form with your business details and one of our representatives will be in contact with you.</p>
                        </div>
                        <div class="grid-container">
                            <div class="form-area">
                                <label for="name">Company/institution name*</label>
                                <input type="text" id="name" name="name" placeholder="Name">
                            </div>

                            <div class="form-area">
                                <label for="email">Email address*</label>
                                <input type="email" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-area">
                                <label for="phone">Phone number*</label>
                                <input type="number" id="phone" name="phone" placeholder="Phone number">
                            </div>
                            <div class="form-area">
                                <label for="">Business address*</label>
                                <input type="text" id="" name="" placeholder="Address">
                            </div>

                            <div class="form-area">
                                <label for="">Upload business certificate</label>
                                <input type="file" id="" name="" placeholder="Certificate">
                            </div>
                            <div class="form-area">
                                <label for="">How did you hear about us?</label>
                                <input type="text" id="" name="" placeholder="Facebook">
                            </div>
                        </div>


                        <div class="container-submit">
                            <ul class="custome-list">
                                <li>For the purpose of applying regulation, your details are required.</li>
                            </ul>
                            <a href="#" class="btn greenish-teal" style="width: 240px;">SUBMIT</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>