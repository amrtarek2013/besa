<style>
    .btn {
        color: blueviolet;
    }

    td,th {
        padding: 10px;
        border: 1px solid #33ca9424;
    }
    th{
        text-align: right;
    }
</style>

<section class="register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Application Details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Applications Details</h4>
                    <h5 class="title-table">Student Details</h5>
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
                                <td><?php echo $statuses[$application->status] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <h5 class="title-table">Student Files</h5>
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
                        <h5 class="title-table">Application Courses</h5>
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
</section>