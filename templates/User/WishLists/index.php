<style>
    .row-result .container {
        width: 96% !important;
    }

    .grid-container-3col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 50px;
    }
</style>
<?php 
if(isset($_GET['dk']))
    dd($wishLists);
    if(empty($wishLists)) { { ?>
        <div class="empty-state">
              <img src="<?=WEBSITE_URL?>img/new-desgin/empty.png" alt="">
              <p>there’s no items in wishlist now</p>
          </div>
          
        <?php } } else {
          echo $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'gridContainerCols' => 2]);
      }


?>
