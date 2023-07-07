<?php
declare (strict_types = 1);

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\Http\Session;
use Cake\Routing\Router;
use Cake\View\Helper;
use Cake\View\View;

/**
 * AdminSideMenu helper
 */
class AdminSideMenuHelper extends Helper
{


    public $space = '';
    protected $_defaultConfig = [];
    public $helpers = array('Html', 'Url', 'Paginator', 'Javascript', 'AdminForm', 'Session', 'Time', 'Mixed');
    public $locale = 'en';
    public $showTextOnly = false;

    public function render($menus, $urlPrefixText, $showTextOnly = false)
    {

        
        $this->showTextOnly= $showTextOnly;
        $change_menu = false;
        if($urlPrefixText=="admin"){
            $change_menu = false;
        }
        $output = '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

        foreach ($menus[$urlPrefixText] as $menu) {
            if ($menu->parent_id == 0 && empty($menu->children)) {
                $output .= $this->renderSingleItem($menu);
            } elseif ($menu->parent_id == 0 && !empty($menu->children)) {
                $output .= $this->renderTreeItemStart($menu,$change_menu);
                foreach ($menu->children as $child) {
                    if (empty($child->children)) {
                        $output .= $this->renderSingleItem($child);
                    } else {
                        $output .= $this->renderTreeItemStart($child);
                        foreach ($child->children as $ch) {
                            $output .= $this->renderTreeItemChild($ch);
                        }
                        $output .= $this->renderTreeItemEnd([]);
                    }
                }
                $output .= $this->renderTreeItemEnd([],$change_menu);
            }
        }

        return $output;
    }


    public function renderSingleItem($data)
    {
        $class="";
        $item_active="";
        if($data->is_opened==true){
            $class="menu-open";
            $item_active="active";
        }
        
        if($this->showTextOnly){
            return '<li class="nav-item '.$class.'">
            <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2 '.$item_active.'">
            
              ' . __($data->title) . '
            </a>
          </li>';
        }
        return '<li class="nav-item '.$class.'">
                <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2 '.$item_active.'">
                ' . $data->icon . '
                  <p>' . __($data->title) . '</p>
                </a>
              </li>';
    }

    public function renderTreeItemStart($data,$out = false)
    {
        $class="";
        $item_active="";

        if($data->is_opened==true){
            $class="menu-open";
            $item_active="active";
        }
        // Configure::write('debug',true);
      
        $session = new Session;
        $locale = $session->read('locale');
        $faAngle = 'left';
        if($locale == 'ar_AE'){
            $faAngle = 'right';
        }
        $rtis_html = '<li class="nav-item '.$class.'">
                <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2  '.$item_active.'">
                ' . $data->icon . '&nbsp
                  <p>' . __($data->title) . '
                  <i class="right fas fa-angle-'.$faAngle.'"></i>
                  </p>
                </a><ul class="nav nav-treeview">';
        
        if($this->showTextOnly){
            $rtis_html = '<li class="nav-item  '.$class.'">
                <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2  '.$item_active.'">
                ' . __($data->title) .
                '</a></li>';
        } else if($out){
            $rtis_html = '<ul class="nav nav-pills nav-sidebar flex-column new-main-menu-item" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item  '.$class.'">
                <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2  '.$item_active.'">
                ' . '<p>' . __($data->title) . '</p>
                </a></li></ul>';
        }
        

        return $rtis_html;
    }

    public function renderTreeItemEnd($data,$out = false)
    {
        if($out){
            return '';
        }
        return ' </ul></li>';
    }

    public function renderTreeItemChild($data)
    {

        $item_active="";
      $output='';
      if (!empty($data->children)) {
         $output .= $this->renderTreeItemStart($data);
                        foreach ($data->children as $ch) {
                            $output .= $this->renderTreeItemChild($ch);
                        }
                        $output .= $this->renderTreeItemEnd([]);
      }else{
        if($data->is_opened==true){
            $item_active="active";
        }
        $output =  '<li class="nav-item">
                    <a href="' . Router::url($data->full_link) . '" class="nav-link nav-link2 '.$item_active.'">
                      &nbsp;&nbsp;&nbsp; ' . $data->icon . '
                      <p>' . __($data->title) . '</p>
                    </a>
                </li>';
                if($this->showTextOnly){
                    '<li class="">
                    <a href="' . Router::url($data->full_link) . '" class=" '.$item_active.'">'. __($data->title) .'</a>
                </li>';
                }
      }
      return $output;
  }
    

}
