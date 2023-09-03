<style type="text/css">
    label[for=add-to-main] {
        text-transform: inherit !important;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Pages') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Pages') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . '  Page') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($page, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            // echo $this->AdminForm->create($page, ['id' => 'addPageForm']);
                            // echo $this->AdminForm->control('top_menu_link_id',['type'=>'text']);
                            echo $this->AdminForm->control('id', array());
                            echo $this->AdminForm->control('title', ['type' => 'text']);


                            ?>


                            <div class="card card-primary card-outline">

                                <div class="card-body">
                                    <h4>Page will act as</h4>
                                    <ul class="nav nav-tabs" id="OpenPage-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="OpenPage-tab" data-toggle="pill" href="#OpenPage" role="tab" aria-controls="OpenPage" aria-selected="true">Content Page</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="OpenLink-tab" data-toggle="pill" href="#OpenLink" role="tab" aria-controls="OpenLink" aria-selected="false">Just a Link</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane fade show active" id="OpenPage" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">


                                            <?php echo $this->AdminForm->control('content', ['type' => 'textarea', 'class' => 'editor' .' addFrontCss', 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'placeholder' => 'content']); ?>
                                            <?php
                                            echo $this->AdminForm->control('keywords', array('class' => 'INPUT', 'label' => __("Meta Keywords", true)));
                                            echo $this->AdminForm->control('description', array('class' => 'INPUT', 'label' => __("Meta description", true)));
                                            ?>
                                        </div>

                                        <div class="tab-pane fade show" id="OpenLink" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                            <?php echo $this->AdminForm->control('url', array('class' => 'INPUT', 'label' => 'URL')); ?>
                                            <?php echo $this->AdminForm->hidden('is_url', array('class' => 'INPUT', 'id' => 'is_url', 'label' => __('Is URL', true))); ?>
                                        </div>
                                        <div class="testTabs">
                                            <?php

                                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                                            echo $this->AdminForm->control('main_page', ['type' => 'checkbox']);

                                            echo $this->AdminForm->enableEditors('.editor');


                                            // echo "<div id='MenuList' style='display:none;'>";
                                            // echo $this->AdminForm->control('menu_id', array('id' => 'SelectMenu', 'class' => 'INPUT', 'empty' => 'No Parent'));
                                            // echo $this->AdminForm->control('submenu_id', array('id' => 'PageSubmenuId', 'options' => array(), 'empty' => 'No Submenu'));
                                            // echo "</div>";

                                            echo $this->AdminForm->control('enable_scroller', ['type' => 'checkbox']);
                                            echo $this->AdminForm->control('display_order', array('class' => 'INPUT'));

                                            ?>
                                        </div>
                                        <?php
                                        echo $this->AdminForm->control('add_to_main_menu', array('type' => 'checkbox', 'id' => 'add-to-main', 'label' => 'In Menu (this does not add the page to the menu, it is just a flag)'));


                                        echo $this->AdminForm->control('banner_image', ['label' => 'Banner Image', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                            'data' => $page,
                                            'field' => 'banner_image',
                                            'info' => [
                                                'width' => $uploadSettings['banner_image']['width'],
                                                'height' => $uploadSettings['banner_image']['height'],
                                                'path' => $uploadSettings['banner_image']['path']

                                            ],
                                        ])]);

                                        // //commentimageupload echo $this->AdminForm->enableAjaxUploads($id, 'page_' . $id, $mainAdminToken);

                                        ?>
                                    </div>


                                </div>
                                <!-- /.card -->
                            </div>

                            <?php



                            ?>
                        </div>
                        <div class="card-footer">
                            <?php
                            if (!$page->isNew()) {
                                echo $this->element('save_as_new', array($page));
                            }
                            ?>

                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>

                            <button id="preview-page" type="button" class="SaveAsNew preview-page btn btn-primary"><?php echo __('Preview') ?></button>

                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>


<?php
echo $this->Html->script('chosen.jquery');
echo $this->Html->css('chosen');
?>
<script type="text/javascript">
    $(".chzn-select").chosen();
</script>
<?php
echo $this->Html->css(array('jquery-ui'));
echo $this->Html->script(array('jquery-ui'));

$form_sections = [];


$off_elements = "'" . implode("','", $form_sections) . "'";

?>

<script type="text/javascript">
    $(function() {
        $('#permanent').on('change', function() {
            if ($(this).val() == 1) {
                $('#Dates').hide();
                $('#Dates input').prop('disabled', 'disabled');
            } else {
                $('#Dates').show();
                $('#Dates input').removeAttr('disabled');
            }
        });
        $('#preview-page').on('click', function() {
            $form = $("<form>", {
                action: '<?php echo \Cake\Routing\Router::url('/admin/pages/preview') ?>',
                method: 'post',
                target: '_blank'
            });
            $content = CKEDITOR.instances.content;
            $data = $content.getData();
            $('<input>').attr({
                type: 'hidden',
                name: '_csrfToken',
                value: _csrfToken
            }).appendTo($form);

            $('<input>').attr({
                type: 'hidden',
                name: 'content',
                value: $data
            }).appendTo($form);
            $form.appendTo(document.body).submit();
        });

    })
</script>

<script type="text/javascript">
    //    var email_templates =<?php // $javascript->object($template_details);
                                ?>;



    function loadTemplate(id) {
        var oEditor = CKEDITOR.instances.content;
        var OldText = oEditor.GetHTML();
        var NewText = (id) ? OldText : "";
        if (OldText) {
            if (confirm('Are you sure you want to update page content?')) {
                NewText = (id) ? email_templates[id].html : "";
                oEditor.SetHTML(NewText);
            }
        } else {
            NewText = email_templates[id].html;
            oEditor.SetHTML(NewText);
        }

    }
</script>



<script type="text/javascript">
    function check_menu_list() {
        if ($('#add-to-main').is(':checked')) {
            $('#MenuList').show();
        } else {
            $('#MenuList').hide();
        }
    }
    $(function() {

        check_menu_list();
        $('#add-to-main').click(function() {
            check_menu_list();
        });

        $('#OpenLink').hide();

        $('#OpenLink-tab').bind('click', function() {
            $('#OpenLink').fadeIn().addClass('forTestTabs');
            $('#is_url').val(1);
            $('#OpenPage').hide();
            $(this).addClass('active');
            $('#OpenPage').removeClass('active');
            return false;
        });

        $('#OpenPage-tab').bind('click', function() {
            $('#OpenPage').fadeIn();
            $('#OpenLink').hide().removeClass('forTestTabs');
            $(this).addClass('active');
            $('#OpenLink').removeClass('active');
            return false;
        });



        <?php if ($page->isNew()) : ?>
            $('#OpenPage').click();
        <?php endif; ?>


        <?php if (!empty($page->url)) : ?>
            $('#OpenLink').click();
        <?php else : ?>
            $('#OpenPage').click();
        <?php endif; ?>

    });
</script>

<script type="text/javascript"></script>

<script type="text/javascript">
    // $('document').ready(function() {
    //     $("#PageSubmenuId").attr("disabled", true);
    //     change_submenu($('#SelectMenu').val());
    //     if (!$('#PageSubmenuId').val()) {
    //         document.getElementById('PageSubmenuId').disabled = true;
    //         $('#PageSubmenuId').html('<option></option>');
    //     }
    //     $('#SelectMenu').change(function() {
    //         change_submenu($(this).val());
    //     });
    // });
    // Function to handle ajax.
    function change_submenu(menu_id) {
        if (!menu_id) {
            return false;
        }
        $.ajax({
            async: true,
            type: "GET",
            url: "<?php echo \Cake\Routing\Router::url('/admin/pages/get_submenus/'); ?>" + menu_id + "/" + <?php echo empty($page->id) ? 0 : $page->id; ?>,
            dataType: "json",
            success: function(data) {
                $('#PageSubmenuId').html('<option value=0>No Submenu</option>');

                for (var i = 0; i < data.submenus.length; i++) {
                    var submenu = data.submenus[i];
                    var is_Selected = "";
                    var selected_submenu = "<?php echo $page->submenu_id; ?>";
                    //alert(submenu.Submenu.id);
                    if (submenu.Page.id == selected_submenu) {
                        is_Selected = "selected=selected";
                    }
                    $('#PageSubmenuId').append('<option value="' + submenu.Page.id + '"' + is_Selected + '>' + submenu.Page.title + '</option>');

                }
                document.getElementById('PageSubmenuId').disabled = false;
                return false;
            }


        });

    }
</script>
<script>
    var pagesection = '';
    var NewText;
    var arr = [<?php echo $off_elements ?>, 'Contact', "DealershipList", "DealershipView", "DealershipNewsSocialMedia", 'Testimonial', 'BecomeMember', 'MediumSearch'];

    var freeHtmls = [];
    $(document).ready(function() {
        //  **************** KG start
        $("#PageSectionId").attr('disabled', 'disabled').hide();
        $('#CategoryIdN').change(function() {
            var category_id = $(this).val();
            // alert(category_id);


            if (category_id != '') {

                // if (PageSectionName == 'free_htmls') {
                //     $("#CategoryId").removeAttr('disabled').show();
                // } else {
                //     $("#PageSectionId").removeAttr('disabled').show();
                // }
                $("#PageSectionId").attr('disabled', 'disabled').hide();
                $.ajax({
                    async: true,
                    type: "GET",
                    url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'pages', 'action' => 'sectionsbycategory')); ?>/" + category_id,
                    dataType: "json",
                    success: function(data1) {
                        // alert(data1);
                        $("#SectionIdN").empty();
                        $("#SectionIdN").append('<option value="">Select a Section</option>');
                        $.each(data1, function(i, item) {
                            $("#SectionIdN").append('<option value="' + item.fname + '">' + item.name + '</option>');
                        });

                        return false;
                    }


                });
            } else {
                // $("#CategoryId").attr('disabled', 'disabled').hide();
                $("#PageSectionId").attr('disabled', 'disabled').hide();
            }
        });
        $('#SectionIdN').change(function() {
            var PageSectionName = $(this).val();
            var category_id = $('#CategoryIdN').val();
            pagesection = PageSectionName;

            if (arr.indexOf(PageSectionName) == -1 && PageSectionName != '') {

                // if (PageSectionName == 'free_htmls') {
                //     $("#CategoryId").removeAttr('disabled').show();
                // } else {
                //     $("#PageSectionId").removeAttr('disabled').show();
                // }

                $.ajax({
                    async: true,
                    type: "GET",
                    url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'pages', 'action' => 'pageSection')); ?>/" + PageSectionName + "/" + category_id,
                    dataType: "json",
                    success: function(data1) {
                        $("#PageSectionId").removeAttr('disabled').show();
                        $("#PageSectionId").empty();
                        $("#PageSectionId").append('<option value="">Select an Element</option>');
                        if (PageSectionName == 'Footer') {
                            $("#PageSectionId").append('<option value="1">Custom Footer</option>');
                        }
                        // else if (PageSectionName == 'free_htmls') {
                        //     freeHtmls = data1;
                        //     // $("#CategoryId").append('<option value="1">Select Category</option>');
                        //     // $.each(freeHtmls, function(i, item) {
                        //     //     $("#CategoryId").append('<option value="' + i + '">Cat_' + i + ' </option>');
                        //     // });

                        // } 
                        else {
                            $.each(data1, function(i, item) {
                                var opt_label = item.name;
                                if (PageSectionName == 'free_htmls') {
                                    opt_label = item.id + '- ' + item.name;
                                }
                                $("#PageSectionId").append('<option value="' + item.id + '">' + opt_label + '</option>');
                            });
                        }
                        return false;
                    }


                });
            } else {
                // $("#CategoryId").attr('disabled', 'disabled').hide();
                $("#PageSectionId").empty();
                $("#PageSectionId").attr('disabled', 'disabled').hide();
            }
        });
        //  **************** KG end        



        $("#CategoryId").attr('disabled', 'disabled').hide();

        $('.page-sectionp').click(function() {
            var PageSectionName = $(this).data('name');
            pagesection = PageSectionName;

            if (arr.indexOf(PageSectionName) == -1 && PageSectionName != '') {

                if (PageSectionName == 'free_htmls') {

                    $("#CategoryId").removeAttr('disabled').show();
                } else {
                    $("#PageSectionId").removeAttr('disabled').show();
                }
                $.ajax({
                    async: true,
                    type: "GET",
                    url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'pages', 'action' => 'pageSection')); ?>/" + PageSectionName,
                    dataType: "json",
                    success: function(data1) {
                        $("#PageSectionId").empty();
                        $("#PageSectionId").append('<option value="">Select an Element</option>');
                        if (PageSectionName == 'Footer') {
                            $("#PageSectionId").append('<option value="1">Custom Footer</option>');
                        } else if (PageSectionName == 'free_htmls') {
                            freeHtmls = data1;
                            // $("#CategoryId").append('<option value="1">Select Category</option>');
                            // $.each(freeHtmls, function(i, item) {
                            //     $("#CategoryId").append('<option value="' + i + '">Cat_' + i + ' </option>');
                            // });

                        } else {
                            $.each(data1, function(i, item) {
                                $("#PageSectionId").append('<option value="' + item.id + '">' + item.name + '</option>');
                            });
                        }
                        return false;
                    }


                });
            } else {
                $("#CategoryId").attr('disabled', 'disabled').hide();
                $("#PageSectionId").attr('disabled', 'disabled').hide();
            }
        });
        $('#PageSectionName').on('change', function() {

            //var PageSectionId = $("#PageSectionId :selected").val();
            alert($(this).find("option:selected").val());

        });

        $('#CategoryId').on('change', function() {
            $("#PageSectionId").empty();
            catID = $(this).find("option:selected").val();
            console.log(catID);
            console.log(freeHtmls[catID]);
            if (catID == undefined || freeHtmls[catID] == undefined) {
                console.log('test')
                $("#PageSectionId").attr('disabled', 'disabled').hide();
            } else {

                $("#PageSectionId").removeAttr('disabled').show();
                $.each(freeHtmls[catID], function(i, item) {
                    $("#PageSectionId").append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            }

        });

        $('#InsertPageSection').on('click', function() {
            var PageSectionName = pagesection;
            var PageSectionId = $("#PageSectionId :selected").val();
            var PageSectionTitle = $("#PageSectionId :selected").text();
            var PermanentDisplay = ($("#permanent").val() == 1) ? 1 : 0;

            var ActivationDate = $("#activation-date").val();
            var DeactivationDate = $("#deactivation-date").val();
            if ((!PermanentDisplay && !ActivationDate) || (!PermanentDisplay && !DeactivationDate)) {
                alert("Please select Activation Date & Deactivation Date");
                return false;
            }

            if (arr.indexOf(PageSectionName) !== -1) {
                PageSectionId = 0;
                PageSectionTitle = '';
                AddPlaceHolder(PageSectionName, PageSectionId, PageSectionTitle, PermanentDisplay, ActivationDate, DeactivationDate);
            } else if (PageSectionName && PageSectionId) {
                AddPlaceHolder(PageSectionName, PageSectionId, PageSectionTitle, PermanentDisplay, ActivationDate, DeactivationDate);
            } else {
                if (!PageSectionName) {
                    alert("Please select Page Section");
                    $("#PageSectionName").focus();
                } else if (!PageSectionId) {
                    alert("Please select an element of Page Section you selected");
                    $("#PageSectionId").focus();
                }
            }
        });



    });

    function AddPlaceHolder(modelname, elementid, PageSectionTitle, PermanentDisplay, ActivationDate, DeactivationDate) {



        NewText = "{PageSection_" + modelname + "_%" + elementid;
        if (PageSectionTitle != '') {
            NewText += "-" + PageSectionTitle;
        }

        NewText += "%_" + PermanentDisplay;

        if (ActivationDate !== "" && DeactivationDate !== "") {

            NewText += "_" + ActivationDate + "_" + DeactivationDate + "}";
        } else {
            NewText += "}";
        }

        NewText = "<p>" + NewText + "</p>";

        CKEDITOR.instances.content.insertHtml(NewText);
        return false;
    }
</script>