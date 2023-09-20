<div class="col-md-12">
    <div class="counselor-points">
        <div class="d-flex">
            <div class="container-boxsPoints">
                <div class="item">
                    <div class="circle-point"><?= $counselor['number_joined_students'] ?></div>
                    <h4>Joined Successfully</h4>
                </div>
                <div class="item">
                    <div class="circle-point"><?= $counselor['number_of_students'] ?></div>
                    <h4>Applied</h4>
                </div>
                <div class="item">
                    <div class="circle-point"><?= $counselor['total_points'] ?></div>
                    <h4>Points Acquired</h4>
                </div>
                <div class="item">
                    <div class="circle-point text-success">$<?= number_format($counselor['total_points_reward'], 0) ?></div>
                    <h4>Total Gain</h4>
                </div>
            </div>

            <div class="box-text">
                <a href="/counselor/withdraw">Withdraw</a>
                <a href="/counselor/points">Counselor Points</a>
            </div>
        </div>
    </div>
</div>