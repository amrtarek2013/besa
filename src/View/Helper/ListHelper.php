<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace Cake\View\Helper;

use Cake\Routing\Router;
use Cake\View\Helper;
use \Cake\Utility\Inflector;

/**
 * UrlHelper class for generating URLs.
 */
class ListHelper extends Helper
{
	public $helpers = array('Html', 'Url', 'Paginator', 'Javascript', 'AdminForm', 'Session', 'Time', 'Mixed');

	function adminIndex($fields, $data = array(), $actions = array(), $multi_select = false, $multi_select_actions = array(), $params = array(), $show_referred = false)
	{

		$out = '';
		$urls = array();

		if (empty($params['no_paging']) || !$params['no_paging']) {
			if (isset($params['?'])) {
				$url = array('?' => $params['?']);
			}

			if (isset($url)) {
				unset($url['?']['page'], $url['?']['sort'], $url['?']['direction'], $url['ext']);
			}
			if (!empty($params['prefix'])) {
				$url[$params['prefix']] = true;
			}
			if (isset($url['?'])) {
				$this->Paginator->options(array('url' => ['?' => $url['?']]));
			}
		}

		if ($multi_select) {
			$out .= $this->AdminForm->create($data, array('id' => 'MultiSelectForm', 'name' => 'MultiSelectForm', 'type' => 'post'));
			// $out .='<form id="MultiSelectForm" method="post" name="MultiSelectForm" action="/" >';
		}

		if (!empty($fields['basicModel'])) {
			$basicModel = $fields['basicModel'];
			unset($fields['basicModel']);
		}
		if (!empty($fields['primaryField'])) {
			$primaryField = $fields['primaryField'];
			unset($fields['primaryField']);
		} else {
			$primaryField = 'id';
		}

		if (stripos($this->Html->link(null), "sort:display_order/direction:asc") !== false) {

			echo $this->Html->script('jquery-ui-1.9.2.core_picker.min', array('inline' => false));
			echo $this->Html->script('jquery-ui-1.9.2.mouse_widget_sortable.min', array('inline' => false));
			echo $this->Html->script('dynamic-order', array('inline' => false));
		}

		$title = !empty($params['title']) ? $params['title'] : Inflector::humanize(Inflector::underscore(Inflector::pluralize($basicModel)));
		// debug($title );die;
		// $out .= '<div class="card-header">

		// $out .= '</div>';
		$out .= '<div class="card-body"><div class="responsive-container"><table id="Table" class="table table-striped projects" cellpadding="0" cellspacing="0" width="100%">';
		//generate header
		$out .= '<thead><tr class="table-header">';
		// $out.=$multi_select ? '<td class="multiSelect multi-select"><input type="checkbox" onclick=""/></td>' : '';
		$out .= $multi_select ? '<td class="multiSelect multi-select"><label class="containerBox">
                                                    <input type="checkbox"  onclick="" />
                                                    <span class="checkmark"></span>
                                                </label></td>' : '';
		$headers = array();
		$display_order = false;

		foreach ($fields as $name => $spec) {
			$model = $basicModel;
			$t = $name;

			$title = empty($spec['title']) ? Inflector::humanize($t) : $spec['title'];

			$sort = empty($spec['sort']) ? $name : $spec['sort'];

			$class = '';
			$urlSort = empty($params['?']['sort']) ? '' : $params['?']['sort'];
			if ($urlSort == $sort) {
				$class = $this->Paginator->sortDir($model);
			}

			// debug($this->Paginator->generateUrl(['?' => ['sort' => 'title']]));die;

			if (empty($params['no_paging']) || !$params['no_paging']) {
				// now sorting for now >> :(
				if ($t == "sales_agent_name") {
					$t = "sales_agent_id";
				}
				$title = $this->Paginator->sort($t, $title);
			}

			if ($t == 'display_order') {
				$class .= ' ajax-reorder';
			}

			$out .= "<td class=\"$class\">";

			if (!empty($spec['format']) && strtolower($spec['format']) == 'checkbox') {
				$t = strtolower($t);
				$out .= "<input type='checkbox' class='CheckboxList' rel='{$t}'/>  ";
			}
			$out .= $title;
			if ($t == 'display_order') {
				$out .= '<a id="display_order_save" href="javascript:void(0);" style="display: none;"  class="ajax-reorder"> <i class="far fa-save"></i> Save</a><div class="clear"></div>';
			}
			$out .= "</td>";

			if (strtolower($t) == 'display_order') {
				$do_action = array('action' => 'update_display_order');
				if (isset($params['update_display_order_link'])) {
					$do_action = $params['update_display_order_link'];
				}
				/* if ($this->params['prefix']){
					                  $do_action[$this->params['prefix']] = 1;
				*/
				$multi_select_actions['Update display order'] = array('action' => Router::url($do_action));
				$urls["display_order"] = Router::url($do_action);
			}
			if (!empty($spec['format']) && strtolower($spec['format']) == 'checkbox') {
				$do_action = array('action' => 'update_active', strtolower($t));
				$multi_select_actions["Update $title"] = array('action' => Router::url($do_action));
				$urls[strtolower($t)] = Router::url($do_action);
			}
		}

		if (is_array($actions) && !empty($actions)) {
			$out .= '<td class="" style="text-align:center">Actions</td>';
		}
		$out .= "</tr></thead><tbody>";

		foreach ($data as $row) {

			if (!is_array($row)) {
				$row = $row->toArray();
				// $row = $ndata;
			}
			// debug($row);

			$cells = array();
			if ($multi_select) {
				$cells[] = '<label class="containerBox"><input class="check_row oneCheckBox" type="checkbox" value="' . $row[$primaryField] . '" name="ids[]" /> <span class="checkmark"></span>
                                                </label> ';
			}

			foreach ($fields as $name => $spec) {
				if ($name) {

					$t = $name;

					$cell = '';
					if ($t == "amount") {
						if (!empty($cell)) {
							$cell .= '$' . number_format((int) $cell, 2);
						}
					}
					if (!isset($spec['format']) || $spec['format'] != 'expression') {

						//Added by DK 30/06/2020 to print field in another table/relation
						if (strpos($name, '.')) {
							$dd = explode('.', $name);
							if (isset($row[$dd[0]][$dd[1]]))
								$cell .= (string) $row[$dd[0]][$dd[1]];
						} else {
							$cell .= (isset($row[$name])) ? (string) $row[$name] : '';
						}
					}

					if (in_array($t, array('created', "date"))) {
						if (is_object($cell)) {
							$cell = $cell->format('d-m-Y h:i:s');
						} else {
							if (!is_bool(strtotime($cell))) {
								$cell = date('d-m-Y h:i:s', strtotime($cell));
							}

							// debug($cell);die;
						}
					}

					if (strtolower($t) == 'display_order') {
						if (stripos($this->Url->build(), "sort:{$basicModel}.display_order/direction:asc") !== false) {
							$handleClass = '';
							$handleTitle = '';
						} else {
							$handleClass = 'inactive';
							$handleTitle = 'You can only dynamic-sort when the table is sorted by Display Order, please click on \'Display Order\' header above';
						}
						// <span class=\"sortHandle $handleClass \" title=\"$handleTitle\">▲▼</span>

						$cell = "<input style='text-align: center;' type=\"text\" value=\"{$row[$t]}\" class=\"AdditionOption\" rel='display_order' name=\"display_order_{$row['id']}\"  size=\"5\" />";
					}

					if (isset($spec['format'])) {

						if ($spec['format'] == 'checkbox') {
							$t = strtolower($t);
							$check = 0;
							if ($cell) {
								$check = 1;
							}
							$cell = '<input  type="hidden" value="0" name="' . $t . '_' . $row['id'] . '" /> ';
							$cell .= '<input ' . (($check) ? 'checked=checked' : '') . ' class="' . $t . '_checkbox AdditionOption" type="checkbox" rel="' . strtolower($t) . '" value="1" name="' . $t . '_' . $row['id'] . '" /> ';
							$cell .= ($check) ? 'Yes' : 'No';
						} elseif ($spec['format'] == 'bool') {
							if ($cell) {
								$cell = "Yes";
							} else {
								$cell = "No";
							}
						} elseif ($spec['format'] == 'substr') {
							$string = $cell;
							$start = !empty($spec['options']['start']) ? $spec['options']['start'] : 0;
							$length = !empty($spec['options']['length']) ? $spec['options']['length'] : null;
							$cell = substr($string, $start, $length);
						} elseif ($spec['format'] == 'image') {
							$image_src = '';
							if (isset($spec['options'])) {
								$image_src = $spec['options']['src'];
							}

							$image_src .= $cell;
							$options = '';
							if (!empty($spec['options']['width'])) {
								$options .= "width={$spec['options']['width']}";
							} else {
								$options .= "width=100";
							}
							if (!empty($spec['options']['height'])) {
								$options .= "height={$spec['options']['height']}";
							}
							$src = $this->Url->build($image_src);
							$cell = "<img src='$image_src' $options />";
						} elseif ($spec['format'] == 'link') {
							// dd($cell);
							$cellLinkSrc = '#';
							$iconSrc = $this->Url->build('/img/eye.png');




							if (!empty($cell)) {
								$cellLinkSrc = $this->Url->build($cell);
								$iconImage = '<img src="' . $iconSrc . '">';
								$cell =  "<a href='$cellLinkSrc' target='_blank'/>$iconImage</a>";
							} else {

								$cell =  "-";
							}



							// $cell = "<img src='$image_src' $options />";

						} elseif ($spec['format'] == 'img') {
							// dd($cell);
							$cellLinkSrc = '#';
							$iconSrc = $this->Url->build('/img/eye.png');


							if (!empty($cell)) {
								$cellLinkSrc = $this->Url->build($cell);
								$cell = '<img width="60", hight="60" src="' . $cellLinkSrc . '">';
								// $cell =  "<a href='$cellLinkSrc' target='_blank'/>$iconImage</a>";
							} else {

								$cell =  "-";
							}



							// $cell = "<img src='$image_src' $options />";

						} elseif ($spec['format'] == 'get_from_array') {
							$selected = $cell;
							$items_list = !empty($spec['options']['items_list']) ? $spec['options']['items_list'] : array();
							$selected = !empty($selected) ? $selected : 0;
							$empty = !empty($spec['options']['empty']) ? $spec['options']['empty'] : '';
							$cell = empty($items_list[$selected]) ? $empty : $items_list[$selected];
						} elseif ($spec['format'] == 'expression') {
							eval('$cell="' . $spec['php_expression'] . '";');
						} else {
							$cell = sprintf($spec['format'], $cell);
						}
					} elseif (isset($spec['date_format'])) {
						if (is_string($cell) && $cell != null) {
							$cell = date($spec['date_format'], strtotime($cell));
						} elseif ($cell == null) {
							$cell = '';
						} else {
							$cell = $cell->format($spec['date_format']);
						}
					}
				} elseif (isset($spec['format'])) {

					if ($spec['format'] == 'bool') {
						if ($cell) {
							$cell = "Yes";
						} else {
							$cell = "No";
						}
					} elseif ($spec['format'] == 'image' && !empty($spec['options'])) {
						eval('$src = "' . $spec['options']['src'] . '";');
						$other_options = '';
						if (!empty($spec['options']['width'])) {
							$other_options = "width = '{$spec['options']['width']}'";
						}
						if (!empty($spec['options']['height'])) {
							$other_options .= "height = '{$spec['options']['height']}'";
						}
						if (!empty($spec['options']['alt'])) {
							$alt = $spec['options']['alt'];
							if (strpos($spec['options']['alt'], '$row') !== false) {
								eval('$alt = "' . $spec['options']['alt'] . '";');
							}
							$other_options .= "alt = '{$alt}'";
						}
						$src = $this->Url->build($src);
						$cell = "<img src='{$src}' $other_options />";
					} elseif ($spec['format'] == 'substr' && !empty($spec['options'])) {
						eval('$string = "' . $spec['options']['string'] . '";');

						$start = !empty($spec['options']['start']) ? $spec['options']['start'] : 0;
						$length = !empty($spec['options']['length']) ? $spec['options']['length'] : null;
						$cell = substr($string, $start, $length);
					} elseif ($spec['format'] == 'get_from_array' && !empty($spec['options'])) {
						eval('$selected = "' . $spec['options']['selected'] . '";');
						$items_list = !empty($spec['options']['items_list']) ? $spec['options']['items_list'] : array();
						$selected = !empty($selected) ? $selected : 0;

						$empty = !empty($spec['options']['empty']) ? $spec['options']['empty'] : 'None';

						$cell = empty($items_list[$selected]) ? $empty : $items_list[$selected];
					} elseif ($spec['format'] == 'check' && !empty($spec['options'])) {
						eval('$conditions = "' . $spec['options']['conditions'] . '";');
						eval('$true = "' . $spec['options']['true'] . '";');
						eval('$false = "' . $spec['options']['false'] . '";');

						$true = !empty($true) ? $true : '';
						$false = !empty($false) ? $false : '';

						$cell = ($conditions) ? $true : $false;
					} elseif ($spec['format'] == 'expression') {
						eval('$cell="' . $spec['php_expression'] . '";');
					} else {

						$cell = sprintf($spec['format'], $cell);
					}
				} else {

					eval('$cell="' . $spec['php_expression'] . '";');
				}
				if (!empty($spec['edit_link'])) {

					preg_match('/%25(.+)%25/', Router::url($spec['edit_link']), $matches);

					$spec['edit_link'] = str_ireplace("%{$matches[1]}%", $row[$matches[1]], $spec['edit_link']);

					if (isset($spec["options"])) {
						$cell = $this->Html->link($cell, $spec['edit_link'], $spec["options"]);
					} else {
						$cell = $this->Html->link($cell, $spec['edit_link']);
					}
				}
				$cells[] = $cell;
			}
			if ($show_referred) {
				if ($row['referral_id']) {
					$referral_id = $row['referral_id'];
					App::uses('Referral', 'Model');
					App::uses('Users.User', 'Model');

					$referral_model = new Referral();
					$user_model = new User();

					$referral_data = $referral_model->find('first', array('conditions' => array('id' => $referral_id)));
					if (!empty($referral_data)) {
						$cells[] = "Yes";
					} else {
						$cells[] = "-";
					}
				} else {
					$cells[] = "-";
				}
			}

			$cell = '';
			if (is_array($actions) && !empty($actions)) {
				
				$cell .= "<div class='project-actions'>";
				foreach ($actions as $k => $action) {
					$actionIcon = '';

					if (is_array($action)) {

						if (!isset($action['value'])) {
							continue;
						}
						preg_match('/%25(.+)%25/', $action['value'], $matches);

						if (isset($matches[1])) {

							$action['value'] = $actionIcon . str_replace("%25{$matches[1]}%25", $row[$matches[1]], $action['value']);
						}

						if (empty($action['condition'])) {
							$action['condition'] = '1';
						}

						//TODO: replace %model.field% in action condition
						eval("if ({$action['condition']} ) {  \$cell .=  \$action['value']  ; }");
						// dd($cell);
					} else {

						preg_match('/%25(.+)%25/', $action, $matches);
						if (empty($matches)) {
							preg_match('/%(.+)%/', $action, $matches);
							$cell .= $actionIcon . str_replace("%{$matches[1]}%", $row[$matches[1]], $action);
						} else {
							$cell .= $actionIcon . str_replace("%25{$matches[1]}%25", $row[$matches[1]], $action);
						}
					}
					// $aa =$this->AdminForm->postLink(__('Delete'), ['action' => 'delete', 1], ['confirm' => __('Are you sure you want to delete this?')]);

				}
				$cell .= "</div>";
				$cells[] = [0 => $cell, 1 => ['class' => '']];
			}
			// debug($aa);

			$asa = $out .= $this->Html->tableCells($cells, array('id' => $basicModel . '_' . $row[$primaryField]), array('id' => $basicModel . '_' . $row[$primaryField]));
			// debug($asa);
			// debug($row);
			// die;
		}
		$out .= '</tbody></table></div></div>';

		if ($multi_select) {
			if (is_array($multi_select_actions) && sizeof($multi_select_actions)) {
				$out .= '<div class="listing-actions"><div class="multi_select_operations bulk-actions">
					<label for="select_action"   >' . __('With Selected', true) . '</label>
					 <select id="select_action" name="select_action2"  > ';
				foreach ($multi_select_actions as $title => $params) {
					$out .= '<option value="' . $params['action'] . '">' . __(Inflector::humanize($title), true) . '</option>';
				}
				$out .= '</select> <input type="button" value="Go" class="GoSubmit btn btn-primary btn-sm" />  </div></div>';
			}
		}

		if ($multi_select) {
			$out .= "</form>";
		}

		$urls = json_encode($urls);

		$out .= <<<CODEBLOCK
        <script type="text/javascript">
        var urls = $urls;
        $(document).ready(function(){
            $('.AdditionOption,.CheckboxList').bind('change click',function(){
                rel = $(this).attr('rel');
                url = urls[rel];
                $('#select_action').val(url);
                if(rel == 'display_order') {
                    $('#display_order_save').fadeIn(800) ;
                }
            });
            $('.GoSubmit').click(function(){
            	if(!confirm('Are you sure you want to delete those items?')){
        			event.preventDefault();
        			return false;
      			}
                $('#MultiSelectForm').get()[0].action= $('#select_action').val();
                $('#MultiSelectForm').submit();
                return false;
			});
			
		
            $('.multiSelect input:checkbox').click(function(){
				// toggleCheck('.multiSelect input')
				if($(this).is(':checked')){
				
					$('.oneCheckBox').attr('checked',$(this).is(':checked'));
					$('.oneCheckBox').prop('checked', this.checked);
					
				} else{
					$('.oneCheckBox').prop('checked', this.checked);
				}
				
               
                  

                $('.oneCheckBox').trigger('change') ;

            });

            $('.CheckboxList').click(function(){
                rel = $(this).attr('rel');
                $("."+rel+"_checkbox").attr('checked',$(this).is(':checked'));
            });

            $('.oneCheckBox').change(function(){
                if($(this).is(':checked'))
                    $(this).parents('tr').addClass('selected');
                else
                    $(this).parents('tr').removeClass('selected') ;

            });

            $('#Table tr').click(function(e){
               if( e.target != this && e.target.nodeName.toLowerCase() != 'td' )
                   return;
               $(this).find('.oneCheckBox').attr('checked', function(index, val){ return !val ; }).trigger('change');

            });



            $('#display_order_save').click(function(){
                var elem  = this;
                $.ajax({
                    url: urls['display_order'],
                    cache: false,
                    async: false,
                    type: 'POST',
                    data: $('#MultiSelectForm').serialize(),
                    dataType: 'json',
                    success: function(data){
                        if(data.status == 'success'){
                            $(elem).fadeOut(700);
                        } else{
                            alert('error saving display order');
                        }
                    }

                });
                return false;
            });

            $('.oneCheckBox').trigger('change') ;


        });



        </script>
CODEBLOCK;

		if (empty($params['no_paging']) || !$params['no_paging']) {
			$out .= '<div class="card-footer clearfix">';
			$out .= $this->paging();
			// $out .= '<p>'.$this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) .'</p>';
			$out .= "</div>";
		}

		return $out;
	}

	function paging($prev = -1, $next = -1)
	{
		// return;
		$this->Paginator->setTemplates([
			'current' => '<li class="active page-item"><a class="page-link" href="">{{text}}</a></li>',

			'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
		]);

		$paging = '<ul class="pagination pagination-sm m-0 float-right">';

		$paging .= $this->Paginator->numbers();

		$paging .= '</ul>';
		return $this->Html->div('paging', $paging) . $this->Html->div('clear', '');
	}

	public function filter_form($model, $filters, $form_options = array(), $extra = array(), $url_params, $sessiondata, $other = [])
	{
		if (empty($filters)) {
			return false;
		}

		unset($url_params['url'], $url_params['page'], $url_params['sort'], $url_params['direction']);
		$allParams = $this->_View->getRequest()->getAttribute('params');
		$session_key = $allParams['controller'] . '_' . $allParams['action'] . "_Filter";
		$lastFilter = $sessiondata->read($session_key);
		$sessionParams = false;
		if ($lastFilter && empty($url_params['?'])) {
			$url_params = $lastFilter;
			$sessionParams  = true;
		}

		$display = 'none';
		if (!empty($url_params['?'])) {
			foreach ($url_params as $variable) {
				if ($variable) {
					if (!empty($variable) || (isset($variable) && strlen($variable))) {
						$display = 'block';
					}
				}
			}
		}
		// echo "--".$display."<br>";
		$sp_class = '';
		if ($allParams['controller'] == "Enquiries" && $allParams['action'] == "index") {
			$display = 'block';
			$sp_class = 'show_filter_block';
		}
		// echo "--".$display."<br>";

		$hasDate = false;
		// print_r($allParams);die;
		if (empty($allParams['pass'])) {
			$defaults = array('url' => ['controller' => $allParams['controller'], 'action' => $allParams['action']], 'type' => 'get', 'id' => 'filterform', 'class' => "$sp_class", 'style' => "display:$display");
		} else {
			$defaults = array('url' => ['controller' => $allParams['controller'], 'action' => $allParams['action'], $allParams['pass'][0]], 'type' => 'get', 'id' => 'filterform', 'class' => "$sp_class", 'style' => "display:$display");
		}
		// echo "--".$display."<br>";


		// dd($defaults);

		$extra_defaults = array('input_class' => 'INPUT', 'submit_class' => 'Submit', 'div_class' => 'FormExtended', 'div_id' => 'filter', 'toggle_class' => 'Filter_Me filter-ico');
		$extra = array_merge($extra_defaults, $extra);
		$prefix = (empty($allParams['prefix'])) ? '' : $allParams['prefix'];

		if (!empty($prefix)) {
			$defaults[$prefix] = true;
		}

		$form_options = array_merge($defaults, $form_options);
		$output = '<div class="col-md-12">';
		$output .= $this->Html->link(__('Show/Hide Filters', true), "javascript:$('#{$form_options['id']}').slideToggle('fast');void(0);", array('class' => $extra['toggle_class'] . ' btn btn-block btn-info btn-sm openCloseFilters'));
		$output .= $this->AdminForm->create($model, $form_options);
		$in = 0;
		$allValues = [];
		if (isset($url_params['?']) && !empty($url_params['?'])) {
			$allValues = $url_params['?'];
		}

		if ($sessionParams) {
			$allValues = $lastFilter;
			$url_params['?'] = $lastFilter;
		}

		$openFIlter = (empty($allValues)) ? '' : "javascript:$('#{$form_options['id']}').slideToggle('fast');void(0);";


		foreach ($filters as $field => $filter) {
			if (($in % count($filters)) == 0) {

				$output .= '<div class="row">';
			}

			if (is_numeric($field)) {
				$div_id = 'Div' . $allParams['controller'] . $this->createSlug($filter);
				$value = empty($url_params['?'][$filter]) && !(isset($url_params['?'][$filter]) && strlen($url_params['?'][$filter])) ? '' : strval($url_params['?'][$filter]);

				$input_prams = array('class' => $extra['input_class'], 'value' => $value, 'label' => Inflector::humanize($filter), 'selected' => $value, 'empty' => __('[Any ' . Inflector::humanize($filter) . ']', true), 'div' => array('id' => $div_id));
				if ($filter == "id") {
					$input_prams['type'] = "text";
				}
				if ($filter == "id") {
					$output .= '<div class="col-md-2">';
				} else {
					$output .= '<div class="col-md-3">';
				}
				$output .= $this->AdminForm->control($filter, $input_prams);
				$output .= '</div>';
			} elseif (is_string($filter)) {
				$div_id = 'Div' . $allParams['controller'] . $this->createSlug($field);
				$value = empty($url_params['?'][$field]) && !(isset($url_params['?'][$field]) && strval($url_params['?'][$field]) === '0') ? '' : strval($url_params['?'][$field]);
				// debug($value);die;
				$output .= '<div class="col-md-3">';
				$output .= $this->AdminForm->control($field, array('class' => 'sda' . $extra['input_class'], 'label' => Inflector::humanize($field), 'value' => $value, 'selected' => $value, 'empty' => __('[Any ' . Inflector::humanize($field) . ']', true), 'div' => array('id' => $div_id)));
				$output .= '</div>';
			} else {
				if (!empty($filter['type']) && $filter['type'] == 'text_field') {

					$div_id = 'Div' . $allParams['controller'] . $this->createSlug($field);
					$value = empty($url_params['?'][$field]) && !(isset($url_params['?'][$field]) && strval($url_params['?'][$field]) === '0') ? '' : strval($url_params['?'][$field]);
					// debug($value);die;
					$output .= '<div class="col-md-3">';
					$output .= $this->AdminForm->control($field, array('class' => $extra['input_class'], 'label' => Inflector::humanize($field), 'value' => $value, 'selected' => $value, 'empty' => __('[Any ' . Inflector::humanize($field) . ']', true), 'div' => array('id' => $div_id)));
					$output .= '</div>';
					// dd($output);
				} elseif (!empty($filter['type']) && $filter['type'] == 'number_range') {

					$from_div_id = "Div{$allParams['controller']}{$field}From";
					$to_div_id = "Div$model{$field}To";
					$from = empty($filter['from']) ? $field . ' from' : $filter['from'];
					$to = empty($filter['to']) ? $field . ' to' : $filter['to'];
					$from_value = empty($allValues[$field . '_from']) && !(isset($allValues[$from]) && strval($allValues[$field . '_from']) === '0') ? '' : strval($url_params[$field . '_from']);
					$to_value = empty($allValues[$field . '_to']) && !(isset($allValues[$to]) && strval($allValues[$field . '_to']) === '0') ? '' : strval($url_params[$field . '_to']);
					$output .= $this->AdminForm->control($field . '_from', array('label' => $from, 'class' => $extra['input_class'], 'value' => $from_value, 'selected' => $from_value, 'div' => array('id' => $from_div_id)));
					$output .= $this->AdminForm->control($field . '_to', array('label' => $to, 'class' => $extra['input_class'], 'value' => $to_value, 'selected' => $to_value, 'div' => array('id' => $to_div_id)));
				} elseif (!empty($filter['type']) && strtolower($filter['type']) == 'date_range') {
					$from_div_id = "{$allParams['controller']}{$field}From";
					$to_div_id = "{$allParams['controller']}{$field}To";
					$from = empty($filter['from']) ? $field . ' from' : $filter['from'];
					$to = empty($filter['to']) ? $field . ' to' : $filter['to'];

					$from_value = empty($allValues[$field . '_from']) ? '' : $allValues[$field . '_from'];
					$to_value = empty($allValues[$field . '_to']) ? '' : $allValues[$field . '_to'];

					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_from', array('label' => __('From'), 'class' => $extra['input_class'] . ' hasDate', 'id' => "{$field}From", 'value' => $from_value, 'selected' => $from_value, 'div' => array('id' => $from_div_id), "autocomplete" => "off"));
					$output .= '</div>';
					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_to', array('label' => __('To'), 'class' => $extra['input_class'] . ' hasDate', 'id' => "{$field}To", 'value' => $to_value, 'selected' => $to_value, 'div' => array('id' => $to_div_id), "autocomplete" => "off"));
					$output .= '</div>';
					$hasDate = true;
				} elseif (!empty($filter['type']) && strtolower($filter['type']) == 'date_time_range') {
					// dd($filter);
					$from_div_id = "{$allParams['controller']}{$field}From";
					$to_div_id = "{$allParams['controller']}{$field}To";

					$from = empty($filter['from']) ? $field . ' from' : $filter['from'];
					$to = empty($filter['to']) ? $field . ' to' : $filter['to'];

					$from_value = empty($allValues[$field . '_from']) ? '' : $allValues[$field . '_from'];
					$to_value = empty($allValues[$field . '_to']) ? '' : $allValues[$field . '_to'];

					$fromTime_value = empty($allValues[$field . '_from' . "Time"]) ? '' : $allValues[$field . '_from' . "Time"];
					$toTime_value = empty($allValues[$field . '_to' . "Time"]) ? '' : $allValues[$field . '_to' . "Time"];


					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_from', array('class' => $extra['input_class'], "autocomplete" => "off", 'id' => "{$field}From", 'value' => $from_value, 'selected' => $from_value, 'label' => 'From Date'));
					$output .= '</div>';
					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_from' . "Time", array('class' => "" . $extra['input_class'], "autocomplete" => "off", 'id' => "{$field}FromTime", 'value' => $fromTime_value, 'selected' => $fromTime_value, 'label' => 'From Time'));
					$output .= '</div>';
					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_to', array('class' => $extra['input_class'], "autocomplete" => "off", 'id' => "{$field}To", 'value' => $to_value, 'selected' => $to_value, 'label' => 'To Date', 'div' => array('id' => $to_div_id)));
					$output .= '</div>';
					$output .= '<div class="col-md-2">';
					$output .= $this->AdminForm->control($field . '_to' . "Time", array('class' => "" . $extra['input_class'], "autocomplete" => "off", 'id' => "{$field}ToTime", 'value' => $toTime_value, 'selected' => $toTime_value, 'label' => 'To Time', 'div' => array('id' => $to_div_id)));


					$output .= $this->Html->script('jquery.datepick');
					$output .= $this->Html->css('jquery.datepick');
					$output .= $this->Html->script('jquery.datetimepicker.min');
					$output .= $this->Html->css('jquery.datetimepicker.min');
					$output .= $this->Html->script('jquery.timepicker.min');
					$output .= $this->Html->css('jquery.timepicker.min');


					$output .= $this->Html->script('moment.js');
					$parser = "\n\$.datetimepicker.setDateFormatter({\n
						parseDate: function (date, format) {\n
							var d = moment(date, format);\n
							return d.isValid() ? d.toDate() : false;\n
						},\n
						
						formatDate: function (date, format) {\n
							return moment(date).format(format);\n
						},\n
						formatTime: function (time, format) {\n
							return moment(time).format(format);\n
						},\n
					
						//Optional if using mask input\n
						formatMask: function(format){\n
							return format\n
								.replace(/Y{4}/g, '9999')\n
								.replace(/Y{2}/g, '99')\n
								.replace(/M{2}/g, '19')\n
								.replace(/D{2}/g, '39')\n
								.replace(/H{2}/g, '29')\n
								.replace(/m{2}/g, '59')\n
								.replace(/s{2}/g, '59');\n
						}\n
					});\n";
					$output .= $this->Html->scriptBlock($parser);
					$output .= $this->Html->scriptBlock("$(function(){\n $('#{$field}FromTime').timepicker({timeFormat: 'H:mm:00',interval: 30,dropdown: true,scrollbar: true});\n$('#{$field}ToTime').timepicker({timeFormat: 'H:m:00',interval: 30,dropdown: true,scrollbar: true});\n });");

					// $output .= $this->Html->scriptBlock("$(function(){\n\$('#{$field}FromTime').datetimepicker({datepicker:false,formatTime: 'HH:mm:ss'});\n$('#{$field}ToTime').datetimepicker({datepicker:false,format: 'HH:mm:ss',formatTime: 'HH:mm:ss'});\n });");
					$output .= $this->Html->scriptBlock("$(function(){\n\$('#{$field}From').datepicker({format: 'd-m-yyyy', todayHighlight: true,clearBtn: true});\n$('#{$field}To').datepicker({format: 'd-m-yyyy',todayHighlight: true,clearBtn: true});\n});");

					$output .= '</div>';
				} else {
					$selectOptions = (isset($other[Inflector::pluralize($field)])) ? $other[Inflector::pluralize($field)] : [];
					// $value = empty($url_params['?'][$field]) && !(isset($url_params['?'][$field]) && strval($url_params['?'][$field]) === '0') ? '' : strval($url_params['?'][$field][0]);
					$value = empty($url_params['?'][$field]) && !(isset($url_params['?'][$field]) && strval($url_params['?'][$field]) === '0') ? '' : strval($url_params['?'][$field]);
					
					$label = str_replace("_id", "", $field);
					$label = empty($filter['title']) ? Inflector::humanize($label) : $filter['title'];


					$multiple = empty($filter['multiple']) ? false : 'multiple';

					if (isset($filter['empty']) && empty($filter['empty'])) {
						$empty1 = false;
					} else {
						$empty1 = empty($filter['empty']) ? __('[Any ' . Inflector::humanize($label) . ']') : __($filter['empty']);
					}
					$required1 = empty($filter['required']) ? false : $filter['required'];

					// dd($url_params);
					if ($field == "active") {
						$output .= '<div class="col-md-2">';
					} else {
						$output .= '<div class="col-md-3">';
					}
					if (isset($filter['options']['options'])) {
						$selectOptions = $filter['options']['options'];
					}
					
					$fieldType = (isset($filter['options']['type'])) ? $filter['options']['type'] : false;
					if (!empty($selectOptions)) {

						$output .= $this->AdminForm->control($field, array('type' => 'select', 'options' => $selectOptions, 'label' => $label, 'class' => 'selectTwoInput ' . $extra['input_class'], 'value' => $value, 'selected' => $value, 'empty' => __('[Any ' . $label . ']', true)));
					} else if ($fieldType) {

						$div_id = 'Div' . $allParams['controller'] . $this->createSlug($field);
						$value = empty($url_params['?'][$field]) && !(isset($url_params['?'][$field]) && strval($url_params['?'][$field]) === '0') ? '' : strval($url_params['?'][$field]);
						$output .= $this->AdminForm->control($field, array('type' => $fieldType, 'class' =>  $extra['input_class'], 'label' => isset($label) ? $label : Inflector::humanize($field), 'value' => $value, 'div' => array('id' => $div_id)));
					} else {
						$output .= $this->AdminForm->control($field, array('label' => $label, 'class' => 'selectTwoInput ' . $extra['input_class'], 'value' => $value, 'selected' => $value, 'empty' => $empty1, 'required' => $required1, 'multiple' => $multiple));
					}
					$output .= '</div>';
					$selectOptions = [];
				}
			}
			$in++;
			if (($in % count($filters)) == 0) {
				$output .= '</div>';
			}
		}
		if ($in < count($filters)) {
			$output .= '</div>';
		}
		$output .= $this->Html->div('clear', '');

		$output .= '<div class="row">';
		$output .= '<div class="FilterAction filter-action col-sm-6">';
		if (!empty($extra['filter_title'])) {
			$output .= $this->AdminForm->submit(__($extra['filter_title']), array('class' => 'btn btn-block btn-primary', 'div' => false));
		} else {
			$output .= $this->AdminForm->submit(__('Filter', true), array('class' => 'btn btn-block btn-primary', 'div' => false));
		}

		//submit2
		if (!empty($extra['submit2'])) {
			$output .= $this->AdminForm->submit(__($extra['submit2']), array('name' => 'submit2', 'value' => '2', 'class' => 'btn btn-block btn-dark', 'div' => false));
		}


		$output .= $this->AdminForm->control(__('Clear', true), array('label' => false, 'div' => false, 'value' => 'Clear', 'class' => 'btn btn-primary btn-sm', 'id' => 'FilterClear', 'type' => 'reset'));

		// $output .= $this->Html->div('FilterAction filter-action col-sm-6',
		// $this->AdminForm->submit(__('Filter', true), array('class' => 'btn btn-block btn-primary btn-flat', 'div' => false)));
		// $output .= $this->Html->div('FilterAction filter-action col-sm-6',
		// $this->AdminForm->control(__('Clear', true), array('label' => false, 'div' => false, 'value' => 'Clear', 'class' => 'btn btn-primary btn-sm', 'id' => 'FilterClear', 'type' => 'reset',)));
		$output .= '</div>';
		$output .= '</div>';



		$output .= $this->AdminForm->end();

		$output .= $this->Html->div('clear', '');
		// if(!empty($_GET['test3'])){
		// 	print_r($prefix);die;
		// }
		if (!empty($prefix)) {
			$clearUrl = Router::url(array('action' => 'reset_filter', $allParams['action'], strtolower($prefix) => true, 'prefix' => $prefix));
		} else {
			$clearUrl = Router::url(array('action' => 'reset_filter', $allParams['action']));
		}

		$here = $this->Url->build(array('?' => false));
		$script = <<<CODEBLOCK
$('#FilterClear').click(function(){ $.ajax({url : '$clearUrl', success: function(data, status){window.location = "$here"; }});});
$('#filterform input').removeAttr('required');
$openFIlter
CODEBLOCK;
		if ($hasDate) {
			$script .= '$(".hasDate").datepicker({format: "dd-mm-yy"});';
		}
		$output .= $this->Html->scriptBlock('$(function(){' . $script . '});');
		$output .= '</div>';
		return $this->Html->div($extra['div_class'], $output, array('id' => $extra['div_id']));
	}

	function export_csv($ModelName, $items, $schema, $filename = '')
	{
		Configure::write('debug', 0);
		$ini_config = parse_ini_file(APP . DS . 'app_config.ini');
		$name = $filename;
		if (empty($name)) {
			$name = $this->createSlug($ini_config['txt.site_name'] . '_' . Inflector::pluralize($ModelName) . '_' . date('Ymd')) . '.csv';
		}
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $name . '"');
		$separator = CSV_SEPARATOR;
		$output = implode(array_map('quote', $schema), CSV_SEPARATOR) . NL;
		foreach ($items as $item) {
			$line = array();
			if (isset($item[$ModelName]['active'])) {
				$item[$ModelName]['active'] = empty($item[$ModelName]['active']) ? 'NO' : 'Yes';
			}
			foreach ($item[$ModelName] as $field) {
				$line[] = quote_csv($field);
			}
			$output .= implode($separator, $line) . NL;
		}
		$this->layout = '';
		return $output;
	}

	public static function createSlug($str, $delimiter = '-')
	{

		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		return $slug;
	}
}
