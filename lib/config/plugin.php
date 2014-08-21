<?php

return array(
    'name' => 'Рекомендуемые товары PRO',
    'description' => 'Возможность указать список рекомендуемых товаров и задать произвольное название и описание к товарам',
    'vendor' => '985310',
    'version' => '1.0.0',
    'img' => 'img/related.png',
    'frontend' => true,
    'shop_settings' => true,
    'handlers' => array(
        'backend_product' => 'backendProduct',
    ),
);
