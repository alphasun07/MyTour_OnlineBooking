<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!-- Gentelella -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        <div class="container">
            <form method="POST" action="{{ action('FakeApiController@point_add') }}">
                @csrf
                <input type="hidden" name="id" value="1">
                <input type="hidden" name="use_flg" value="1">
                <input type="hidden" name="withdrawal_flg" value="1">
                <input type="hidden" name="receipt_flg" value="1">
                <input type="hidden" name="point_period_flg" value="1">
                <input type="hidden" name="db_flg" value="1">
                <input type="hidden" name="token_flg" value="1">
                取引日時
                <input type="date" name="tradeDateTime"><br>
                ポイント種別コード
                <input type="text" name="pointDealCode"><br>
                変動ポイント
                <input type="text" name="point"><br>
                カード番号
                <input type="text" name="cardNo"><br>
                取引金額
                <input type="text" name="proceeds"><br>
                ECの注文番号
                <input type="text" name="ecOrderNo"><br>
                <input type="submit" value="api">
            </form>
            @isset($datas)
                @foreach ($datas as $data)
                    {{ $data }}<br>
                @endforeach
            @endisset
        </div>
    </body>
    <form method="POST" action="{{ action('AdminController@import_csv_product_simple') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv">
        <button type="submit">登録</button>
    </form>
</html>
