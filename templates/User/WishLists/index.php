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
echo $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'gridContainerCols'=>2]);
