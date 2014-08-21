<?php

class shopRelatedPlugin extends shopPlugin {

    public static $plugin_id = array('shop', 'related');

    public function backendProduct($product) {
        if ($this->getSettings('status')) {
            $view = wa()->getView();
            $view->assign('product', $product);
            $html = $view->fetch('plugins/related/templates/BackendProduct.html');
            return array('edit_section_li' => $html);
        }
    }

    public static function getProducts($product_id) {
        $routing = wa()->getRouting();
        $model = new shopRelatedPluginModel();
        $products = $model->getProductsByProductId($product_id, true);
        foreach ($products as &$product) {
            $product['frontend_url'] = $routing->getUrl('/frontend/product', array('product_url' => $product['url']), true); 
        }
        unset($product);
        return $products;
    }

}
