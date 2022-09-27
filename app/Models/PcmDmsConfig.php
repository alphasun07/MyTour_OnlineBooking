<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

class PcmDmsConfig extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pcm_dms_configs';
    var $_data = null;

    public function getValueConfig($config_key)
    {
        $config = self::where('config_key', $config_key)->first();
        if ($config != null) {
            return $config->config_value;
        }
        return null;
    }

    function storeConfig($request)
    {
        $data = $request->all();
        self::truncate();
        unset($data['_token']);
        foreach ($data as $key => $value) {
            $row = new PcmDmsConfig();
            $row->id = 0;
            if (is_array($value))
                $value = implode(',', $value);
            $row->config_key = $key;
            $row->config_value = $value;
            $row->save();
        }
        return true;
    }

    function getData()
    {
        if (empty($this->_data)) {
            $config = new stdClass();
            $rows = self::query()->get();
            if (count($rows)) {
                foreach ($rows as $row) {
                    $key = $row->config_key;
                    $value = $row->config_value;
                    $config->$key = stripslashes($value);
                }
            }
            $this->_data = $config;
        }

        return $this->_data;
    }
}
