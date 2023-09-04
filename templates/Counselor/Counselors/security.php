<style>
    .iti {
        left: 10px;
        position: absolute !important;
        bottom: 55px;
    }
</style>
<section class="main-banner register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Security</h2>
            </div>
        </div>
        <div class="row">
            <?= $this->Form->create($counselor, array('type' => 'file', 'id' => 'FormProfile')); ?>
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Update Your Password</h4>
                    <div class="grid-container">


                        <?= $this->Form->control('password', [
                            'type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => 'off', 'label' => 'Password*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('passwd', [
                            'type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="container-submit">
                    <button type="submit" class="btn clear-blue">Update</button>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>