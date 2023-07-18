<section class="steps-en">
    <div class="container">
        <div class="col-md-12">
            <div class="steps-background">
                <div class="timeline">
                    <div class="timeline-item active">
                        <span>LEVEL</span>
                    </div>
                    <div class="timeline-item">
                        <span>COURSE</span>

                    </div>
                    <div class="timeline-item">
                        <span>WHERE</span>
                    </div>
                    <div class="timeline-item">
                        <span>WHERE</span>
                    </div>
                </div>
                <div class="step-container">
                    <div id="step1" class="step active">
                        <!-- Step 1 content here -->
                        <h2 class="title">WHICH STUDY LEVEL?</h2>
                        <div class="form-area">
                        <?php  if (!empty($servicesSearchList)){ ?>
                            <select name="service_id" id="service_id">
                            <?php foreach ($servicesSearchList as $i => $service){?>
                                <option value="<?=$service['id']?>"><?= $service['title'] ?></option>
                            <?php } ?>
                            </select>                                
                        <?php } ?>
                        </div>
                    </div>
                
                    <div id="step2" class="step">
                        <!-- Step 2 content here -->
                            
                        <div class="services-2 services-4">
                            <h2 class="title">WHAT COURSE DO YOU WANT TO STUDY?</h2>
                            <div class="grid-contaienr">
                                <?php if(!empty($studyCourses)){ ?>
                                <?php foreach ($studyCourses as $studyCourse_id => $studyCourse_value) {?>
                                <div class="box" title='<?=$studyCourse_value?>'>
                                    <h4><?=words_slice($studyCourse_value,4)?></h4>
                                </div>
                                <?php } ?>
                                <?php } ?>
                                
                            </div>
                        </div>

                    </div>
                
                    <div id="step3" class="step">
                        <!-- Step 3 content here -->
                        <h2 class="title">WHERE DO YOU WANT TO STUDY?</h2>
                        <div class="grid-contaienr contaienr-checkbox">
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">UNITED KINGDOM</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">USA</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">CANADA</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">AUSTRALIA</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">LITHUANIA</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">SPAIN</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">GERMANY</label>
                            </div>
                            <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">RUSSIA</label>
                            </div>
                             <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">HUNGARY</label>
                            </div>
                             <div class="checkbox-green">
                                <input type="checkbox" name="" id="">
                                <label for="">MALAYSIA</label>
                            </div>
                        </div>

                    </div>
                    <div id="step4" class="step">
                        <!-- Step 4 content here -->
                        <h2 class="title">WHAT’S YOUR BUDGET?</h2>
                        <div class="range-wrapper">
                            <div class="output-range">
                                <span id="slider-value">$1000 </span>
                                <span id="max-val">$100,000 </span>

                            </div>
                            <div id="slider_range_blue"></div>
                            <div class="minAndMax">
                                <span class="min-name">Min </span>
                                <span class="max-name">Max </span>
                            </div>

                            <script>
                                     var slider = document.getElementById('slider_range_blue');
                                    var sliderValueElement = document.getElementById('slider-value');
                                    var maxValElement = document.getElementById('max-val');

                                    noUiSlider.create(slider, {
                                        start: [500, 8500],
                                        connect: true,
                                        range: {
                                        min: 0,
                                        max: 10000
                                        }
                                    });

                                    slider.noUiSlider.on('update', function(values, handle) {
                                        sliderValueElement.innerHTML = "£ " + Math.round(values[0]);
                                        maxValElement.innerHTML = "£" + Math.round(values[1]);
                                    });

                                    
                            </script>                                  
      
                        </div>
                </div>
               <!-- Buttons to navigate between steps -->
                <div id="buttons">
                    <button id="prevBtn">Previous</button>
                    <button id="nextBtn">Next <img src="/img/new-images/chevron-left.png" alt=""> </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->Html->script([
    '/js/new-js/script-steps-en.js'
]) ?>