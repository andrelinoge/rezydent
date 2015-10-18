<?php

/**
 * elRTE is an input widget based on elRTE editor http://elrte.org
 * @author luxurydab (Anton Logvinenko)
 * 
 */
class elRTE extends CInputWidget
{
    /** @var string */
    public $doctype = '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">';
    /** @var string */
    public $cssClass = 'el-rte';
    /** @var string */
    public $absoluteURLs = 'false';
    /** @var string */
    public $allowSource = 'true';
    /** @var string */
    public $lang;
    /** @var string */
    public $styleWithCSS = 'true';
    /** @var int */
    public $height;
    /** @var int */
    public $width;
    /** @var string */
    public $fmAllow = 'true';
    /** @var string */
    public $customToolbarName = 'myToolbar';
    /** @var array list of panels like array('save' ,'tables')*/
    public $customToolbarPanels = array();
    /** @var string */
    public $customPanelName = NULL;
    /** @var array list of panel buttons like ('bold', 'italic' )*/
    public $customPanelButtons = array();

    public $baseUrl;
    /** @var string id of target element for elrte wrapper */
    public $selector;
    /** @var bool If true - use already defined 'opt' variable (global settings), else - define it locally  */
    public $useGlobalOptVar = FALSE;
    
    public function init()
    {            
        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;                       
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $ClientScript = Yii::app()->getClientScript();        
        $ClientScript->registerCoreScript('jquery');               
        $ClientScript->registerScriptFile("{$this->baseUrl}/js/jquery-ui-1.8.13.custom.min.js");
        $ClientScript->registerScriptFile("{$this->baseUrl}/js/elrte.full.js");             
        $ClientScript->registerCssFile("{$this->baseUrl}/css/smoothness/jquery-ui-1.8.13.custom.css");
        $ClientScript->registerCssFile("{$this->baseUrl}/css/elrte.min.css");
        $ClientScript->registerCssFile("{$this->baseUrl}/css/elrte-inner.css");       
        $ClientScript->registerCssFile("{$this->baseUrl}/css/elfinder.css");          
        $ClientScript->registerScriptFile("{$this->baseUrl}/js/elfinder.min.js");

        if ( isset($this->lang) && $this->lang != 'en')
        {
            $ClientScript->registerScriptFile("{$this->baseUrl}/js/i18n/elrte.$this->lang.js");
            $ClientScript->registerScriptFile("{$this->baseUrl}/js/i18n/elfinder.$this->lang.js");
        }
        
  
    }
         
    public function generateOptions()
    {
        $options = "{ \n";
        $options .= "  doctype: '$this->doctype', \n";
        $options .= "  cssClass:'$this->cssClass', \n";

        if ( isset($this->height)) {
            $options .= "  height: '$this->height', \n";
        }

        if ( isset($this->width)) {
            $options .= "  width: '$this->width', \n";
        }

        if ( isset($this->lang) && $this->lang != 'en') {
            $options .= "  lang: '$this->lang', \n";
        }

        if ( isset($this->customToolbarName)) {
            $options .= "  toolbar: '" . $this->customToolbarName ."', \n";
        }

        $options .= "  absoluteURLs: $this->absoluteURLs, \n";
        $options .= "  allowSource: $this->allowSource, \n";
        $options .= "  styleWithCSS: $this->styleWithCSS, \n";
        $options .= "  fmAllow: $this->fmAllow, \n";
        $options .= "  cssfiles:['{$this->baseUrl}/css/elrte-inner.css'], \n";
        $options .= "  fmOpen : function(callback) { \n";
        $options .= "      $('<div id=\"$this->selector\" />').elfinder({ \n";
        $options .= "         'url' : '{$this->baseUrl}/connectors/php/connector.php', \n";
        $options .= "         'dialog' : { width : 900, modal : true, title : 'Files' }, \n";
        if ( isset($this->lang) && $this->lang != 'en')
        {
            $options .= "     lang: '$this->lang', \n";
        } 
        $options .= "         closeOnEditorCallback : true, \n";
        $options .= "         editorCallback : callback \n";
        $options .= "      })";
        $options .= "  }";
        $options .= "} ";

        return $options;     
    }
    
    private function initEditor()
    {                
        $options = $this->generateOptions();
                
        $js = "$().ready(function() { \n";
        // Custom panel with its settings
        if ( isset( $this->customPanelName) ) {
            if ( isset( $this->customPanelButtons ) ) {
                if ( is_array($this->customPanelButtons) ) {
                    $settings = '';
                    foreach( $this->customPanelButtons as $param ) {
                        $settings .= "'" . $param . "'";
                        $settings .= ',';
                    }
                    $settings = substr( $settings, 0, strlen($settings) - 1);
                    if ( !empty($settings) ) {
                        $js .= 'elRTE.prototype.options.panels.' . $this->customPanelName . " = [$settings]; \n";
                    }
                }
            }
        }

        // Custom tool bar with its settings
        if ( isset( $this->customToolbarName) ) {
            if ( isset( $this->customToolbarPanels ) ) {
                if ( is_array($this->customToolbarPanels) ) {
                    $settings = '';
                    foreach( $this->customToolbarPanels as $param ) {
                        $settings .= "'" . $param . "'";
                        $settings .= ',';
                    }
                    $settings = substr( $settings, 0, strlen($settings) - 1);
                    if ( !empty($settings) ) {
                        $js .= 'elRTE.prototype.options.toolbars.' . $this->customToolbarName . " = [$settings]; \n";
                    }
                }
            }
        }

        if ( $this->useGlobalOptVar ) {
            $js .= "opts = $options";
        } else {
            $js .= "var opts = $options";
        }

        $js .= "; \n";    
        $js .= "var elrteInstatnce = $('#".$this->selector."').elrte(opts);";
        $js .= "});";

        Yii::app()->clientScript->registerScript("Yii.elRTE_.$this->selector.",$js,CClientScript::POS_BEGIN);
    }
    
    public function run()
    {
        $this->initEditor();
    }
}

?>

