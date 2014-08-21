<?php

class shopRelatedPluginSettingsAction extends waViewAction {

    public function execute() {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(shopRelatedPlugin::$plugin_id);
        $this->view->assign('settings', $settings);
    }

}
