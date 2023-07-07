<section class="secondry-banner unitedKingdom"  style="background: url(<?= $university['banner_image_path'] ?>) !important">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb">
                    <h1 class=""><?= $university['university_name'] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="extra-bar">
        <h4 class="title"><?= $university['title'] ?></h4>
    </div>
</section>

<section class="just-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?= $university['top_text'] ?>
                <p class="descrp">

                </p>

            </div>
        </div>
    </div>
</section>


<section class="whyStudy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridWhyStudy">
                    <div class="image">
                        <img src="<?= $university['image_path'] ?>" alt="" class="circle-img">
                    </div>
                    <div class="text">
                        <h4 class="title">
                            Why Study In The <?= $university['university_code'] ?>?
                        </h4>

                        <?= $university['why_text'] ?>
                        <a href="#" class="btn MainBtn clear-blue ">
                            Apply Now
                            <img src="/img/icon/arrow-right.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gridTabes">
                    <a href="#" class="btn clear-blue foundation">Foundation</a>
                    <a href="#" class="btn light-red pre-sessional ">Pre-sessional </a>
                    <a href="#" class="btn gold-tips bachelor">Bachelor</a>

                    <a href="#" class="btn greenish-teal master">Master</a>
                    <a href="#" class="btn slate-grey phd">PhD</a>
                    <a href="#" class="btn white vocational">Vocational</a>

                </div>
            </div>
        </div>
    </div>
</section>