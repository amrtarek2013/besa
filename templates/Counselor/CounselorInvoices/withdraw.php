<style>
    .container-formBox .grid-container {
        display: -ms-grid;
        display: grid;
        -ms-grid-columns: 1fr 1fr;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
    }

    select {
        background-position-x: calc(100% - 8px) !important;
    }


    .methods {
        display: none;
    }

    .counselor-points {
        margin-top: 5px !important;
        margin-bottom: 30px !important;
    }
</style>
<section class="main-banner register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Withdraw</h2>
            </div>
        </div>
        <div class="row">

            <?= $this->element('points', ['counselor' => $counselor]) ?>
        </div>

        <div class="row">
            <?= $this->Form->create($counselorInvoice, array('type' => 'file', 'id' => 'FormProfile')); ?>
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Request Withdraw</h4>

                    <div class="grid-container">

                        <?= $this->Form->control('payment_method', [
                            'placeholder' => 'Payment Method*', 'label' => 'Payment Method*', 'required' => true,
                            'type' => 'select', 'empty' => 'Payment Method', 'options' => $paymentMethods,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                    </div>
                    <div class="grid-container">


                        <?= $this->Form->control('bank_name', [
                            'placeholder' => 'Bank Name', 'class' => 'form-area', 'label' => 'Bank Name*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}} methods method1">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('bank_acount', [
                            'placeholder' => 'Bank Account', 'class' => 'form-area', 'label' => 'Bank Account*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}} methods method1">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('instapay', [
                            'placeholder' => 'Instapay Account', 'class' => 'form-area', 'label' => 'Instapay Account*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}} methods method2">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('wallet_mobile', [
                            'placeholder' => 'Mobile Wallet', 'class' => 'form-area', 'label' => 'Mobile Wallet*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}  methods method3">{{content}}</div>']
                        ]) ?>
                        <!-- <?= $this->Form->control('id_number', [
                                    'placeholder' => 'ID Number', 'class' => 'form-area', 'label' => 'ID Number*',
                                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                                ]) ?>

                        <?= $this->Form->control('id_file', [
                            'type' => 'file',
                            'placeholder' => 'Upload ID', 'class' => 'form-area', 'label' => 'Upload ID*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?> -->


                        <?php
                        // echo $this->AdminForm->control('image', [
                        //     'label' => 'Profile Picture', 'type' => 'file', 'between' => $this->element('image_input_between', [
                        //         'data' => $counselor,
                        //         'field' => 'image',
                        //         'info' => [
                        //             'width' => $uploadSettings['image']['width'],
                        //             'height' => $uploadSettings['image']['height'],
                        //             'path' => $uploadSettings['image']['path']

                        //         ],
                        //     ]),

                        //     'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        // ]);
                        ?>

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
<script>
    $('#payment-method').on('change', function() {
        let val = $(this).val();
        $('.methods').hide();
        if (val != '') {
            $('.methods').hide();
            $('.method' + val).show();
        }
    });
</script>