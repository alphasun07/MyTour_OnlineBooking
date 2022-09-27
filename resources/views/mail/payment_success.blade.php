<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>

    <style type="text/css">
        table, td, th {  
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            font-size: 14px;
        }

        th, td:first-child {
            font-weight: bold;
        }

        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            width: fit-content;
            max-width: 580px;
            padding: 10px;
            width: 580px;
        }

        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            width: fit-content;
            max-width: 580px;
            padding: 10px;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>{{ $subject }}</h1>
            <div>
                {!! $body !!}
            </div>
        </div>
    </div>
</body>