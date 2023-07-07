<section class="content Config colConfig">
    <div class="row">
        <div class="col-12">
            <div class="card">

               <?php
               $session = $this->getRequest()->getSession();
               echo $this->List->filter_form($menus,$filters,[],[],$parameters,$session)?>
            </div>
            <div class="card">
            <h1>Articles</h1>
<table>
    <tr>
        <th><?php echo $this->Paginator->sort('id')?></th>
        <th><?php echo $this->Paginator->sort('title')?></th>

        <th><?php echo $this->Paginator->sort('created')?></th>

    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($menus as $menu): ?>
    <tr>
    	<td>
            <?= $menu->id ?>
        </td>
        <td>
            <?= $this->Html->link($menu->title, ['action' => 'edit', $menu->id]) ?>
        </td>
        <td>
            <?= $menu->created->format(DATE_RFC850) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
$this->Paginator->setTemplates([
        'current' => '<li class="active page-item"><a class="page-link" href="">{{text}}</a></li>',

    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>'
]);

        $paging = '<ul class="pagination pagination-sm m-0 float-right">';

        $paging .= $this->Paginator->numbers();;

        $paging .= '</ul>';
        echo $this->Html->div('paging', $paging) . $this->Html->div('clear', '');
?>

        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
        </div>
    </div>
</section>

