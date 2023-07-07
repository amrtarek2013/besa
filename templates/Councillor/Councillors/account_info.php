<div id="reg" class="account-info">
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-sm-12 col-xs-12">

                    <h3 class="page-title">Account Details</h3>
                    <div class="buttons">
                        <a href="/councillor/profile" class="bttn blue edit-profile"><i class="fa fa-edit fa-lg" style="    margin-right: 6px;"></i> Edit info</a>
                    </div>
                </div>
                <div class="table-account-details">
                    <table>
                        <tbody>
                            <tr>
                                <th class="account-info-label"> Display Name</th>
                                <th class="info-value"><?= $councillor['councillorname'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Full Name</th>
                                <th class="info-value"><?= $councillor['first_name'] . ' ' . $councillor['last_name'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Email</th>
                                <th class="info-value"> <?= $councillor['email'] ?> </th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Mobile</th>
                                <th class="info-value"><?= $councillor['mobile'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Address</th>
                                <th class="info-value">  <?= $councillor['address'] ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php echo $advertising_questions_section; ?>

            </div>
        </div>
    </div>
</div>