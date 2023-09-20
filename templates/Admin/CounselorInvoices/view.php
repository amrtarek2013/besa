<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('View Counselor Invoice') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('View Counselor Invoice') ?></li>
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
                            <h3 class="card-title"><?= __('View Counselor Invoice #' . $counselorInvoice['id']) ?></h3>
                        </div>
                        <div class='FormExtended'>
                            <!-- <h3>User Details</h3> -->
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>
                                    <tr class="table-header">

                                        <th class="" width=""><a>#ID</a></th>
                                        <td><?php echo $counselorInvoice->id ?></td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Counselor</a></th>

                                        <td><?php echo $counselorInvoice->counselor->first_name ?></td>

                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Number Of Points</a></th>
                                        <td><?= $counselorInvoice->total_points ?>
                                        </td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Total</a></th>
                                        <td>$<?= $counselorInvoice->total ?>
                                        </td>
                                    </tr>


                                    <tr class="table-header">
                                        <th class="" width=""><a>Payment Method</a></th>
                                        <td><?= $paymentMethods[$counselorInvoice->payment_method] ?></td>
                                    </tr>

                                    <?php foreach ($paymentMethodFields[$counselorInvoice->payment_method] as  $fName => $fLabel) { ?>

                                        <tr class="table-header">
                                            <th class="" width=""><a><?= $fLabel ?></a></th>
                                            <td><?= $counselorInvoice[$fName] ?></td>
                                        </tr>
                                    <?php } ?>


                                    <tr class="table-header">
                                        <th class="" width=""><a>Request Date</a></th>
                                        <td><?php echo (isset($counselorInvoice->created) ? $counselorInvoice->created->format('d/m/Y H:m:i') : '---') ?>
                                        </td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Paid</a></th>
                                        <td><?php echo $counselorInvoice->is_paid ? 'Yes' : 'No' ?></td>
                                        </td>
                                    </tr>

                                    <tr class="table-header">
                                        <th class="" width=""><a>Payment Date</a></th>
                                        <td><?php echo (isset($counselorInvoice->comment_time) ? $counselorInvoice->comment_time->format('d/m/Y H:m:i') : '---') ?>
                                        </td>
                                    </tr>


                                    <tr class="table-header">
                                        <th class="" width=""><a>Transaction File</a></th>
                                        <td><?= !empty($counselorInvoice->transaction_file) ? '<a target="_blank" href="'.WEBSITE_PATH . '/uploads/files/counselor_invoices/'.$counselorInvoice->transaction_file.'" >Download</a>' : '---' ?></td>
                                    </tr>
                                    <tr class="table-header">
                                        <th class="" width=""><a>Status</a></th>
                                        <td>
                                            <div class="row">

                                                <?php
                                                echo $this->AdminForm->create($counselorInvoice, ['type' => 'file', 'url' => '/admin/counselor-invoices/edit/' . $counselorInvoice->id . '/view', 'id' => 'UpdateAdminForm']);

                                                echo $this->AdminForm->control('id', ['type' => 'hidden', 'value' => $counselorInvoice->id]) ?>
                                                <div class="col-md-12">
                                                    <?= $this->AdminForm->control('is_paid', ['label' => false, 'type' => 'select', 'empty' => 'Status', 'options' => [1 => 'Yes', 0 => 'No']]) ?>
                                                    <?= $this->AdminForm->control('transaction_file', ['type' => 'file']) ?>
                                                    <?= $this->AdminForm->control('comment', ['type' => 'textarea']) ?>

                                                    <button type="submit" class="btn btn-primary"><?= __('Update') ?> </button>
                                                </div>
                                                <?= $this->AdminForm->end() ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="container-table">
                            <?php if (!empty($counselorInvoice['counselor_rewards'])) { ?>
                                <h5 class="title-table">Students Points</h5>
                                <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                    <tbody>
                                        <tr class="table-header">
                                            <th class=""><a>Student</a></th>
                                            <th class=""><a>Points</a></th>
                                            <th class=""><a>Points per Dollar</a></th>
                                            <th class=""><a>Total</a></th>
                                            <th class=""><a>Date</a></th>
                                            <th class=""><a>Paid</a></th>
                                        </tr>
                                        <?php
                                        foreach ($counselorInvoice['counselor_rewards'] as $key => $counselorReward) :

                                        ?>
                                            <tr>
                                                <td><?php echo $counselorReward->user->first_name ?></td>
                                                <td><?php echo $counselorReward->points ?></td>
                                                <td><?php echo $counselorReward->number_points_dollar ?></td>
                                                <td>$<?php echo number_format($counselorReward->total) ?></td>
                                                <td><?php echo $counselorReward->created->format('d/m/Y H:i:s a') ?></td>
                                                <td><?php echo $counselorReward->is_paid ? 'Yes' : 'No' ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td></td>
                                            <td><?= $counselorInvoice->total_points ?></td>
                                            <td></td>
                                            <td>$<?php echo number_format($counselorInvoice->total) ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>