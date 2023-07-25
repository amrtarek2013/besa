<div class="form-area security_code">
    <div class="input captcha" style="position: relative;">
        <?php
        echo $this->Html->image('/image.jpg/index.php?code=' . mt_rand(9999, 999999), array('class' => 'SecurImage', 'style' => "left: 13px;position: absolute;top: 10px;
                        z-index: 1; height:40px", 'id' => rand()));
        echo $this->Form->control('security_code', [
            'placeholder' => 'Security Code', 'type' => 'text', 'required' => true,
            'class' => 'required', 'style' => "padding-left: 190px;", 'label' => false,
            'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
        ]);
        if (!empty($error_captcha)) :
        ?>
            <div class='error-message'><?= $error_captcha ?></div>
        <?php endif; ?>
    </div>
</div>