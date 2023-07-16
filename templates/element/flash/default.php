<?php

/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- <div class="<?= h($class) ?>" onclick="this.classList.add('hidden');"><?= $message ?></div> -->

<!-- start remodal sections  -->
<div class="remodal comfirmDetails successModal" data-remodal-id="FlashMessagePop" id="FlashMessagePop" data-remodal-options="hashTracking: false, closeOnOutsideClick" style="display:none;">
    <div class="CDhead">
        <h2></h2>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div><!-- end head  -->
    <div class="CDbody">
        <div class="successSection">
            <img src="" alt="" class="showHideSuccess">
            <p>
                <?= $message ?>
            </p>
        </div>

    </div><!-- end body  -->
</div>