@php
use App\Helpers\Helper;
@endphp
@extends('front.common.app', ['active' => 'list'])
@section('title')
Support Tickets
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
</section>
<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title pb-0">
            @include('front.common.alert')
            <div class="row">
                <div class="col-md-3">
                    <h2 class="section-main-title w-100">Support Tickets</h2>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('support-tickets.add') }}" class="submit-ticket-btn" style="color:#0DA0F2;"><i class="fa fa-plus-circle"></i> Submit Ticket</a>
                </div>
            </div>
            <div class="row tk-search">
                <form method="GET" action="">
                    <div class="col-md-3 d-flex ps-0">
                        <input type="text" name="keyword" id="keyword" class="form-control" value="{{ $searchData['keyword'] ?? '' }}">
                        <div class="tool-tip">
                            <button type="submit"><i class="fa fa-search"></i></button>
                            <span class="tooltiptext tooltip-top">Search</span>
                        </div>
                        <div class="tool-tip">
                            <button type="button" id="clear_keyword"><i class="fa fa-times"></i></button>
                            <span class="tooltiptext tooltip-top">Clear</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select w-100" name="category" onchange="submitFormSearch()">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if(isset($searchData['category']) && $searchData['category']  == $category->id) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select w-100" name="status" onchange="submitFormSearch()">
                            <option value="">Ticket status</option>
                            <option value="all" @if(isset($searchData['status']) && $searchData['status']  == 'all') selected @endif>All</option>
                            @foreach ($status as $val)
                                <option value="{{ $val->id }}" @if(isset($searchData['status']) && $searchData['status']  == $val->id) selected @endif>{{ $val->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="ticket-list mt-3">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="50%">Title</th>
                    <th>Created Date</th>
                    <th>Modified Date</th>
                    <th>Status</th>
                    <th>ID</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            <div>
                                <a href="{{ route('support-tickets.detail', $ticket->id) }}" style="color: #0DA0F2">{{ $ticket->subject }}</a>
                            </div>
                            <div>
                                Category: {{ $ticket->category->title }}
                            </div>
                        </td>
                        <td>{{ Helper::customFormatDate($ticket->created_at) }}</td>
                        <td>{{ Helper::customFormatDate($ticket->updated_at) }}</td>
                        <td>{{ $ticket->status->title }}</td>
                        <td>{{ $ticket->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#clear_keyword').on('click', function() {
                $('#keyword').val('');
                submitFormSearch();
            })
        })

        function submitFormSearch() {
            $('form').submit();
        }
    </script>
@endsection