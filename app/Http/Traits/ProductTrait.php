<?php
namespace App\Http\Traits;

trait ProductTrait {
    public function listProductExpConfigByCategory() {
        $exp_configs = [
            config('const.category_id_yugioh') => [
                'exp_text_1' => '拡張情報1-種類',
                'exp_text_2' => '拡張情報2-属性',
                'exp_text_3' => '拡張情報3-種族',
                'exp_text_4' => '拡張情報4-星（レベル、ランク）',
                'exp_text_5' => '拡張情報5-攻撃力',
                'exp_text_6' => '拡張情報6-守備力',
                'exp_text_7' => '拡張情報7-リンク',
                'exp_text_8' => '拡張情報8-リンク方向',
                'exp_text_9' => '拡張情報9-ペンデュラムレフト',
                'exp_text_10' => '拡張情報10-ペンデュラムライト',
                'exp_text_16' => '拡張情報16-第四階層',
                'exp_text_17' => '拡張情報17-効果テキスト、フレーバー',
                'exp_text_18' => '拡張情報18-ペンデュラムテキスト'
            ],
            config('const.category_id_rushduel') => [
                'exp_text_1' => '拡張情報1-種類',
                'exp_text_2' => '拡張情報2-属性',
                'exp_text_3' => '拡張情報3-種族',
                'exp_text_4' => '拡張情報4-星',
                'exp_text_5' => '拡張情報5-攻撃力',
                'exp_text_6' => '拡張情報6-守備力',
                'exp_text_16' => '拡張情報16-第四階層',
                'exp_text_17' => '拡張情報17-効果テキスト'
            ],
            config('const.category_id_pokemon') => [
                'exp_text_1' => '拡張情報1-種類',
                'exp_text_2' => '拡張情報2-タイプ',
                'exp_text_3' => '拡張情報3-たね・1進化',
                'exp_text_4' => '拡張情報4-HP',
                'exp_text_5' => '拡張情報5-弱点',
                'exp_text_6' => '拡張情報6-抵抗',
                'exp_text_7' => '拡張情報7-にげる',
                'exp_text_16' => '拡張情報16-第四階層',
                'exp_text_17' => '拡張情報17-効果テキスト',
                'exp_text_18' => '拡張情報18-フレーバー'
            ],
            config('const.category_id_duelmasters') => [
                'exp_text_1' => '拡張情報1-種類',
                'exp_text_2' => '拡張情報2-文明',
                'exp_text_3' => '拡張情報3-種族',
                'exp_text_4' => '拡張情報4-コスト',
                'exp_text_5' => '拡張情報5-パワー',
                'exp_text_6' => '拡張情報6-マナ',
                'exp_text_16' => '拡張情報16-第四階層',
                'exp_text_17' => '拡張情報17-効果テキスト',
                'exp_text_18' => '拡張情報18-フレーバー'
            ],
            config('const.category_id_dragon_ball_heroes') => [
                'exp_text_3' => '拡張情報3-バトルタイプ',
                'exp_text_4' => '拡張情報4-パワー',
                'exp_text_5' => '拡張情報5-ガード',
                'exp_text_6' => '拡張情報6-HP',
                'exp_text_7' => '拡張情報7-必殺技',
                'exp_text_8' => '拡張情報8-必要エナジー',
                'exp_text_9' => '拡張情報9-消費エナジー',
                'exp_text_15' => '拡張情報15-CAA/TAA/特殊アビリティ/超アビリティ/アビリティ',
                'exp_text_16' => '拡張情報16-第四階層',
                'exp_text_17' => '拡張情報17-アルティメットユニット',
                'exp_text_18' => '拡張情報18-特殊アビリティ'
            ],
        ];

        return $exp_configs;
    }
}