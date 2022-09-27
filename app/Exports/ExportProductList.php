<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportProductList implements FromCollection, WithHeadings
{
    use Exportable;

    protected $collection;
    protected $fields;

    public function __construct(Collection $collection, array $field)
    {
        $this->collection = $collection;
        $this->fields = $field;
    }

    public function collection()
    {
        $collection = collect($this->prepareData($this->collection));

        return $collection;
    }

    function prepareData($collections)
    {
        $arr_result = [];
        foreach ($collections as $collection) {
            $new_el = [];
            foreach ($this->fields as $field) {
                switch ($field) {
                    case '8':
                        $new_el[$field] = "000000";
                        break;
                    case '9':
                        $new_el[$field] = "000000";
                        break;
                    case '10':
                        $new_el[$field] = "000000";
                        break;
                    case '11':
                        $new_el[$field] = "000000";
                        break;
                    case '12':
                        $new_el[$field] = "000000";
                        break;
                    default:
                        $new_el[$field] = $collection[$field];
                        break;
                }
            }
            array_push($arr_result, $new_el);
        }

        return $arr_result;
    }

    public function headings(): array
    {
        return [
            "商品コード",
            "商品管理番号",
            "商品状態レベル",
            "大分類コード",
            "中分類コード",
            "小分類１コード",
            "小分類２コード",
            "第一カテゴリ",
            "第二カテゴリ",
            "第三カテゴリ",
            "第四カテゴリ",
            "第五カテゴリ",
            "販売可否フラグ",
            "返品可否フラグ",
            "18歳未満禁止フラグ",
            "公開フラグ",
            "検索表示フラグ",
            "発売年月日",
            "商品名",
            "商品名カナ",
            "商品画像ファイルＩＤ",
            "型番",
            "販売価格（税抜き）",
            "販売価格（税込み）",
            "商品情報"
        ];
    }
}
