<?php

$plugin_id = array('shop', 'related');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');

$model = new waModel();
try {
    $sql = 'SELECT `relatedpro` FROM `shop_product` WHERE 0';
    $model->query($sql);
} catch (waDbException $ex) {
    $sql = 'ALTER TABLE  `shop_product` ADD  `relatedpro`  TINYINT( 1 ) DEFAULT 0 AFTER  `id`';
    $model->query($sql);
}