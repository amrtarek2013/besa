<style type="text/css">
    .small-box p {
        font-size: 18px;
    }
</style>
<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?=__('Dashboard')?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?=__('Home')?></a></li>
                        <li class="breadcrumb-item active"><?=__('Dashboard')?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content" style="margin-top: 50px;">
        <div class="container-fluid">
                
            <h3 class="m-0"><?=__('All Versions')?></h3>
            <div class="row">
                <!-- bg-info    bg-success    bg-warning     bg-danger -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=number_format($total_registered_users)?></h3>
                            <p><?=__('Registered users').' <b>('.$all_country_count.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=number_format($active_users)?></h3>
                            <p><?=__('Active Users in').' <b>('.$active_country_count.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=number_format($total_uploaded_files)?></h3>
                            <p><?=__('Total uploaded files')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3><?=number_format($items_count)?></h3>
                            <p><?=__('Items having uploads')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gradient-orange">
                        <div class="inner">
                            <h3><?=__('Lesson')?> #<?=$max_reached_lesson?></h3>
                            <p><?=__('Max reached lesson')?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="m-0"><?=__('Android Version')?></h3>
            <div class="row">
                <!-- bg-info    bg-success    bg-warning     bg-danger -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=number_format($total_registered_users_android)?></h3>
                            <p><?=__('Registered users').' <b>('.$all_country_count_android.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=number_format($active_users_android)?></h3>
                            <p><?=__('Active Users in').' <b>('.$active_country_count_android.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=number_format($total_uploaded_files_android)?></h3>
                            <p><?=__('Total uploaded files')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3><?=number_format($items_count_android)?></h3>
                            <p><?=__('Items having uploads')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gradient-orange">
                        <div class="inner">
                            <h3><?=__('Lesson')?> #<?=$max_reached_lesson_android?></h3>
                            <p><?=__('Max reached lesson')?></p>
                        </div>
                    </div>
                </div>
            </div>



            <h3 class="m-0"><?=__('iOS Version')?></h3>
            <div class="row">
                <!-- bg-info    bg-success    bg-warning     bg-danger -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=number_format($total_registered_users_ios)?></h3>
                            <p><?=__('Registered users').' <b>('.$all_country_count_ios.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=number_format($active_users_ios)?></h3>
                            <p><?=__('Active Users in').' <b>('.$active_country_count_ios.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=number_format($total_uploaded_files_ios)?></h3>
                            <p><?=__('Total uploaded files')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3><?=number_format($items_count_ios)?></h3>
                            <p><?=__('Items having uploads')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gradient-orange">
                        <div class="inner">
                            <h3><?=__('Lesson')?> #<?=$max_reached_lesson_ios?></h3>
                            <p><?=__('Max reached lesson')?></p>
                        </div>
                    </div>
                </div>
            </div>


            <h3 class="m-0"><?=__('Huawei Version')?></h3>
            <div class="row">
                <!-- bg-info    bg-success    bg-warning     bg-danger -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=number_format($total_registered_users_huawei)?></h3>
                            <p><?=__('Registered users').' <b>('.$all_country_count_huawei.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=number_format($active_users_huawei)?></h3>
                            <p><?=__('Active Users in').' <b>('.$active_country_count_huawei.')</b> '.__('countries')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=number_format($total_uploaded_files_huawei)?></h3>
                            <p><?=__('Total uploaded files')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3><?=number_format($items_count_huawei)?></h3>
                            <p><?=__('Items having uploads')?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-gradient-orange">
                        <div class="inner">
                            <h3><?=__('Lesson')?> #<?=$max_reached_lesson_huawei?></h3>
                            <p><?=__('Max reached lesson')?></p>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>


  </div>
  <!-- /.content-wrapper -->




















<?php if(false){ ?>
    <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Online Store Overview</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-success text-xl">
                    <i class="ion ion-ios-refresh-empty"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-success"></i> 12%
                    </span>
                    <span class="text-muted">CONVERSION RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                    </span>
                    <span class="text-muted">SALES RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                  </p>
                  <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-down text-danger"></i> 1%
                    </span>
                    <span class="text-muted">REGISTRATION RATE</span>
                  </p>
                </div>
                <!-- /.d-flex -->
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
<?php } ?>