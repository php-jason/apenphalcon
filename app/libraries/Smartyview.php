<?php if(!defined('APPPATH')) exit('No direct script access allowed');

// get smarty lib
require_once APPPATH.'libraries/Smarty/Smarty.class.php';

// main class
class Smartyview {
	
	// global smarty object
	private $smarty=null;
	
  private $config = array(
    'smarty_template_dir' => 'views', // base folder for all your templates
    'smarty_compile_dir' => 'cache/smarty/templates_c', // where templates will be compiled to
    'smarty_config_dir' => 'views/_config', // place to hold template config files
    'smarty_cache_dir' => 'cache/smarty' ,// universal smarty cache directory
    'left_delimiter' => '<!--{',
    'right_delimiter' => '}-->'
  );
	public function __construct() {
		// setup the object
		$this->smarty = new Smarty();
		$this->smarty->template_dir = APPPATH.$this->config['smarty_template_dir'];
		$this->smarty->compile_dir = APPPATH.$this->config['smarty_compile_dir'];
		$this->smarty->config_dir = APPPATH.$this->config['smarty_config_dir'];
		$this->smarty->cache_dir = APPPATH.$this->config['smarty_cache_dir'];
    $this->smarty->left_delimiter = $this->config['left_delimiter'];
    $this->smarty->right_delimiter = $this->config['right_delimiter'];

	}
	
	// compile and output the template
	public function render($template = '', $data = array() , $isFetch = null) {
		
		// assign template variables
		$this->smarty->assign($data);
		
		// output the template
		$output = $this->smarty->fetch($template);
    if($isFetch)
        return $output;

	}

  public function assign($name='',$data=''){
    if(is_array($name))
      $this->smarty->assign($name);
    else
      $this->smarty->assign($name,$data);
  }

  public function display($template=''){
   $this->smarty->display($template);
  }
	
}
