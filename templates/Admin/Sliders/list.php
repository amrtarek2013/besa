<?php
$title_filter = "";
if(!empty($_GET['title'])){
	$title_filter = $_GET['title'];
}
$banners_arr = array(
				// "Centre Banner"=>"",
				// "CTA Banner"=>"/admin/free-htmls?title=CTA+Banner&category_id=",
				// "3 Column Banner "=>"/free-htmls?title=3+Column+Banner&category_id=",
				// // "2 Column banner"=>"",
				// // "Header Photo"=>"",
				// "Header Text Photo"=>"/admin/franchise-banners",
				// // "Text Banner"=>"",
				// "Button Banners"=>"",
				// "Dynamic Stock Banner"=>"/admin/dynamic-stock-banners",
				// // "Video Banner"=>"",
				// // "Page banner"=>"",
				// // "Service Banner"=>"",
				// "Meet the team"=>"/admin/meet-teams",
				// "Unclassified Sections"=>"/free-htmls?title=Unclassified+sections&category_id="
				101 => 'Centre Banner',
			    102 => 'CTA Banner',
			    103 => '3 Column Banner',
			    116 => '4 Column Banners',
			    104 => '2 Column Banner',
			    105 => 'Header Photo',
			    106 => 'Header Text Photo',
			    107 => 'Text Banner',
			    108 => 'Display Banner',
			    109 => 'Button Banners',
			    110 => 'Dynamic Stock Banner',
			    111 => 'Video Banner',
			    112 => 'Page banner',
			    113 => 'Service Banner',
			    114 => 'Meet the team',
			    115 => 'Row Column Slider',
			    117 => 'Full Banners',
			    // 118 => 'Advertisements',
				123 => 'Sponsorship Banners'
				);
?>
<section class="content listSection container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card-header">
                <h3 class="card-title">Banners categories</h3>
            </div>
            <div class="card">

                <?php
                $session = $this->getRequest()->getSession();
                echo $this->List->filter_form($banners, $filters, [], [], $parameters, $session) ?>
            </div>

			<div class="card card-primary">

				<!-- <p><?php //$this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'))?></p> -->
			</div>
			<div class="card-body">
				<div class="responsive-container">
					<table id="Table" class="table table-striped projects" cellpadding="0" cellspacing="0" width="100%">
						<thead>
							<tr class="table-header">
								<td class=""><a href="javascript:;">ID</a></td>
								<td class=""><a href="javascript:;">Section Title</a></td>
								<td class=""><a href="javascript:;">Actions</a></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($banners_arr as $key => $value) { 
                            	if(!empty($title_filter)){
                            		if(strpos(strtolower($value), strtolower($title_filter))===false){
                            			continue;
                            		}
                            	}
                            	?>
	                        	<tr id="menus_1">
	                                <td><?=$key?></td>
	                                <td><?=$value?></td>
	                                <td class="project-actions text-right">
	                                	<a href="/admin/page-sections/browse/<?=$key?>" class="btn btn-info btn-flat" icon="fas fa-pencil-alt"><i class="fas fa-pencil-alt"></i> View</a>
	                                </td>
	                            </tr>
                            <?php $count++; } ?>


                        </tbody>
                    </table>
                </div>
            </div>

		</div>
	</div>
</section>
