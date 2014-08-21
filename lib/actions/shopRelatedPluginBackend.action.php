<?php

class shopRelatedPluginBackendAction extends waViewAction {

    public function execute() {
        $product_id = (int) waRequest::get('id');
        $product = new shopProduct($product_id);

        $model = new shopRelatedPluginModel();
        $related = $model->getProductsByProductId($product_id);

        $this->view->assign(array(
            'product' => $product,
            'related' => $related
        ));
    }

}
