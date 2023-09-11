<?php
namespace App\View\Helper;
use Cake\View\Helper\FormHelper as CakeFormHelper;
use Cake\View\View;

class AdminFormHelper extends CakeFormHelper {

	// use \Cake\View\Helper\IdGeneratorTrait;
	// use \Cake\View\Helper\StringTemplateTrait;

	public $helpers = ['Url', 'Html'];

	/**
	 * Default config for the helper.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
		'idPrefix' => null,
		'errorClass' => 'form-error',
		'typeMap' => [
			'string' => 'text',
			'text' => 'textarea',
			'uuid' => 'string',
			'datetime' => 'datetime',
			'datetimefractional' => 'datetime',
			'timestamp' => 'datetime',
			'timestampfractional' => 'datetime',
			'date' => 'date',
			'time' => 'time',
			'year' => 'year',
			'boolean' => 'checkbox',
			'float' => 'number',
			'integer' => 'number',
			'tinyinteger' => 'number',
			'smallinteger' => 'number',
			'decimal' => 'number',
			'binary' => 'file',
		],
		'templates' => [
			// Used for button elements in button().
			'button' => '<button{{attrs}}>{{text}}</button>',
			// Used for checkboxes in checkbox() and multiCheckbox().
			'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
			// Input group wrapper for checkboxes created via control().
			'checkboxFormGroup' => '{{label}}',
			// Wrapper container for checkboxes.
			'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
			// Error message wrapper elements.
			'error' => '<div class="text-danger">{{content}}</div>',
			'dateWidget' => '<span class="form-inline">{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}</span>',
			// Container for error items.
			'errorList' => '<ul>{{content}}</ul>',
			// Error item wrapper.
			'errorItem' => '<li>{{text}}</li>',
			// File input used by file().
			'file' => '<input type="file" name="{{name}}"{{attrs}}>',
			// Fieldset element used by allControls().
			'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
			// Open tag used by create().
			'formStart' => '<form{{attrs}}>',
			// Close tag used by end().
			'formEnd' => '</form>',
			// General grouping container for control(). Defines input/label ordering.
			'formGroup' => '{{label}}{{input}}',
			// Wrapper content used to hide other content.
			'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
			// Generic input element.
			'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
			// Submit input element.
			'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
			// Container element used by control().
			'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
			// Container element used by control() when a field has an error.
			'inputContainerError' => '<div class="form-group {{type}}{{required}} error">{{content}}{{error}}</div>',
			// Label element when inputs are not nested inside the label.
			'label' => '<label{{attrs}}>{{text}}</label>',
			// Label element used for radio and multi-checkbox inputs.
			'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
			// Legends created by allControls()
			'legend' => '<legend>{{text}}</legend>',
			// Multi-Checkbox input set title element.
			'multicheckboxTitle' => '<legend>{{text}}</legend>',
			// Multi-Checkbox wrapping container.
			'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
			// Option element used in select pickers.
			'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
			// Option group element used in select pickers.
			'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
			// Select element,
			'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
			// Multi-select element,
			'selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
			// Radio input element,
			'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
			// Wrapping container for radio input/label,
			'radioWrapper' => '{{label}}',
			// Textarea input element,
			'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
			// Container for submit buttons.
			'submitContainer' => '<div class="submit">{{content}}</div>',
			// Confirm javascript template for postLink()
			'confirmJs' => '{{confirm}}',
			// selected class
			'selectedClass' => 'selected',
		],
		// set HTML5 validation message to custom required/empty messages
		'autoSetCustomValidity' => true,
	];

	private $templates = [
		'dateWidget' => '<span class="form-inline">{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}</span>',
		'error' => '<div class="text-danger">{{content}}</div>',
		'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
		'inputContainerError' => '<div class="form-group {{type}}{{required}} error">{{content}}{{error}}</div>',
	];

	private $templates_horizontal = [
		'label' => '<label class="control-label col-md-2"{{attrs}}>{{text}}</label>',
		'formGroup' => '{{label}}<div class=" col-md-10">{{input}}{{error}}{{help}}</div>',
		'checkboxFormGroup' => '<div class="checkbox">{{label}}</div>{{error}}{{help}}',
		'submitContainer' => '<div class="col-md-10 col-md-offset-2">{{content}}</div>',
		'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
		'inputContainerError' => '<div class="form-group {{type}}{{required}} has-error">{{content}}</div>',
	];

	public function __construct(View $View, array $config = []) {
		$this->_defaultConfig['templates'] = array_merge($this->_defaultConfig['templates'], $this->templates);
		parent::__construct($View, $config);
	}

	public function create($model = null, array $options = []): string{
		$options += ['role' => 'form'];
		if (isset($options['class']) and $options['class'] == 'form-horizontal') {
			$options['templates'] = $this->templates_horizontal;
		}

		return parent::create($model, $options);
	}

	public function button($title, array $options = array()): string {
		return parent::button($title, $this->_injectStyles($options, 'btn btn-success'));
	}

	public function submit($caption = null, array $options = []): string {
		return parent::submit($caption, $this->_injectStyles($options, 'btn btn-success'));
	}

	public function control($fieldName, array $options = []): string{
		$options += [
			'type' => null,
			'label' => null,
			'error' => null,
			'required' => null,
			'options' => null,
			'templates' => [],
		];
		$options = $this->_parseOptions($fieldName, $options);

		$options += ['id' => $this->_domId($fieldName)];
		$defaults = array('before' => null, 'between' => null, 'after' => null);
		$options = array_merge($defaults, $options);

		$finalClasses = 'form-control';

		$type = $options['type'];
		$before = $options['before'];
		$between = $options['between'];
		$after = $options['after'];

		switch ($type) {
		case 'checkbox':
			$finalClasses = '';
			$options['templates']['checkboxWrapper'] = $before . '<div class="checkbox"><label>' . $between . '{{input}}{{label}}</label></div>' . $after;
			$options['templates']['label'] = '{{text}}';
			break;
		case 'radio':
			$options['templates']['radioWrapper'] = '<div class="radio">' . $before . '{{input}}' . $between . '{{label}}' . $after . '</div>';
			$options['templates']['label'] = '{{text}}';
			break;
		case 'file':
			$options['templates']['inputContainer'] = !isset($options['templates']['inputContainer']) ?'<div class="form-group {{type}}{{required}}">{{content}}' . $after . '</div>':$options['templates']['inputContainer'];
			$options['templates']['label'] = isset($options['templates']['label']) ? $options['templates']['label'] : $before . '<label>{{input}}{{text}}</label>' . $between;
			break;
		case 'password':
			$options['templates']['inputContainer'] = '<div class="form-group {{type}}{{required}}">' . $between . '{{content}}</div>';
			$options['templates']['label'] = isset($options['templates']['label']) ? $options['templates']['label'] : '<label>{{input}}{{text}}</label>';
			break;
		default:
		}

		//     <div class="form-group">
		//     <label for="exampleInputFile">File input</label>
		//     <div class="input-group">
		//       <div class="custom-file">
		//         <input type="file" class="custom-file-input" id="exampleInputFile">
		//         <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		//       </div>
		//       <div class="input-group-append">
		//         <span class="input-group-text" id="">Upload</span>
		//       </div>
		//     </div>
		//   </div>

		return parent::control($fieldName, $this->_injectStyles($options, $finalClasses));
	}

	public function ajaxFile($fieldName, array $options = [], $single = false): string{
		$options += [
			'type' => null,
			'label' => null,
			'error' => null,
			'required' => null,
			'options' => null,
			'templates' => [],
		];
		$options = $this->_parseOptions($fieldName, $options);

		$options += ['id' => $this->_domId($fieldName)];
		$defaults = array('before' => null, 'between' => null, 'after' => null);
		$options = array_merge($defaults, $options);

		$finalClasses = 'form-control';

		$type = $options['type'];
		$before = $options['before'];
		$between = $options['between'];
		$after = $options['after'];

		switch ($type) {

		case 'file':
			$options['templates']['inputContainer'] = '
<div id="drop-area" class="form-group {{type}}{{required}}">
  <h3>Drag and Drop Files Here<h3/>
			{{content}}' . $after . '</div>';

			// $options['templates']['inputContainer'] = $fileTemplate;
			$options['templates']['label'] = isset($options['templates']['label']) ? $options['templates']['label'] : $before . '<label>{{input}}{{text}}</label>' . $between;
			break;
		default:
		}

		//     <div class="form-group">
		//     <label for="exampleInputFile">File input</label>
		//     <div class="input-group">
		//       <div class="custom-file">
		//         <input type="file" class="custom-file-input" id="exampleInputFile">
		//         <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		//       </div>
		//       <div class="input-group-append">
		//         <span class="input-group-text" id="">Upload</span>
		//       </div>
		//     </div>
		//   </div>

		return parent::control($fieldName, $this->_injectStyles($options, $finalClasses));
	}

	public function select($fieldName, $options = [], array $attributes = []): string{
		$attributes = $this->_injectStyles($attributes, 'form-control');
		return parent::select($fieldName, $options, $attributes);
	}

	public function textarea($fieldName, array $options = array()): string{
		$options += ['rows' => 3];
		$options = $this->_injectStyles($options, 'form-control');
		return parent::textarea($fieldName, $options);
	}

	public function hour($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::hour($fieldName, $options);
	}

	public function time($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::time($fieldName, $options);
	}

	public function year($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::year($fieldName, $options);
	}

	public function month($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::month($fieldName, $options);
	}

	public function day($fieldName = null, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::day($fieldName, $options);
	}

	public function minute($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::minute($fieldName, $options);
	}

	public function dateTime($fieldName, array $options = []): string{
		$options = $this->_injectStyles($options, 'form-control');
		return parent::dateTime($fieldName, $options);
	}

	protected function _injectStyles($options, $styles) {
		$options += ['class' => [], 'skip' => []];
		if (!is_array($options['class'])) {
			$options['class'] = explode(' ', $options['class']);
		}
		if (!is_array($styles)) {
			$styles = explode(' ', $styles);
		}
		foreach ($styles as $style) {
			if (!in_array($style, $options['class']) && !in_array($style, (array) $options['skip'])) {
				array_push($options['class'], $style);
			}
		}
		unset($options['skip']);
		return $options;
	}

	protected function _mergeStyles($current, $new) {
		$current = explode(' ', $current);
		$new = explode(' ', $new);
		foreach ($new as $style) {
			if (!in_array($style, $current)) {
				array_push($current, $style);
			}
		}
		return $current;
	}

	protected function _datetimeOptions($options) {

		if (isset($options['year']) and is_array($options['year'])) {
			$options['year'] = $this->_injectStyles($options['year'], 'form-control');
		}

		if (isset($options['month']) and is_array($options['month'])) {
			$options['month'] = $this->_injectStyles($options['month'], 'form-control');
		}

		if (isset($options['hour']) and is_array($options['hour'])) {
			$options['hour'] = $this->_injectStyles($options['hour'], 'form-control');
		}

		if (isset($options['minute']) and is_array($options['minute'])) {
			$options['minute'] = $this->_injectStyles($options['minute'], 'form-control');
		}

		return $options;
	}

	public function __call($method, $params) {
		$options = [];
		if (empty($params)) {
			throw new \Exception(sprintf('Missing field name for FormHelper::%s', $method));
		}
		if (isset($params[1])) {
			$options = $params[1];
		}
		if (!isset($options['type'])) {
			$options['type'] = $method;
		}
		if (isset($options['class']) and is_array($options['class'])) {
			$options['class'] = implode(' ', $options['class']);
		}
		$options = $this->_initInputField($params[0], $options);

		$options = $this->_injectStyles($options, 'form-control');
		return $this->widget($options['type'], $options);
	}

	function enableAjaxUploads($id = false, $sessionKey = false, $mainAdminToken = false, $type = null) {

		$tt = '<script>';
		$ttt = '';
		$sk = '';

		if ($sessionKey) {
			$sk = ' var sessionKey = "' . $sessionKey . '"; ';
		}

		// debug($mainAdminToken);die;
		if ($mainAdminToken) {

			$ttt = ' var ajaxToken = "' . $mainAdminToken . '" ; ';
		}

		if ($id) {
			$ttt = ' var ajaxToken = "' . $id . '" ; ';
		}
		$tt .= $ttt;
		$tt .= $sk;

		$tt .= '</script>';
		// debug($tt);die;

		return '<script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    ' . $tt .
		$this->Html->css('../fine-uploader/fine-uploader-gallery.min') .
		$this->Html->script('../fine-uploader/fine-uploader') .
			(!isset($type) ? $this->Html->script('fineUploaderLoader') : $this->Html->script('fineUploaderLoaderCarImages'));
	}

	function enableEditors($selector = 'textarea.editor') {

		return '<script src="' . WEBSITE_PATH.'/js/' . 'ckeditor/ckeditor.js"></script>' .
		$this->Html->scriptBlock(
			"$(function(){
var _ckConfigs = '';
                            $('$selector').each(function(e){


                                if($(this).hasClass('basicEditor')){
                                    _ckConfigs = '/js/ckeditor/basic.js'
                                }else{
                                    _ckConfigs = '/js/ckeditor/full.js'
                                }
                                CKEDITOR.replace(this.id, {
                                        customConfig: _ckConfigs
                                } );
                                if($(this).hasClass('addFrontCss')){
                                CKEDITOR.config.contentsCss = [
                                    '/css/new-css/normalize.min.css',
									'/css/new-css/all.min.css',
									'/css/new-css/owl.carousel.min.css',
									'/css/new-css/animations.css',
									'/css/new-css/timeline.css',
									'/css/new-css/grid.css',
									'/css/new-css/style.css?v=12',
									'/css/new-css/responsive.css',
									'/css/new-css/ck-fix-style.css'

                            ];
                        }


                                _ckConfigs = '';

                            });

                        });");

		// $this->Html->script('ckeditor/adapters/jquery');

	}

	function enableBasicEditors($selector = 'textarea.basicEitor', $css_styles = '', $width = 760, $height = 500) {
		$css_str = '';
		if (empty($css_styles)) {
			$css_styles = "css/screen.css";
		}
		if (!empty($css_styles)) {
			$content_css = str_replace(",", "' , '", $css_styles);
			$css_str = ",contentsCss: ['" . $content_css . "']";
		}

		return '<script src="' . \Cake\Routing\Router::url('/js/') . 'ckeditor_basic/ckeditor.js"></script>' .
		// $this->Html->script('ckeditor/ckeditor',['inline'=>true]) .

		$this->Html->scriptBlock("$(function(){

                          $('$selector').each(function(e){
                                CKEDITOR.replace(this.id);
                             });


                         });");

		// $this->Html->script('ckeditor/adapters/jquery');

	}

	function escapeString($string) {
		$escape = array("\r\n" => '\n', "\r" => '\n', "\n" => '\n', '"' => '\"', "'" => "\\'");
		return str_replace(array_keys($escape), array_values($escape), $string);
	}

	public function enableAjaxFileUpload($divIds = array() /*Inputs Ids*/, $names = array() /*Inputs Names*/) {

		echo $this->Html->script('pekeUpload.js');

		foreach ($divIds as $k => $divId) {
			echo $this->Html->scriptBlock('$(function(){

$("#' . $divId . '").pekeUpload(
{
	dragMode: false,
            dragText: "Drag and Drop your files here",
            bootstrap: true,
            btnText: "Browse files...",
            allowedExtensions: "",
            invalidExtError: "Invalid File Type",
            maxSize: 0,
            sizeError: "Size of the file is greather than allowed",
            showPreview: true,
            showFilename: true,
            showPercent: true,
            showErrorAlerts: true,
            errorOnResponse: "There has been an error uploading your file",
            onSubmit: false,
            notAjax:false,
            url: "/temp-files/ajax-files/' . $names[$k] . '",
            data: null,
            limit: 1,
            limitError: "You have reached the limit of files that you can upload",
            delfiletext: "Remove from queue",
            onFileError: function(file, error) {},
            onFileSuccess: function(file, data) {
            	var input = document.createElement("input");
input.setAttribute("type", "text");
input.setAttribute("name",$("#' . $divId . '").attr("name"));
input.setAttribute("value", file.name);




            	$("#' . $divId . '").after( input );

console . log(file . name);


            }
        }
);






		                       });');
		}

		return '';
	}

}
