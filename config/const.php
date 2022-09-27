<?php

return [
  'contact_type' => [
    1 => '商品のトラブルについて',
    2 => '商品の購入について',
    3 => 'その他'
  ],
  'page' => [
    'limit' => 20,
    'limit_list' => [20, 40, 60, 80, 100]
  ],
  'csv' => [
    'limit' => 5
  ],
  'format' => [
    'date_time' => 'Y/m/d H:i',
    'date' => 'Y-m-d',
    'time' => 'H:i'
  ],
  'payment'=> [
    'success' => 1,
    'error' => 2
  ],
  'order_status'=> [
    'send_instruction' => 6,
    'send_wait' => 7,
    'send' => 8
  ],
  'category_id_game' => env('CATEGORY_ID_GAME', 1),
  'category_id_toreka' => env('CATEGORY_ID_TOREKA', 2),
  'category_id_yugioh' => env('CATEGORY_ID_YUGIOH', 3),
  'category_id_rushduel' => env('CATEGORY_ID_RUSHDUEL', 4),
  'category_id_pokemon' => env('CATEGORY_ID_POKEMON', 5),
  'category_id_duelmasters' => env('CATEGORY_ID_DUELMASTERS', 6),
  'category_id_dragon_ball_heroes' => env('CATEGORY_ID_DRAGON_BALL_HEROES', 7),
  'mail_template_id' => [
    'shipment_mail' => 1,
    'error' => 4
  ],
  'pre_order_sale_flag_false' => '0',
  'pre_order_sale_flag_true' => '1',
  'favorite_product_false' => '0',
  'favorite_product_true' => '1',
  'conveni' => [
    '00007' => 'セブンイレブン',
    '10001' => 'ローソン',
    '10002' => 'ファミリーマート',
    '10005' => 'ミニストップ',
    '10008' => 'セイコーマート',
  ]
];
