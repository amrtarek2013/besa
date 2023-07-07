<?php
$content = $page['content'];
$_SESSION["videos_gallery_counter"] = 0;


if (!empty($slideshows)) {
    echo $this->Html->script(array('jquery-easing', 'coda-slider'));
    $this->Html->css('coda-slider', false, false, false);
    foreach ($slideshows as $slideshow) {
        $content = preg_replace('/\\[\\{SLIDESHOW:\s?' . $slideshow['Slideshow']['id'] . '[^\\}]*\\}\\]/i', $this->element('slideshow', array('slideshow' => $slideshow)), $content);
    }
    ?>

    <script type="text/javascript">
        $(function () {
            $(".codaslider").codaSlider({
                autoSlide: true
            });
            $('.stripNav').each(function () {
                $(this).css('width', $('li', this).length * 20 + 12);
            });
        });



    </script>

    <?php
}

if (!empty($videos)) {
    echo $this->Html->script(array('video/swfobject'));
    foreach ($videos as $video) {
        $content = preg_replace('/\\[\\{VIDEO:\s?' . $video['Video']['id'] . '[^\\}]*\\}\\]/i', $this->element('video-player', array('video' => $video)), $content);
    }
}
?>

<div class="Pagescontainer">

    <?php
    $class = "landing-content";
    if (isset($page['enable_scroller']) && $page['enable_scroller']) {
        $class = "pages-scroll";
    }
    ?>
    <div class="<?php echo $class ?>">
        <?php
        if (isset($page['enable_scroller']) && $page['enable_scroller']) {
            $class = "pages-scroll";
            ?>

            <div class="scroll-pane">
                <div class="scroll-pane-inner">
                <?php } ?>

                <?php
                preg_match_all("/{PageSection_([a-zA-Z0-9_-]+)_%(\d+)\-?[\s\S]*?%_?(\d*)_?([^_]*)_?([^_]*)}/", $content, $matches);
                if (!empty($matches[2])) {
                    foreach ($matches[2] as $key => $value) {
                        if ($matches[3][$key] || (!empty($matches[4][$key]) && strtotime(str_replace('/', '-', $matches[4][$key])) < time() && !empty($matches[5][$key]) && strtotime(str_replace('/', '-', $matches[5][$key])) > time() )) {
                            if(!empty($_GET['test'])){
                                echo $this->element('page_sections/' . $matches[1][$key],
                                 compact('value'));

                            }else{

                                echo $this->element('page_sections/' . $matches[1][$key], array(
                                    "value" => $value,
                                    'permalink'=>$matches[1][$key],
                                    'cache' => array("time" => "1 hour", "key" => $value)
                                 ));
                                
                            }
                        }
                    }
                } else {
                    echo $content;
                }

                ?>
                <?php if (isset($page['enable_scroller']) && $page['enable_scroller']) { ?>
                </div>
            </div>

        <?php } ?>
    </div>

</div>



<?php if (!empty($homefilldata)) { ?>
    <?php echo $this->element('HomeFillData'); ?>
<?php } ?>
<?php echo $this->Html->script(array('jScrollPane', 'jquery.mousewheel')); ?>
<script>
    $(window).load(function () {
<?php if ($page['enable_scroller']) { ?>
            $('.scroll-pane').jScrollPane();
<?php } ?>
    });

</script>

<?php
if(isset($page['id']))
$this->set('selectedPageId', $page['id']);
if(isset($topLink))
$this->set('selectedLink', $topLink);
if(isset($page['permalink'])){
  if (file_exists(WWW_ROOT . 'css' . DS . $page['permalink'] . '.css')) {
    echo $this->Html->css($page['permalink'], false, false, false);
}
if (file_exists(WWW_ROOT . 'js' . DS . $page['permalink'] . '.js')) {
    echo $this->Html->script($page['permalink']);
}  
}




