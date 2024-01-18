<div class="hero-section hero-counselor-points">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-counselor-points.png" alt="hero Counselor Points " loading="lazy">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Counselor <span> Points</span> </h1>
        </div>
    </div>
</div>
<div class="global-engagement icons-counselor-points">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Milestone</h2>
                <p class="description">Earn 1 Point for each student who joins a university <br>  through BESA</p>
                <div class="group-cards">
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_1.svg" alt="Icon Global connection" loading="lazy">
                            </div>
                        </div>
                        <h4>25 Students</h4>
                        <p>Applied</p>
                    </div>
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_2.svg" alt="Icon Language" loading="lazy">
                            </div>
                        </div>
                        <h4>5 Students</h4>
                        <p>Joined Successfully</p>
                    </div>
                    <div class="card-eng">
                        <div class="circle-gradient">
                            <div class="container-circle">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/school_tour/icon_3.svg" alt="Icon Dreams" loading="lazy">
                            </div>
                        </div>
                        <h4>5 Points</h4>
                        <p>Points Acquired</p>
                    </div>
                </div>
                <img src="<?= WEBSITE_URL ?>img/new-desgin/counter22.png" alt="" loading="lazy" style="margin:50px auto;display: block;">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="milestones">
                <div class="header-milestones">
                    <div class="item-header">
                        <p>Milestones</p>
                        <h4>Each Tier</h4>
                    </div>
                    <div class="item-header">
                        <p>
                            <span>Up to 5 Points</span> 
                            <span>point = $100</span>
                        </p>
                    </div>
                    <div class="item-header">
                        <p>
                            <span>6 to 10 Points</span> 
                            <span> oint = $150</span>
                        </p>
                    </div>
                    <div class="item-header">
                        <p>
                            <span>After 10 Points </span> 
                            <span>point = $150</span>
                        </p>
                    </div>
                </div>

                <div class="container-milestones">
                    <div class="canva">
                        <div>
                            <canvas id="canvaPoints"></canvas>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <script>
                            const ctx = document.getElementById('canvaPoints');
                            const data = {
                            labels: [
                                'Yellow',
                                'Green',
                                'Blue',
                                'Red',
                            ],
                            datasets: [{
                                label: 'Points',
                                data: [10, 20, 15,5],
                                backgroundColor: [
                                '#F9AB35',
                                '#34C759',
                                '#356CF9',
                                '#F93535',
                                
                                
                                ],
                                hoverOffset: 100
                            }]
                            };
                            new Chart(ctx, {
                                type: 'doughnut',
                                data: data,
                                options: {
                                    borderRadius: 10,
                                }
                            });
                        </script>

                    </div>
                    <div class="points-conversion">
                        <div class="item">
                            <div class="left-content">
                                <div class="small-circle"></div>
                                <h5 class="num-points">5 Points</h5>
                            </div>
                            <p class="clac-points">1P = 100</p>
                        </div>
                        <div class="item">
                            <div class="left-content">
                                <div class="small-circle"></div>
                                <h5 class="num-points">5 Points</h5>
                            </div>
                            <p class="clac-points">1P = 100</p>
                        </div>
                        <div class="item">
                            <div class="left-content">
                                <div class="small-circle"></div>
                                <h5 class="num-points">5 Points</h5>
                            </div>
                            <p class="clac-points">1P = 100</p>
                        </div>
                        <div class="item">
                            <div class="left-content">
                                <div class="small-circle"></div>
                                <h5 class="num-points">5 Points</h5>
                            </div>
                            <p class="clac-points">1P = 100</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<section class="main-banner register-banner Create-account-banner" style="padding-bottom:0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding: 0;">
                <div class="title-banner-blue  title-banner-green">
                    <div class="grid-container-3col  ">
                        <div class="box-point">
                            <h3 class="numb"><?= $counselor['number_joined_students'] ?></h3>
                            <p>Joined Successfully</p>
                        </div>
                        <div class="box-point">
                            <h3 class="numb"><?= $counselor['number_of_students'] ?></h3>
                            <p>Applied</p>
                        </div>
                        <div class="box-point">
                            <h3 class="numb"><?= $counselor['total_points'] ?></h3>
                            <p>Points Acquired</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="total-gain">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex">
                    <div class="total">
                        <P>Total Gain</P>
                        <h4 class="price">$<?= number_format($counselor['total_points_reward'], 0) ?></h4>
                    </div>

                    <a href="/counselor/withdraw" class="btn btn-withdraw">WITHDRAW</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $counselor_points_page_snippet ?>
<?php if (false) { ?>
    <div class="milestone">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="text-align: center">MILESTONE</h2>
                    <p class="desc">Each successful deposit equals 1 POINT</p>
                    <div class="gridContainer-counter">
                        <div class="box">
                            <div class="number green">
                                <h4>10</h4>
                                <p>Points</p>

                            </div>
                        </div>
                        <div class="box">
                            <div class="number yellow">
                                <h4>20</h4>
                                <p>Points</p>
                            </div>
                        </div>

                        <div class="box">
                            <div class="number red">
                                <h4>50</h4>
                                <p>Points</p>
                            </div>
                        </div>
                        <div class="box">
                            <div class="number blue">
                                <h4>80</h4>
                                <p>Points</p>
                            </div>
                        </div>
                        <div class="box">
                            <div class="number blue-dark">
                                <h4>100</h4>
                                <p>Points</p>
                            </div>
                        </div>
                    </div>
                    <div class="mil-text d-flex">
                        <div class="col-left">
                            <p>Student Apply</p>
                            <p>Student Joined</p>
                            <p>Successful Deposit Equals</p>
                        </div>
                        <div class="col-right">
                            <P>1 Point</P>
                            <P>2 Point</P>
                            <P>1 Point</P>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>