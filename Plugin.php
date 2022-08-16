<?php

namespace Kanboard\Plugin\ExternalDbAuth;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize() {
      // Add configuration to app panel
      $this->template->hook->attach('template:config:application', 'ExternalDbAuth:config/infos');
    }

    public function getCompatibleVersion() {
        // Examples:
        // >=1.0.37
        // <1.0.37
        // <=1.0.37
        return '>=1.0.0';
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginVersion(){return '0.0.1';}
    public function getPluginHomepage(){return 'https://github.com/MrDaves24/kanboard-externalAuth';}
    public function getPluginAuthor(){return 'Pascal Perrenoud';}
    public function getPluginDescription(){return t('Allow user management from external DB');}
    public function getPluginName(){return 'ExternalDbAuth';}
}
