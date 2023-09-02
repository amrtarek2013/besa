<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">


<div class="content-wrapper">

	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?= __('Children List') ?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
						<li class="breadcrumb-item active"><?= __('Children') ?></li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">

					<div class="card">
						<?php
						$session = $this->getRequest()->getSession();
						echo $this->List->filter_form($menus, $filters, [], [], $parameters, $session);
						?>
					</div>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?= __('Children List') ?></h3>
							<!-- <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= ADMIN_LINK ?>/menus/add">
								<?= __('Add new') ?>
							</a> -->
						</div>
						<?php

						$fields = [
							'basicModel' => 'menus',
							'id' => [],

							'title' => [],
							'link' => [],
							'prefix' => ['title' => 'Area', 'format' => 'get_from_array', 'options' => ['items_list' => $prefixs]],
							'display_order' => [],
							'parent_id' => ['title' => 'Parent', 'format' => 'get_from_array', 'options' => ['items_list' => $menuList]],
							'active' => ['format' => 'bool'],
						];

						// debug($menuList);

						$multi_select_actions = array(
							'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true),
						);

						$actions = [
							// 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
							'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-pencil-alt')),
							array(
								'condition' => '(!empty($row["sub_menu"]))',
								'value' => $this->Html->link(__('Children', true), array('action' => 'children', '%id%'), array('class' => 'btn btn-search btn-flat', 'icon' => 'fas fa-arrow-right')),
							),
						];

						echo $this->List->adminIndex($fields, $menus, $actions, true, $multi_select_actions, $parameters);
						?>
						<!-- <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p> -->
					</div>


				</div>
			</div>
		</div>
	</section>

</div>