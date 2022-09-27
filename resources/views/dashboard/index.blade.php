@php
use App\Models\Config;
use App\Helpers\PcmHtml;
use Carbon\Carbon;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Dashboard' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Dashboard', 'subTitle' => ''])
@endsection
@section('content')
<div class="row dms-dashboard">
    <div class="col-md-5 dms-left">
        <div class="x_panel">
            <div class="x_title">
                <h2>Quick Access</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a class="btn btn-app" href="{{ route('admin.dms.config')}}">
                    <i class="fa fa-gears"></i> Configuration
                </a>
                <a class="btn btn-app" href="{{ route('admin.category.list')}}">
                    <span class="badge bg-green">{{$data['total_category'] ?? 0}}</span>
                    <i class="fa fa-folder-o"></i> Categories
                </a>
                <a class="btn btn-app" href="{{ route('admin.dms.file') }}">
                    <span class="badge bg-green">{{$data['total_file'] ?? 0}}</span>
                    <i class="fa fa-file-zip-o"></i> Files
                </a>
                <a class="btn btn-app" href="{{ route('admin.dms.document.index') }}">
                    <span class="badge bg-green">{{$data['total_document'] ?? 0}}</span>
                    <i class="fa fa-file-o"></i> Documents
                </a>
                <a class="btn btn-app" href="{{ route('admin.order.list')}}">
                    <span class="badge bg-green">{{$data['total_order'] ?? 0}}</span>
                    <i class="fa fa-inbox"></i> Orders
                </a>
                <a class="btn btn-app" href="{{ route('admin.coupon.list')}}">
                    <span class="badge bg-green">{{$data['total_coupon'] ?? 0}}</span>
                    <i class="fa fa-tags"></i> Coupons
                </a>
                <a class="btn btn-app" href="{{ route('admin.tag.list')}}">
                    <span class="badge bg-green">{{$data['total_tag'] ?? 0}}</span>
                    <i class="fa fa-tag"></i> Tags
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="x_panel">
            <div class="x_title">
                <h2>Statistics</h2>
                <div class="float-right">
                    @php
                        $year_now = Carbon::now()->year;
                        $statistical_year = Carbon::now()->year - $yearStart;
                    @endphp
                    <select id="year_statistical" class="custom-select mb-2">
                        <option {{request()->year == $year_now ? 'selected' : ''}} value="{{$year_now}}">{{$year_now}}</option>
                        @for ($i = 0; $i < $statistical_year; $i++)
                        <option {{request()->year == $year_now - 1 ? 'selected' : ''}} value="{{$year_now - 1}}">{{$year_now - 1}}</option>
                        @endfor
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 ">
                    <div class="demo-container" style="height:280px">
                        <div id="chart_revenue" class="demo-placeholder"></div>
                    </div>
                    <div class="tiles">
                        <div class="col-md-4 tile">
                            <span>Total Sessions</span>
                            <h2>{{array_sum($totalSession)}}</h2>
                            <span class="sparkline11 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                            </span>
                        </div>
                        <div class="col-md-4 tile">
                            <span>Total Revenue</span>
                            <h2>${{array_sum($statistics)}}</h2>
                            <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                            </span>
                        </div>
                    </div>
                    @foreach ($statistics as $key_statistic => $statistic)
                    <input type="hidden" id="revenue_value_{{$key_statistic}}" value="{{$statistic}}">
                    @endforeach
                    @foreach ($months as $key_moth => $month)
                      <input type="hidden" id="month_value_{{$key_moth}}" value="{{ $month }}">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('gentelella-master/vendors/Chart.js/dist/Chart.min.js') }}"></script>
<!-- Flot -->
<script src="{{ asset('gentelella-master/vendors/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/Flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ asset('gentelella-master/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/flot.curvedlines/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ asset('gentelella-master/vendors/DateJS/build/date.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('gentelella-master/vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>
    $('#year_statistical').on('change', function() {
        var year = $(this).val();
        window.location.href= "?year="+year;
    })
    $(document).ready(function() {
        getRevenue();
    });
    function getRevenue(params) {
        var getRevenueStatistic = function (key = null) {
            return $('#revenue_value_'+key).val();
        };
        var getMothRevenue = function (key = null) {
            return $('#month_value_'+key).val();
        };
        var chart_revenue_data = [];
        var today = new Date();
        for (var i = 0; i < 12; i++) {
            chart_revenue_data.push([new Date(getMothRevenue(i)).getTime(), getRevenueStatistic(i)]);
        }
        var chart_revenue_settings = {
            grid: {
                show: true,
                aboveData: true,
                color: "#3f3f3f",
                labelMargin: 10,
                axisMargin: 0,
                borderWidth: 0,
                borderColor: null,
                minBorderMargin: 5,
                clickable: true,
                hoverable: true,
                autoHighlight: true,
                mouseActiveRadius: 100
            },
            series: {
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    steps: false
                },
                points: {
                    show: true,
                    radius: 4.5,
                    symbol: "circle",
                    lineWidth: 3.0
                }
            },
            legend: {
                position: "ne",
                margin: [0, -25],
                noColumns: 0,
                labelBoxBorderColor: null,
                labelFormatter: function(label, series) {
                    return label + '&nbsp;&nbsp;';
                },
                width: 40,
                height: 1
            },
            colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
            shadowSize: 0,
            tooltip: true,
            tooltipOpts: {
                content: "%s: %y.0",
                xDateFormat: "%d/%m",
                shifts: {
                    x: -30,
                    y: -50
                },
                defaultTheme: false
            },
            yaxis: {
                min: 0
            },
            xaxis: {
                mode: "time",
                minTickSize: [1, "day"],
                timeformat: "%d/%m/%y",
                // min: chart_revenue_data[0][0],
                // max: chart_revenue_data[8][0]
            }
        };
        if ($("#chart_revenue").length) {
            $.plot($("#chart_revenue"),
                [{
                    label: "Revenue",
                    data: chart_revenue_data,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                }], chart_revenue_settings);
        }
    }

</script>
@endsection
