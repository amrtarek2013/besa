<div id="reg" class="account-info">
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-sm-12 col-xs-12">

                    <h3 class="page-title">Account Details</h3>
                    <div class="buttons">
                        <a href="/counselor/profile" class="bttn blue edit-profile"><i class="fa fa-edit fa-lg" style="    margin-right: 6px;"></i> Edit info</a>
                    </div>
                </div>
                <div class="table-account-details">
                    <table>
                        <tbody>
                            <tr>
                                <th class="account-info-label"> Display Name</th>
                                <th class="info-value"><?= $counselor['counselorname'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Full Name</th>
                                <th class="info-value"><?= $counselor['first_name'] . ' ' . $counselor['last_name'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Email</th>
                                <th class="info-value"> <?= $counselor['email'] ?> </th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Mobile</th>
                                <th class="info-value"><?= $counselor['mobile'] ?></th>
                            </tr>
                            <tr>
                                <th class="account-info-label">Address</th>
                                <th class="info-value">  <?= $counselor['address'] ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php echo $advertising_questions_section; ?>

            </div>
        </div>
    </div>
</div>