<?php

return array(
    'shop_relatedplugin' => array(
        'product_id' => array('int', 11, 'null' => 0),
        'related_product_id' => array('int', 11, 'null' => 0),
        'name' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'summary' => array('text', 'null' => 0),
        ':keys' => array(
            'product_id' => 'product_id',
            'related_product_id' => 'related_product_id',
            'key' => array('product_id', 'related_product_id')
        ),
    ),
);
