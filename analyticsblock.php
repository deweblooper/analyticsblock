<?php
if (!defined('_PS_VERSION_'))
  exit;
 
class AnalyticsBlock extends Module
{
  public function __construct()
  {
    $this->name = 'analyticsblock';
    $this->tab = 'front_office_features';
    $this->version = '1.0.1';
    $this->author = 'waterwhite';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 
    parent::__construct();
 
    $this->displayName = $this->l('AnalyticsBlock');
    $this->description = $this->l('Adds template page to <header> for placing your codes for Analytics.');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

  }
	
	
	// install and register hooks
	public function install()
	{
		if (Shop::isFeatureActive())
    Shop::setContext(Shop::CONTEXT_ALL);
		
		if (!parent::install() ||
			!$this->registerHook('header') ||
			!Configuration::updateValue('ANALYTICSBLOCK_TOKEN', substr(md5(time()), -15, 7))
			)
			return false;
		
		return true;
	}
	
	
	// uninstall
	public function uninstall()
	{
		if (!parent::uninstall() ||
			!Configuration::deleteByName('ANALYTICSBLOCK_TOKEN')
			)
			return false;
		
		return true;
	}
	
	
	// set files to header
	public function hookDisplayHeader()
	{
		return $this->display(__FILE__, 'analyticsblock.tpl');
	}
	
	
	
}