<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Menus') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Menus</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action'))) ?> <?= __(ucfirst($this->getRequest()->getParam('controller'))) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="FormExtended">
                                <?php
                                $action = $this->request->getParam('action');
                                echo $this->AdminForm->create($menu, ['id' => $action . 'Form']);
                                echo $this->AdminForm->control('title', ['type' => 'text']);
                                echo $this->AdminForm->control('link', ['type' => 'text']);
                                echo $this->AdminForm->control('icon', ['type' => 'text']);
                                ?>
                                <!-- <span id="showIcon"></span> -->
                                <?php
                                echo $this->AdminForm->control('display_order', ['type' => 'text']);
                                echo $this->AdminForm->control('parent_id', ['type' => 'select', 'class' => 'select2', 'options' => $menuList]);
                                echo $this->AdminForm->control('prefix', ['label' => __('Menu For'), 'empty' => 'Please Select area', 'type' => 'select', 'options' => $prefixs]);
                                echo $this->AdminForm->control('type', ['label' => __('Link Type'), 'empty' => 'Please Select Type', 'type' => 'select', 'options' => $types]);
                                echo $this->AdminForm->control('permission_id', ['label' => __('Permission'), 'class' => 'select2', 'empty' => 'Select', 'type' => 'select']);
                                // echo $this->AdminForm->control('roles', ['class' => 'form-control select2', 'type' => 'select', 'empty' => 'Select', 'options' => $roles, 'multiple' => true, 'label' => __('Role'), 'required' => true]);
                                echo $this->AdminForm->control('active');

                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php
                            if (!$menu->isNew()) {
                                echo $this->element('save_as_new', array($menu));
                            }
                            ?>
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
echo $this->Html->css(array('select2'));
echo $this->Html->script(array('select2'));
?>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/js-yaml/3.13.1/js-yaml.min.js"></script> -->

<script>
    $(".select2").select2({});

    // function iconFun(iconTag) {
    //     $('#showIcon .fa').css('background-color', '');
    //     $('#showIcon .fab').css('background-color', '');
    //     iconTag.css('background-color', 'rgb(183, 133, 144)');
    //     var iconClass = iconTag.attr('class');
    //     var tag = "<i class='" + iconClass + "'></i>";
    //     $('#icon').val(tag);
    // }
    // $.get('https://github.com/FortAwesome/Font-Awesome/blob/v4.7.0/src/icons.yml', function(data) {
    //     var parsedYaml = jsyaml.load(data);
    //     console.log(parsedYaml.icons);
    //     $.each(parsedYaml.icons, function(index, icon) {
    //         if (jQuery.inArray('Brand Icons', icon.categories) >= 0) {
    //             $('#showIcon').append("<i onClick='iconFun($(this))' class='fab fa-" + icon.id + "' ></i>  ");
    //         } else {
    //             $('#showIcon').append(" <i onClick='iconFun($(this))' class='fa fa-" + icon.id + "'></i>  ");
    //         }
    //     });
    // });
</script>