<?php

namespace Kanboard\Plugin\Customizer;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;

class Plugin extends Base
{
    public function initialize()
    {
	global $customizer;
        
        if (null !== $this->customizerFileModel->getByType(3)) { 
		    $customizer['loginCheck'] = true;
	    } else { 
		    $customizer['loginCheck'] = false;
	    } 
	    
	$customizer['backURL'] = $this->configModel->get('background_url', '');
	$customizer['logoSize'] = $this->configModel->get('loginlogo_size', '50');
	$customizer['loginpanel_color'] = $this->configModel->get('loginpanel_color', '#ffffff');
	    
	    if ($this->configModel->get('useCustomColors', '') == '0') {
		    $customizer['backColor'] = $this->configModel->get('loginbackground_color', '');
		    $customizer['backColor_b'] = $this->configModel->get('backColor_b', '');
		    $customizer['mainFontColor'] = $this->configModel->get('mainFontColor', '');
		    $customizer['alert'] = $this->configModel->get('alert', '');
		    $customizer['fontColor'] = $this->configModel->get('fontColor', '');
		    $customizer['headerFontColor'] = $this->configModel->get('headerFontColor', '');
		    $customizer['color_a'] = $this->configModel->get('color_a', '');
		    $this->template->hook->attach('template:layout:head', 'customizer:layout/css');
	    }
        
        $this->template->hook->attach('template:config:sidebar', 'customizer:config/sidebar');
        $this->template->setTemplateOverride('header/title', 'customizer:header/title');
        $this->template->setTemplateOverride('layout', 'customizer:layout/layout');
        $this->template->hook->attach('template:auth:login-form:before', 'customizer:layout/logintop');
        $this->route->addRoute('settings/customizer', 'CustomizerFileController', 'show', 'Customizer');
        $this->applicationAccessMap->add('CustomizerFileController', array('loginlogo', 'logo', 'link', 'logoexists', 'linkexists'), Role::APP_PUBLIC);
        $this->hook->on('template:layout:css', array('template' => 'plugins/Customizer/Template/customizer.css'));
    }
    
    public function getClasses() {
        return array(
            'Plugin\Customizer\Model' => array(
                'CustomizerFileModel',
            )
        );
    }
    
    public function getPluginName()
    {
        return 'Customizer';
    }
    
    public function getPluginDescription()
    {
        return t('Add Logo and Flavicon');
    }
    
    public function getPluginAuthor()
    {
        return 'Craig Crosby';
    }
    
    public function getPluginVersion()
    {
        return '0.0.3';
    }
    
    public function getPluginHomepage()
    {
        return 'https://github.com/creecros/Customizer';
    }
    
    public function getCompatibleVersion()
    {
        return '>=1.0.42';
    }
}
