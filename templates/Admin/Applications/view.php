<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('View Application') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('View Application') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h3 class="card-title"><?= __('View Application') ?></h3>
                        </div> -->
                        <div class='FormExtended'>

                            <h3>Student Details</h3>
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>
                                    <tr class="table-header">

                                        <th class="" width=""><a>#ID</a></th>
                                        <td><?php echo $application->id ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class=""><a>Name</a></th>
                                        <td><?php echo (!empty($application->user->first_name) ? $application->user->first_name : '') ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class=""><a>Email</a></th>
                                        <td><?php echo (!empty($application->user->email) ? $application->user->email : '') ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>mobile</a></th>
                                        <td><?php echo (!empty($application->user->mobile) ? $application->user->mobile : '') ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Date</a></th>
                                        <td><?php echo (!empty($application->created->format('H:m:i d-m-Y')) ? $application->created->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Status</a></th>
                                        <td>
                                            <span class="btn-status <?= $statuses[$application->status] ?>">
                                                <?php echo $statuses[$application->status] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Status</a></th>
                                        <td>
                                            <div class="row">

                                                <?php
                                                echo $this->AdminForm->create($application, ['url' => '/admin/applications/edit/' . $application->id.'/view', 'id' => 'UpdateAdminForm']);

                                                echo $this->AdminForm->control('id', ['type' => 'hidden', 'value' => $application->id]) ?>
                                                <div class="col-md-12">
                                                    <?= $this->AdminForm->control('status', ['label' => false, 'type' => 'select', 'empty' => 'Status', 'options' => $statuses]) ?>
                                                    <?= $this->AdminForm->control('status_text', ['type' => 'textarea']) ?>

                                                    <button type="submit" class="btn btn-primary"><?= __('Update') ?> </button>
                                                </div>
                                                <?= $this->AdminForm->end() ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3>Student Files</h3>
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>
                                    <?php foreach ($appFields as $field_name => $field_label) : ?>

                                        <?php if (!empty($application[$field_name])) : ?>
                                            <tr class="table-header">

                                                <th class="" width=""><a><?= $field_label ?></a></th>


                                                <td><a target="_blank" href="/uploads/files/applications/<?php echo $application[$field_name] ?>">Downlaod</a></td>
                                            </tr>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <?php if (!empty($courses)) { ?>
                                <h3>Application Courses</h3>
                                <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                    <tbody>
                                        <tr class="table-header">
                                            <th class=""><a>Course Name</a></th>
                                            <th class=""><a>University</a></th>
                                            <th class=""><a>Fees</a></th>
                                            <th class=""><a>Duration</a></th>
                                            <th class=""><a>Intake</a></th>
                                            <th class=""><a>Degree</a></th>
                                        </tr>
                                        <?php foreach ($courses as $key => $applicationCourse) : ?>
                                            <tr>
                                                <td><?php echo $applicationCourse->course_name ?></td>
                                                <td><?php echo $applicationCourse->university->title ?></td>
                                                <td>$<?php echo number_format($applicationCourse->fees) ?></td>
                                                <td><?php echo $applicationCourse->duration ?></td>
                                                <td><?php echo $applicationCourse->intake ?></td>
                                                <td><?php echo $applicationCourse->degree ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php } ?>




                        </div>

                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>