<?php

$model = new waModel();

try {
    $model->query("SELECT `relatedpro` FROM `shop_product` WHERE 0");
    $model->exec("ALTER TABLE `shop_product` DROP `relatedpro`");
} catch (waDbException $e) {
    
}

try {
    $model->exec("DROP TABLE `shop_relatedplugin`");
} catch (waDbException $e) {
    
}