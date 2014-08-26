<?php

class shopRelatedPluginBackendSaveController extends waJsonController {

    public function execute() {
        $model = new shopRelatedPluginModel();
        $p_model = new shopProductModel();
        $product_id = (int) waRequest::post('product_id');
        $related_product_id = (int) waRequest::post('related_product_id');
        $name = waRequest::post('name');
        $summary = waRequest::post('summary');
        $is_delete = waRequest::post('delete');
        $relatedpro = (int) waRequest::post('relatedpro', -1);

        if ($relatedpro != -1) {
            $p_model->updateById($product_id, array('relatedpro' => $relatedpro));
            if ($relatedpro == 0) {
                $delete_by = array('product_id' => $product_id);
                $model->deleteByField($delete_by);
            }
        }



        if ($is_delete && $related_product_id) {

            $delete_by['related_product_id'] = $related_product_id;
            $model->deleteByField($delete_by);
        } elseif ($product_id && $related_product_id) {
            $data = array(
                'product_id' => $product_id,
                'related_product_id' => $related_product_id,
                'name' => $name,
                'summary' => $summary,
            );

            $exist = $model->getByField(array('product_id' => $product_id, 'related_product_id' => $related_product_id));
            if ($exist) {
                $model->updateByField(array('product_id' => $product_id, 'related_product_id' => $related_product_id), $data);
            } else {
                $model->insert($data);
            }
        }
    }

}
