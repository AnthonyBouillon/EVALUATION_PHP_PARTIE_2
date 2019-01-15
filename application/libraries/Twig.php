<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Twig
{
	private $CI;
	private $_twig;
	private $_template_dir;
	private $_cache_dir;

	/**
	 * Constructor
	 *
	 */
	function __construct($debug = false)
	{
		//$this-&gt;CI =&amp; get_instance();
		//$this-&gt;CI-&gt;config-&gt;load('twig');

		log_message('debug', "Twig Autoloader Loaded");

		Twig_Autoloader::register();

		//HMVC patch by joseayram
		//$template_module_dir = APPPATH.'modules/'.$this-&gt;CI-&gt;router-&gt;fetch_module().'/views/';
		//$template_global_dir= $this-&gt;CI-&gt;config-&gt;item('template_dir');
		//$this-&gt;_template_dir = array($template_global_dir);

		//end HMVC patch


		//$this-&gt;_cache_dir = $this-&gt;CI-&gt;config-&gt;item('cache_dir');

		//$loader = new Twig_Loader_Filesystem($this-&gt;_template_dir);

		//$this-&gt;_twig = new Twig_Environment($loader, array(
                //'cache' =&gt; $this-&gt;_cache_dir,
                //'debug' =&gt; $debug,
		//));

	        foreach(get_defined_functions() as $functions) {
            		foreach($functions as $function) {
                		//$this-&gt;_twig-&gt;addFunction($function, new Twig_Function_Function($function));
            		}
        	}


	}

	public function add_function($name)
	{
		//$this-&gt;_twig-&gt;addFunction($name, new Twig_Function_Function($name));
	}

	public function render($template, $data = array())
	{
		//$template = $this-&gt;_twig-&gt;loadTemplate($template);
		//return $template-&gt;render($data);
	}

	public function display($template, $data = array())
	{
		//$template = $this-&gt;_twig-&gt;loadTemplate($template);
		//$template-&gt;display($data);
	}

	
}