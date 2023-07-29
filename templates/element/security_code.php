<div class="form-area security_code">
    <div class="input captcha" style="position: relative;">
        <?php

        $imgOptions = ['class' => 'SecurImage', 'style' => "left: 13px;position: absolute;top: 10px;
        z-index: 1; height:40px", 'id' => rand()];

        if (isset($show_label)) {
            $imgOptions['style'] = "left: 13px;position: absolute;top: 45px;
            z-index: 1; height:40px";
        }
        echo $this->Html->image('/image.jpg/index.php?code=' . mt_rand(9999, 999999), $imgOptions);
        $options = [
            'placeholder' => 'Security Code', 'type' => 'text', 'required' => true,
            'class' => 'required', 'style' => "padding-left: 190px;",
            'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
        ];

        if (!isset($show_label)) {
            $options['label'] = false;
        }
        echo $this->Form->control(
            'security_code',
            $options
        );
        if (!empty($error_captcha)) :
        ?>
            <div class='error-message'><?= $error_captcha ?></div>
        <?php endif; ?>
    </div>
</div>