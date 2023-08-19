<div class="logo_image">

    <?php if (false) { ?>
        <p class="NameOfImge">
            <span>choose file</span>
        </p>
    <?php } ?>

    <?php
    $pField = $field . '_path';

    if ($info['width'] > 0 && $info['height'] > 0) { ?>
        <p class="hint image_desc">Image size: <?= $info['width'] ?>px X <?= $info['height'] ?>px </p>
    <?php } else if ($info['width'] > 0) { ?>
        <p class="hint image_desc">Image width: <?= $info['width'] ?>px </p>
    <?php } else if ($info['height'] > 0) { ?>
        <p class="hint image_desc">Image hight: <?= $info['height'] ?>px </p>
    <?php } ?>

    <?php if (isset($data) && !$data->isNew()) {
        $base_name = basename($data->{$field});
    ?>
        <div class="PreviewImg">
            <?php if ($base_name && !is_array($base_name)) { ?>
                <!-- <span class="image_base_name"><?= $base_name ?></span> -->
                <?php

                $imagePath = $this->Url->build('/' . $info['path'] . '/' . $base_name);

                $fpath = WWW_ROOT . $imagePath;
                $fpath = trim(str_replace("//", "/", $fpath));
                if (!empty($_GET['test1'])) {
                    print_r($info);
                    die;
                }
                if (file_exists($fpath)) {
                ?>
                    <a target="_blank" href="<?= $imagePath ?>"><i class="fas fa-eye"></i> <?= __('Preview') ?></a>
                    <!-- <a target="_blank"   href="<?= $this->Url->build(array('action' => 'delete_field', 'image', $data->id, $field)) ?>"> <span class="icon-trash"></span> Delete</a> -->
            <?php
                }
            }
            ?>
        </div>
    <?php } ?>

</div>


<?php if ($field != "icon") { ?>
    <!-- AO fixing issues of name of image with a new XD -->
    <script type="application/javascript">
        $(document).ready(function() {


            $('input[type="file"]').change(function(e) {
                e.preventDefault();
                var val = e.target.files[0].name;
                $(this).parent().find('.NameOfImge span').text('file name :' + val);
                //                $(this).text('file name :'+val);
                //                alert(val)
            });
            $('.NameOfImge').unbind('click').bind('click', function(event) {
                event.preventDefault();
                //                $(this).parent().find('input').trigger('click');
                $(this).parents('.file').find(':input').trigger("click");
            })
            $('.PreviewImg').parents('.file').addClass('forPadding');
            $('.PreviewImg:nth-child(2)').parent().parent().closest('div').addClass('fix-overlapping')

        });
    </script>
<?php } ?>