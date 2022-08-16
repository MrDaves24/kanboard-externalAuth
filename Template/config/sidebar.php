<li <?= $this->app->checkMenuSelection('ConfigController', 'show', 'ExternalDbAuth') ?>>
    <?= $this->url->link(t('External DB Auth settings'), 'ConfigController', 'show', array('plugin' => 'ExternalDbAuth')) ?>
</li>
