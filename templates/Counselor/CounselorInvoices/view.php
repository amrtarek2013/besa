<section class="register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Inovice Details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Inovice Details</h4>
                    <div class="container-table">
                        <!-- <h5 class="title-table">Student Details</h5> -->
                        <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                            <tbody>
                                <tr class="table-header">

                                    <th class="" width=""><a>#ID</a></th>
                                    <td><?php echo $counselorInvoice->id ?></td>
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
                                    <td><?php echo (isset($counselorInvoice->created) ? $counselorInvoice->created->format('d/m/Y H:m:i') : '') ?>
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

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</section>