<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('View User') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('View User') ?></li>
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
                        <div class="card-header">
                            <h3 class="card-title"><?= __('View ' . $user['first_name'] . ' ' . $user['last_name'] . ' User') ?></h3>
                        </div>
                        <div class='FormExtended'>
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>



                                    <tr class="table-header">
                                        <th class="" width="">Name</th>
                                        <td><?= $user->first_name ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">last_name</th>
                                        <td><?= $user->last_name ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Email</th>
                                        <td><?= $user->email ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width="">Mobile</th>
                                        <td>(+<?= $user->mobile_code ?>) - <?= $user->mobile ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Gender</th>
                                        <td><?= $user->gender ? 'Femal' : 'Male' ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width="">Birth of Date</th>
                                        <td><?php echo (!empty($user->bd) ? $user->bd->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Profile Image</th>
                                        <td><img src="<?= $user->image_path ?>" /></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Current/Previous-(School/University)</th>
                                        <td><?= $user->current_status ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Nationality</th>
                                        <td><?= $user->nationality ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Country of Residence</th>
                                        <td><?= !empty($user->country) ? $user->country->country_name : '' ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Current/last Level of study</th>
                                        <td><?= isset($mainStudyLevels[$user->current_study_level]) ? $mainStudyLevels[$user->current_study_level] : '' ?></td>
                                    </tr>
                                    <!-- <tr class="table-header">
                                        <th class="" width="">study_level_id</th>
                                        <td><?= $user->study_level_id ?></td>
                                    </tr> -->
                                    <tr class="table-header">
                                        <th class="" width="">Major/subject of your study</th>
                                        <td><?= !empty($user->subject_area) ? $user->subject_area->title : '' ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">City</th>
                                        <td><?= $user->city ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Country of study</th>
                                        <td><?= !empty($user->destination) ? $user->destination->country_name : '' ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Address</th>
                                        <td><?= $user->address ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">How hear about us</th>
                                        <td><?= $user->how_hear_about_us ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width="">Email Confirmation</th>
                                        <td>
                                            <?= $user->email_confirmed ? '<span class="btn-status Yes">Yes</span>' : '<span class="btn-status No">No</span>' ?>
                                        </td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Active</th>
                                        <?= $user->active ? '<span class="btn-status Yes">Yes</span>' : '<span class="btn-status No">No</span>' ?>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width="">Subscribed</th>
                                        <?= $user->is_subscribed ? '<span class="btn-status Yes">Yes</span>' : '<span class="btn-status No">No</span>' ?>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Date</a></th>
                                        <td><?php echo (!empty($user->created) ? $user->created->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>