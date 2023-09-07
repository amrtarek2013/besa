<section class="main-banner banner-about-us blogs-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg45.png" alt="" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Blogs</h1>
                    <h2 class="title text-left">Blogs</h2>
                </div>
            </div>

        </div>
    </div>

    <div class="blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <?php
                    if (!empty($blogs)) : ?>
                        <?php $counter = 0; ?>

                        <div class="display-flex">
                            <?php foreach ($blogs as $blog) : ?>
                                <?php $counter++; ?>
                                <div class="box-blog display-flex">
                                    <img src="<?= $blog['image_path'] ?>" alt="This Is Blog Img 1" loading="lazy">
                                    <div class="content-blog">
                                        <p><?= $blog['title'] ?></p>
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['blogs.details'] . '/' . $blog['permalink']) ?>" class="read-anchor">READ MORE</a>
                                    </div>
                                </div>

                                <?php
                                if ($counter % 2 == 0) {
                                    echo '</div><div class="display-flex">';
                                }
                                ?>

                            <?php endforeach; ?>

                            <?php
                            if ($counter % 2 != 0) {
                                echo '<div class="box-blog display-flex"></div>';
                            }
                            ?>
                        </div>

                        <?php if (sizeof($universities) == 20) : ?>
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
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>