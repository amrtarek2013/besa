<section class="main-banner banner-about-us blogs-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="/img/hero-bg45.png" alt="">
                    <img src="/img/dots-153.png" alt="" class="relative-dots-about">
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


                    <?php if (!empty($blogs)) : ?>
                        <?php $counter = 0; ?>

                        <div class="display-flex">
                            <?php foreach ($blogs as $blog) : ?>
                                <?php $counter++; ?>
                                <div class="box-blog display-flex">
                                    <img src="<?= $blog['image_path'] ?>" alt="This Is Blog Img 1" loading="lazy">
                                    <div class="content-blog">
                                        <p><?= $blog['title'] ?></p>
                                        <a href="/blog-details/<?= $blog['permalink'] ?>" class="read-anchor">READ MORE</a>
                                    </div>
                                </div>

                                <?php
                                if ($counter % 2 == 0) {
                                    echo '</div><div class="display-flex">';
                                }
                                ?>

                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>