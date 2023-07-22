<div class="logo_file">

    <!-- <p class="NameOfImge">
        <span>choose file</span>
    </p> -->

    <?php

    if (isset($data) && !$data->isNew()) {

        $base_name = basename($data->{$field});

    ?>
        <div class="PreviewImg">
            <?php if ($base_name && !is_array($base_name)) :
                if (!isset($show_file_name)) {
            ?>
                    <span class="file_base_name"><?= $base_name ?></span>
                <?php
                }

                $filePath = $this->Url->build($info['path'] . DS . $base_name);

                $fpath = WWW_ROOT . $filePath;

                $fpath = trim(str_replace("//", DS, $fpath));
                $fpath = trim(str_replace("/", DS, $fpath));
                // dd($fpath);
                if (!empty($_GET['test1'])) {
                    print_r($info);
                    die;
                }
                if (file_exists($fpath)) :
                ?>
                    <a target="_blank" href="<?= $filePath ?>"><i class="fas fa-eye"></i> <?= __('Preview') ?></a>

            <?php
                endif;
            endif;
            ?>
        </div>
    <?php } ?>

</div>