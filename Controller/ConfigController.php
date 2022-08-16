<?php

namespace Kanboard\Plugin\ExternalDbAuth\Controller;

/**
 * Class ConfigController
 *
 * @package Kanboard\Plugin\ExternalDbAuth\Controller
 */
class ConfigController extends \Kanboard\Controller\ConfigController
{
    public function show()
    {
        $this->response->html($this->helper->layout->config('ExternalDbAuth:config/config', array(
            'title' => t('Settings').' &gt; '.t('External DB Auth settings'),
        )));
    }

    public function save()
    {
        $values =  $this->request->getValues();

        if ($this->configModel->save($values)) {
            $this->flash->success(t('Settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('ConfigController', 'show', array('plugin' => 'ExternalDbAuth')));
    }
}
