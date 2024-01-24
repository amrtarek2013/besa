<section class="hero-country hero-Universities">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <img src="<?= WEBSITE_URL ?>img/new-desgin/ottawa-parliament-hill-building.png" alt="hero Universities">
                    <div class="text-container">
                        <a class="" href="<?php // Router::url('/user/register') 
                                            ?>">
                            <h3> <span>Universities </span> in <?= $countryDeatils['country_name'] ?></h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="universities-section absolute">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4>Universities in <?= $countryDeatils['country_name'] ?></h4>
                        </div>
                        <!-- <a href="#" class="link-see-more">
                            See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                        </a> -->
                    </div>
                    <div class="grid-universities">
                        <?php foreach ($universities as $university) : ?>
                            <div class="university">
                                <div class="header-box">
                                    <div class="logo">
                                        <img src="<?= $university['logo_path'] ?>" alt="This Is University Img 1" loading="lazy">

                                        <h5><a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['universitycourses.index']) ?>/<?= $university['id'] ?>/<?= $university['permalink'] ?>/2"><?= $university['university_name'] ?></a></h5>
                                    </div>
                                    <div class="icon-favorite">
                                        <i class="fa-regular fa-heart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="university-info">
                                    <p><?= $university['short_description'] ?></p>
                                </div>
                                <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['universitycourses.index']) ?>/<?= $university['id'] ?>/<?= $university['permalink'] ?>/2" class="btn apply-now-btn">Check Courses</a>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php //if (sizeof($universities) == 20) : ?>
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->first(' << ') ?>
                                <?= $this->Paginator->prev(' < ') ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(' > ') ?>
                                <?= $this->Paginator->last(' >> ') ?>
                            </ul>
                            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                        </div>
                    <?php //endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>