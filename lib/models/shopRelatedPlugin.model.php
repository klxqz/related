<?php

class shopRelatedPluginModel extends waModel {

    protected $table = 'shop_relatedplugin';

    public function getProductsByProductId($product_id, $status = null) {
        $sql = "SELECT `sp`.*, 
                IF(`sr`.`name` != '',`sr`.`name`,`sp`.`name`) as `name`, 
                IF(`sr`.`summary` != '',`sr`.`summary`,`sp`.`summary`) as `summary`
                FROM `" . $this->table . "` as `sr`
                LEFT JOIN `shop_product` as `sp`
                ON `sr`.`related_product_id` = `sp`.`id`
                WHERE `sr`.`product_id` = '" . $product_id . "'
                " . (!$status ? " AND `sp`.`status` = 1" : '');
        return $this->query($sql)->fetchAll();
    }

}
