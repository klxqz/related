<?php

class shopRelatedPluginBackendAutocompleteController extends waController {

    protected $limit = 10;

    public function execute() {
        $data = array();
        $q = waRequest::get('term', '', waRequest::TYPE_STRING_TRIM);
        if ($q) {
            $data = $this->productsAutocomplete($q);
            $data = $this->formatData($data);
        }
        echo json_encode($data);
    }

    private function formatData($data) {


        $with_counts = waRequest::get('with_counts', 0, waRequest::TYPE_INT);
        $with_sku_name = waRequest::get('with_sku_name', 0, waRequest::TYPE_INT);
        foreach ($data as &$item) {
            if (empty($item['label'])) {
                $item['label'] = htmlspecialchars($item['value']);
            }
            if ($with_counts) {
                $item['label'] .= ' ' . shopHelper::getStockCountIcon($item['count'], null, true);
            }
            if ($with_sku_name) {
                $item['label'] .= ' <span class="hint">' . $item['sku_name'] . '</span>';
            }
            $item['price'] = shop_currency($item['price'], $item['currency']);
        }


        return $data;
    }

    public function productsAutocomplete($q, $limit = null) {
        $limit = $limit !== null ? $limit : $this->limit;

        $product_model = new shopProductModel();
        $q = $product_model->escape($q, 'like');
        $fields = 'id, name AS value, price, currency, count, sku_id, summary';

        $products = $product_model->select($fields)
                ->where("name LIKE '$q%'")
                ->limit($limit)
                ->fetchAll('id');
        $count = count($products);

        if ($count < $limit) {
            $product_skus_model = new shopProductSkusModel();
            $product_ids = array_keys($product_skus_model->select('id, product_id')
                            ->where("sku LIKE '$q%'")
                            ->limit($limit)
                            ->fetchAll('product_id'));
            if ($product_ids) {
                $data = $product_model->select($fields)
                        ->where('id IN (' . implode(',', $product_ids) . ')')
                        ->limit($limit - $count)
                        ->fetchAll('id');

                // not array_merge, because it makes first reset numeric keys and then make merge
                $products = $products + $data;
            }
        }

        // try find with LIKE %query%
        if (!$products) {
            $products = $product_model->select($fields)
                    ->where("name LIKE '%$q%'")
                    ->limit($limit)
                    ->fetchAll();
        }
        $currency = wa()->getConfig()->getCurrency();
        foreach ($products as &$p) {
            $p['price_str'] = wa_currency($p['price'], $currency);
        }
        unset($p);

        if (waRequest::get('with_sku_name')) {
            $sku_ids = array();
            foreach ($products as $p) {
                $sku_ids[] = $p['sku_id'];
            }
            $product_skus_model = new shopProductSkusModel();
            $skus = $product_skus_model->getByField('id', $sku_ids, 'id');
            $sku_names = array();
            foreach ($skus as $sku_id => $sku) {
                $name = '';
                if ($sku['name']) {
                    $name = $sku['name'];
                    if ($sku['sku']) {
                        $name .= ' (' . $sku['sku'] . ')';
                    }
                } else {
                    $name = $sku['sku'];
                }
                $sku_names[$sku_id] = $name;
            }
            foreach ($products as &$p) {
                $p['sku_name'] = $sku_names[$p['sku_id']];
            }
            unset($p);
        }

        return array_values($products);
    }

}
