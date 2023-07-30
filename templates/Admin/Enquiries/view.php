<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('View Enquiry') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('View Enquiry') ?></li>
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
                            <h3 class="card-title"><?= __('View ' . $enquiryType['title'] . ' Enquiry') ?></h3>
                        </div>
                        <div class='FormExtended'>
                            <!-- <h3>User Details</h3> -->
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>
                                    <?php

                                    use Cake\Routing\Router;
                                    use Cake\Utility\Inflector;

                                    foreach ($enquiryType['fields'] as $field) : ?>
                                        <tr class="table-header">
                                            <th class=""><a><?= Inflector::humanize($field) ?></a></th>
                                            <td><?php echo (!empty($enquiry[$field]) ? ($field == 'certificate' ? ($enquiry['file_path'] != '#' ? '<a target="_blank" href="' . Router::url($enquiry['file_path']) . '">Download</a>' : '---') : $enquiry[$field]) : '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- 
<tr class="table-header">
                                        <th class=""><a>Name</a></th>
                                        <td><?php echo (!empty($enquiry->name) ? $enquiry->name : '') ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Phone</a></th>
                                        <td><?php echo (!empty($enquiry->phone) ? $enquiry->phone : '') ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Email</a></th>
                                        <td><?php echo (!empty($enquiry->email) ? $enquiry->email : '') ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Date</a></th>
                                        <td><?php echo (!empty($enquiry->created->format('H:m:i d-m-Y')) ? $enquiry->created->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>

                                    <tr class="table-header">

                                        <th class="" width=""><a>Subject</a></th>
                                        <td><?php echo (!empty($enquiry->subject) ? $enquiry->subject : '') ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Message</a></th>
                                        <td><?php echo (!empty($enquiry->message) ? $enquiry->message : '') ?></td>
                                    </tr> -->



                                    <tr class="table-header">
                                        <th class="" width=""><a>Date</a></th>
                                        <td><?php echo (!empty($enquiry->created->format('H:m:i d-m-Y')) ? $enquiry->created->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <?php
                            /*
                            if (!empty($enquiry->branch)) { ?>
                                <h3>Branch Details</h3>
                                <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                    <tbody>
                                        <tr class="table-header">
                                            <th class=""><a>Name</a></th>
                                            <td><?php echo (!empty($enquiry->branch->name) ? $enquiry->branch->name : '') ?></td>
                                        </tr>

                                        <tr class="table-header">
                                            <th class="" width=""><a>Phone</a></th>
                                            <td><?php echo (!empty($enquiry->branch->phone) ? $enquiry->branch->phone : '') ?></td>
                                        </tr>

                                        <tr class="table-header">
                                            <th class="" width=""><a>Email</a></th>
                                            <td><?php echo (!empty($enquiry->branch->email) ? $enquiry->branch->email : '') ?></td>
                                        </tr>


                                        <tr class="table-header">

                                            <th class="" width=""><a>Address</a></th>
                                            <td><?php echo (!empty($enquiry->branch->address) ? $enquiry->branch['address'] . ', ' . $enquiry->branch['city'] . ', ' . $enquiry->branch['state'] . ', ' . $enquiry->branch['postcode'] . ', ' . $enquiry->branch['country'] : '') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php }
                            */
                            ?>
                        </div>

                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>