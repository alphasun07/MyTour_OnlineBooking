<?php

namespace App\Helpers;

use App\Mail\SendRegisteredNotification;
use App\Models\Helpdesk\HelpdeskCategory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\PcmDmsCategory;
use App\Models\DtbCoupon;
use App\Models\PcmDmsConfig;
use App\Models\PcmUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SplQueue;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Helper
{
    public static function customFormatDate($date_time) {
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        $weekday = $weekMap[Carbon::parse($date_time)->dayOfWeek];
        $date = date('d M Y g:i a', strtotime($date_time));

        return $weekday . ', ' . $date;
    }

    public static function getDateTimeFormat($date_time, $format = 'Y-m-d')
    {
        if (strtotime($date_time) > 0) {
            return date($format, strtotime($date_time));
        } else {
            return;
        }
    }

    public static function getDateRange($start_date, $end_date, $format = 'Y-m-d')
    {
        $start = self::getDateTimeFormat($start_date, $format) ? self::getDateTimeFormat($start_date, $format) : '-';
        $end = self::getDateTimeFormat($end_date, $format) ? self::getDateTimeFormat($end_date, $format) : '-';
        $result = $start . '～' . $end;
        return $result;
    }

    public static function loadCsvData($file = '', $delimiter = ',')
    {
        Log::info('loadCsvData filename: ' . $file->getClientOriginalName());

        if (!file_exists($file) || !is_readable($file)) {
            Log::error('loadCsvData file not exists');
            return null;
        }

        $data = file_get_contents($file);

        // Retrieve encode of csv file
        $encode = mb_detect_encoding($data, "UTF-8,SJIS-WIN,SJIS,EUC,EUC-JP");

        Log::info('loadCsvData encode: ' . $encode);

        // SJIS-winではない場合は、SJIS-winに変換
        if ($encode && $encode != "SJIS-win") {
            $data = mb_convert_encoding($data, "SJIS-win", $encode);
        }

        // UTF-8に変換
        $data = mb_convert_encoding($data, 'UTF-8', "SJIS-win");

        // Put data into file.
        $temp = tmpfile();
        fwrite($temp, $data);
        rewind($temp);

        $csv  = array();
        while (($row = fgetcsv($temp, 0, $delimiter)) !== FALSE) {
            $csv[] = $row;
        }
        fclose($temp);
        Log::info('loadCsvData count line: ' . count($csv));
        return $csv;
    }
    public function getTreeLabelCategory($category)
    {
        $label = '';
        if ($category->parent_id != 0 && $category->parent_id != $category->id) {
            $child_category = PcmDmsCategory::findOrFail($category->parent_id);
            $label = $this->getTreeLabelCategory($child_category) . '/' . $category->name;
        } else {
            $label = $category->name . $label;
        }
        return $label;
    }
    public function getTreeLabelCategories($category)
    {
        $label = '';
        if ($category->parent_id != 0 && $category->parent_id != $category->id) {
            $child_category = HelpdeskCategory::findOrFail($category->parent_id);
            $label = $this->getTreeLabelCategories($child_category) . '/' . $category->title;
        } else {
            $label = $category->title . $label;
        }
        return $label;
    }

    public function getAllParentCategoryByChild($categoryId)
    {
        $list_parent_ids = [];
        $category = PcmDmsCategory::findOrFail($categoryId);
        $list_parent_ids[] = $category->id;
        if ($category->parent_id != 0) {
            $list_parent_ids = array_merge($list_parent_ids, $this->getAllParentCategoryByChild($category->parent_id));
        }
        return $list_parent_ids;
    }
    public function getAllParentCategoriesByChild($categoryId)
    {
        $list_parent_ids = [];
        $category = HelpdeskCategory::findOrFail($categoryId);
        $list_parent_ids[] = $category->id;
        if ($category->parent_id != 0) {
            $list_parent_ids = array_merge($list_parent_ids, $this->getAllParentCategoriesByChild($category->parent_id));
        }
        return $list_parent_ids;
    }

    public function getAllChildCategoryByParent($categoryId)
    {
        $list_child_ids = [];
        $queue = new SplQueue();
        $queue->enqueue($categoryId);
        $queue->rewind();
        while ($queue->valid()) {
            $childs = (new PcmDmsCategory)->getListCategoryByParentId($queue->current())->pluck('id')->toArray();
            foreach ($childs as $child) {
                $queue->enqueue($child);
            }
            $list_child_ids[] = (int)$queue->current();
            $queue->next();
        }
        return $list_child_ids;
    }

    public function getChildCategoryByParentPath($categoryId)
    {
        $list_parent_ids = (new Helper)->getAllParentCategoryByChild($categoryId);
        $list_child_ids = [];
        foreach ($list_parent_ids as $parent_id) {
            $childs = (new PcmDmsCategory)->getListCategoryByParentId($parent_id)->pluck('id')->toArray();
            $list_child_ids[] = $childs;
        }
        $list_child_ids[] = [end($list_parent_ids)];
        return $list_child_ids;
    }

    public function getDataAddress($order)
    {
        if (!is_null($order)) {
            $postal_code = !empty($order->postal_code) ? $order->postal_code  . '<br>' : '';
            $pref = !empty(optional($order->mtbPref)->name) ? optional($order->mtbPref)->name : '';
            $addr01 = !empty($order->addr01) ? ', ' . $order->addr01 : '';
            $addr02 = !empty($order->addr02) ? ', ' . $order->addr02 : '';
            $addr03 = !empty($order->addr03) ? ', ' . $order->addr03 : '';

            return  $postal_code . $pref . $addr01 . $addr02 . $addr03;
        }
    }
    public function generateCouponCode()
    {
        $coupon_code = DtbCoupon::query()->orderBy('id', 'desc')->take(1)->value('code');
        if ($coupon_code == null) {
            $code = '10000000012';
        } else {
            $first_code = substr($coupon_code, 0, 7);
            $first_code = (int)$first_code;
            $middle_code = substr($coupon_code, 7, 3);
            $middle_code = (int)$middle_code;
            $sum = 0;
            if ($middle_code == 999) {
                $middle_code = '001';
                $first_code += 1;
            } else {
                $middle_code += 1;
            }
            for ($i = 0; $i < 7; $i++) {
                $number = substr($first_code, $i, 1);
                $number = (int)$number;
                $sum += $number;
            }
            for ($j = 0; $j < 3; $j++) {
                $number = substr($middle_code, $j, 1);
                $number = (int)$number;
                $sum += $number;
            }
            $last_number = $sum % 10;
            if (strlen($middle_code) == 1) {
                $middle_code = '00' . $middle_code;
            } else if (strlen($middle_code) == 2) {
                $middle_code = '0' . $middle_code;
            }
            $code = $first_code . $middle_code . $last_number;
        }
        return $code;
    }

    public function randomPassword($len = 8)
    {
        //enforce min length 8
        if ($len < 8)
            $len = 8;
        //define character libraries - remove ambiguous characters like iIl|1 0oO
        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        $sets[]  = '!,#,$,%,&,_,-,+,|';
        $password = '';
        //append a character from each set - gets first 4 characters
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
        //use all characters to fill up to $len
        while (strlen($password) < $len) {
            //get a random set
            $randomSet = $sets[array_rand($sets)];

            //add a random char from the random set
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }
        //shuffle the password string before returning!
        return str_shuffle($password);
    }

    public static function getMaxBuyQuantity($stock, $bought_quantity)
    {
        $sum = $stock + $bought_quantity;
        if ($sum >= 10) {
            return 10;
        } else {
            return $sum;
        }
    }
    public function formatPrice($price, $decimals = 0, $decimal_separator = ',', $thousands_separator = ',', $currency = '¥')
    {
        return $currency . number_format((float)$price, $decimals, $decimal_separator, $thousands_separator);
    }

    public static function isShowTabData($data = null)
    {
        $canShow = true;
        if ($data->tab_1_title == '' && $data->tab_2_title == '' && $data->tab_3_title == '' && $data->tab_4_title == '' && $data->tab_5_title == '') {
            $canShow = false;
        }
        return $canShow;
    }

    public static function getConfig()
    {
        static $config;

        if (is_null($config)) {
            $config = new \stdClass();
            $rows = PcmDmsConfig::query()->get();
            foreach ($rows as $row) {
                $config->{$row->config_key} = $row->config_value;
            }
        }

        return $config;
    }

    public static function getConfigValue($configKey, $default = null)
    {
        $config = self::getConfig();
        if (isset($config->{$configKey})) {
            return $config->{$configKey};
        }
        return $default;
    }

    public static function getCategoryIDByUserEmail($email) {
        $ids = [];
        $categories = (new HelpdeskCategory())->getListCategory(true)->get();
        foreach($categories as $category) {
            if (in_array($email, explode(',', trim($category->managers)))) {
                $ids[] = $category->id;
            }
        }
        return $ids;
    }

    public static function getCategoryIDByUserEmails()
    {
        $managers = [];
        $ids = [];

        $categories = (new HelpdeskCategory())->getListCategory(true)->whereNotNull('managers')->get();
        foreach($categories as $category){
            $managers = array_merge($managers, explode(',', trim($category->managers)));
        }
        $managers = array_unique($managers);

        foreach($managers as $manager){
            $ids[$manager] = self::getCategoryIDByUserEmail($manager);
        }

        return $ids;
    }

    public function paginateArr($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage($options['pageName']) ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function makeRandomReferralCode($except = [])
    {
        $existedCode = (new PcmUser())->getAllUsers()->pluck('referral_code')->toArray();

        while(True){
            $random = Str::random(6);
            if(!in_array($random, $except) && !in_array($random, $existedCode)){
                return $random;
            }
        }
    }
}
