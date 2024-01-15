<div class="col-md-12">
<div class="section-stats">
    <div class="d-flex">
        <div class="stats-card">
            <h2 class="stats-card-title">Total Stats</h2>
            <div class="stats-container">
                <div class="stat-item item-blue">
                    <div class="circle-progressbar-container">
                        <svg class="circle-progressbar" width="120" height="120">
                            <circle class="circle-progressbar-background" stroke-width="10" fill="transparent" r="52" cx="60" cy="60"/>
                            <circle class="circle-progressbar-value" stroke-width="10" fill="transparent" r="52" cx="60" cy="60" data-value="38"/>
                        </svg>
                        <p class="percentage">38%</p>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">
                            <p>0</p>
                            <p>6</p>

                        </div>
                        <div class="stat-label">
                            <p>Joined successfully</p>
                            <p>6 students joined successfully</p>
                        </div>
                    </div>
                </div>

                <div class="stat-item item-yellow">
                    <div class="circle-progressbar-container">
                        <svg class="circle-progressbar" width="120" height="120">
                            <circle class="circle-progressbar-background" stroke-width="10" fill="transparent" r="52" cx="60" cy="60"/>
                            <circle class="circle-progressbar-value" stroke-width="10" fill="transparent" r="52" cx="60" cy="60" data-value="62"/>
                        </svg>
                        <p class="percentage">62%</p>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">
                            <p>19</p>

                        </div>
                        <div class="stat-label">
                            <p>Appled</p>
                            <p>19 students waiting offers from universities</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="stats-card">
            <h2 class="stats-card-title">Total Stats</h2>
            <div class="stats-container">
                <div class="stat-item item-red">
                    <div class="circle-progressbar-container">
                        <svg class="circle-progressbar" width="120" height="120">
                            <circle class="circle-progressbar-background" stroke-width="10" fill="transparent" r="52" cx="60" cy="60"/>
                            <circle class="circle-progressbar-value" stroke-width="10" fill="transparent" r="52" cx="60" cy="60" data-value="38"/>
                        </svg>
                        <p class="percentage">38%</p>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">
                            <p>0</p>
                            <p>6</p>

                        </div>
                        <div class="stat-label">
                            <p>Failed applications</p>
                            <p>6 students joined successfully</p>
                        </div>
                    </div>
                </div>

                <div class="stat-item item-green">
                    <div class="circle-progressbar-container">
                        <svg class="circle-progressbar" width="120" height="120">
                            <circle class="circle-progressbar-background" stroke-width="10" fill="transparent" r="52" cx="60" cy="60"/>
                            <circle class="circle-progressbar-value" stroke-width="10" fill="transparent" r="52" cx="60" cy="60" data-value="62"/>
                        </svg>
                        <p class="percentage">62%</p>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">
                            <p>19</p>

                        </div>
                        <div class="stat-label">
                            <p>Total Gain</p>
                            <p>6  points gained so far</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="" class=" btn MainBtn">Apply for Students <img src="<?=WEBSITE_URL?>img/new-desgin/arrow-right-white.svg"  alt="" ></a>
</div>

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


<script>
    // Function to update progress circle value
function updateProgress(circle, value) {
  const radius = circle.r.baseVal.value;
  const circumference = radius * 2 * Math.PI;
  
  circle.style.strokeDasharray = `${circumference} ${circumference}`;
  circle.style.strokeDashoffset = circumference;

  const offset = circumference - value / 100 * circumference;
  circle.style.strokeDashoffset = offset;
}

// Update the progress circles on page load
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.circle-progressbar-value').forEach((circle) => {
    const value = circle.getAttribute('data-value');
    updateProgress(circle, value);
  });
});

// Example of updating a progress circle's value dynamically
// Call this function with the new value you want to set
function changeProgressValue(statNumber, newValue) {
  const circle = document.querySelector(`.stat-number:nth-child(${statNumber}) + .circle-progressbar-container .circle-progressbar-value`);
  if (circle) {
    updateProgress(circle, newValue);
    circle.setAttribute('data-value', newValue); // Update the data-value attribute
  }
}

// Example usage: change the first stat item's progress to 50%
changeProgressValue(1, 50);

</script>