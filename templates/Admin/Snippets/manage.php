<style type="text/css">
    .form-group.file {
        position: inherit;
    }

    .forPadding .NameOfImge {
        display: none;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Snippets') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Snippets') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Snippet') ?></h3>
                        </div>

                        <?= $this->AdminForm->create($snippet, ['type' => 'file']); ?>
                        <div class="card-body">
                            <?php
                            if ($snippet->editor_type == 1) {
                                $class = 'editor basicEditor';
                            } elseif ($snippet->editor_type == 2) {
                                $class = 'editor';
                            } else {
                                $class = ' ';
                            }


                            echo $this->AdminForm->control('title');
                            echo $this->AdminForm->control('category', ['empty' => 'Please select Category', 'options' => $categories]);
                            echo $this->AdminForm->control('content', ['class' => $class]);

                            echo $this->AdminForm->control('active', ['type' => 'checkbox']);
                            echo $this->AdminForm->enableEditors('.editor');

                            ?>
                            <?php /*if (!empty($snippet->category)) { ?>
                                <div class="form-group col-md-12">
                                    <p for="layout-iddfsdf">Users popup</p>
                                    <p for="layout-iddfsdf">Note: To open User login/register ... popups</p>
                                    <p for="layout-iddfsdf">Add the following to your html link or button <strong>data-remodal-target="put popup ID here"</strong></p>
                                    <p for="layout-iddfsdf"><?= htmlentities('e.g.: <a data-remodal-target="registerbox" href="javascript:return 0;">Register</a>') ?></strong></p>
                                    <div class="row">
                                        <?php
                                        if (!empty($modalPopupIDs)) {
                                            foreach ($modalPopupIDs as $key => $value) {
                                        ?>
                                                <div class="form-group col-md-4">
                                                    
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php }*/ ?>

                            <?php
                            // echo $this->AdminForm->control('image', ['label' => 'PopupImage', 'type' => 'file', 'between' => $this->element('image_input_between', [
                            //     'data' => $snippet,
                            //     'field' => 'image',
                            //     'info' => [
                            //         'width' => $uploadSettings['image']['width'],
                            //         'height' => $uploadSettings['image']['height'],
                            //         'path' => $uploadSettings['image']['path']

                            //     ],
                            // ])]);
                            ?>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    // $(document).ready(function() {
    //     var focus_place;

    //     (function($) {
    //         $.fn.getCursorPosition = function() {
    //             var input = this.get(0);
    //             if (!input)
    //                 return; // No (input) element found
    //             if ('selectionStart' in input) {
    //                 // Standard-compliant browsers
    //                 return input.selectionStart;
    //             } else if (document.selection) {
    //                 // IE
    //                 input.focus();
    //                 var sel = document.selection.createRange();
    //                 var selLen = document.selection.createRange().text.length;
    //                 sel.moveStart('character', -input.value.length);
    //                 return sel.text.length - selLen;
    //             }
    //         }
    //     })(jQuery);

    //     (function($) {
    //         $.fn.setCursorPosition = function(selectionStart, selectionEnd) {
    //             var input = this.get(0);
    //             // IE
    //             if (input.createTextRange) {
    //                 var range = input.createTextRange();
    //                 range.collapse(true);
    //                 range.moveEnd('character', selectionEnd);
    //                 range.moveStart('character', selectionStart);
    //                 range.select();
    //                 // real browsers :)
    //             } else if (input.setSelectionRange) {
    //                 input.focus();
    //                 input.setSelectionRange(selectionStart, selectionEnd);
    //             }
    //             return this;
    //         }
    //     })(jQuery);



    //     $('a.add-placeholder').click(function(evt) {
    //         var elem = this;
    //         var txt = $(elem).find('strong').text();

    //         if ($(this).data('subject-position') !== null) {
    //             $(focus_place).val(function(i, v) {
    //                 return v.substring(0, $(elem).data('subject-position')) + txt + v.substring($(elem).data('subject-position'));
    //             });
    //             $(focus_place).setCursorPosition($(elem).data('subject-position') + txt.length, txt.length);
    //             $(focus_place).focus();
    //         } else {
    //             $(focus_place).val(function(i, v) {
    //                 return CKEDITOR.instances['content'].insertText(txt);
    //             });
    //             $(focus_place).focus();
    //         }
    //         evt.preventDefault();
    //     });

    //     $('a.add-placeholder').mouseenter(function() {
    //         if ($('.subjectInput').is(':focus')) {
    //             $(this).data('subject-position', $('.subjectInput').getCursorPosition());
    //             focus_place = '.subjectInput';
    //         } else {
    //             $(this).data('subject-position', null);
    //             $(this).data('subject-positionarea', $('.subjectInput').getCursorPosition());
    //             focus_place = '.textarea';
    //         }
    //     });

    // });
</script>