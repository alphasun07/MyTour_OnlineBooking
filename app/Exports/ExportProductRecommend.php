<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportProductRecommend implements FromCollection, WithHeadings
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
        $arrResult = [];
        foreach ($collections as $collection) {
            $newEl = [];
            foreach ($this->fields as $field) {
                $newEl[$field] = $collection[$field] ?? '';
            }
            array_push($arrResult, $newEl);
        }
        return $arrResult;
    }

    public function headings(): array
    {
        return [
            "商品ID",
            "カテゴリID",
            "並び順"
        ];
    }
}
