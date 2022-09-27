@php
use App\Helpers\Helper;
use Carbon\Carbon;
@endphp
@extends('front.common.app', ['active' => 'view'])
@section('title')
Support Tickets - Detail
@endsection
@section('head')
<style>
    .attach-link{
        color: #0d6efd;
        text-decoration: underline;
    }
    .attach-link:hover{
        color: #0a58ca;
        text-decoration: underline;
    }
</style>
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
</section>
<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title pb-0">
            <div id="alert"></div>
            <div class="row">
                <div class="col-md-3">
                    <h2 class="section-main-title w-100">View Ticket</h2>
                </div>
            </div>
            <div class="row tk-search">
                <input type="hidden" name="id" value="{{ $ticket->id }}">
                <div class="col-md-3">
                    <select class="form-select w-100" name="category_id" onchange="change_ticket_option($(this))">
                        <option selected>Change Ticket Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select w-100" name="status_id" onchange="change_ticket_option($(this))">
                        <option selected>Change Ticket Status</option>
                        @foreach ($status as $val)
                            <option value="{{ $val->id }}">{{ $val->id . ' - ' . $val->title }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select w-100" name="priority_id" onchange="change_ticket_option($(this))">
                        <option selected>Change Ticket Priority</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                        @endforeach
                      </select>
                </div>
            </div>
        </div>
        <div class="ticket-content mt-3 row d-flex justify-content-between">
            <div class="col-md-8">
                <div>
                    <div class="pb-3" style="border-bottom: 1px solid #0DA0F2;">
                        <div><strong>[#{{ $ticket->id }}] - {{ $ticket->subject }}</strong></div>
                        <div class="mb-1">{{ $ticket->message }}</div>
                        @if(isset($attachments) && $attachments[0]!='')
                            @foreach ($attachments as $attach)
                            <a target="_blank" class="d-block attach-link" href="{{ route('support-tickets.downloadFile', ['name' => $attach ?? '', 'id' => $ticket->id ?? '', 'folder' => 'tickets/']) }}">{{ $attach ?? '' }}</a>
                            @endforeach
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-3 add-cmt">
                        <div>Comments</div>
                        <div><a href="#" class="btn-add-cmt">Add comment <i class="fas fa-comment-medical"></i></a></div>
                    </div>
                    <div class="form-cmt mt-3 {{ !$errors->has('attachments.*') ? 'd-none' : '' }}">
                        <form method="POST" action="{{ route('support-tickets.store-comment') }}" id="form-add-comment" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <div class="mt-3">
                                <textarea name="comment" rows="7" class="form-control w-100" data-parsley-required> {{ old('comment', '') }}</textarea>
                            </div>
                            @if ($config->enable_attachment)
                                <p class="font-weight-bold">Attachments</p>
                                @if($config->max_number_attachments>0)
                                <div class="ms-5">
                                    <div id="file-attach">
                                        <div class="attachment d-flex justify-content-between">
                                            <input type="file" name="attachments[]" id="cmt-file" class="w-100">
                                            <div class="mr-4" onclick="removeAttach($(this))"><i class="fa fa-times text-danger" style="font-size:18px; cursor: pointer;" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    @error('attachments.*')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-primary" id="btn-add-attachment">Add attachment</button>
                                    </div>
                                </div>
                                @endif
                            @endif
                            <div class="my-3">
                                <button type="button" id="btn-add-comment" class="btn btn-primary">Submit comment</button>
                            </div>
                        </form>
                    </div>
                    <div>
                        @foreach ($comments as $message)
                            <div class="comment-detail">
                                <div class="d-flex justify-content-between title">
                                    <div>
                                        <span><img src="{{asset('images/icon-user.jpeg')}}" alt="" class="cmt-user-avatar"></span>
                                        <span class="font-weight-bold">{{ $message->name }}</span> - [#{{ $message->id }}]
                                    </div>
                                    <div>{{ Helper::customFormatDate($message->date_added) }}</div>
                                </div>
                                <div class="content">
                                    <div>{!! $message->message !!}</div>
                                    @if(isset($message->attachments) && $message->attachments!='')
                                        @foreach (explode('|', $message->attachments) as $attach)
                                        <a target="_blank" class="d-block attach-link" href="{{ route('support-tickets.downloadFile', ['name' => $attach ?? '', 'id' => $message->id ?? '', 'folder' => 'messages/']) }}">{{ $attach ?? '' }}</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center mt-3">{!! $ticket->messages->render() !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ticket-detail" id="ticket_detail">
                @include('front.dms.ticket.detail', ['ticket' => $ticket])
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('libs/parsley/parsley.min.js') }}"></script>
    <script src="{{ asset('libs/parsley/en.js') }}"></script>
    <script src="{{ asset('js/admin/common.js') }}"></script>

    <script type="text/javascript">
        var attach_count = 1;
        var max_number_attach = {{ $config->max_number_attachments }};

        $(document).ready(function() {
            $('.btn-add-cmt').on('click', function() {
                $('.form-cmt').toggleClass('d-none');
            })

            $('#btn-add-attachment').on('click', function(){
                var html_attachment = '<div class="attachment d-flex justify-content-between mt-2">';
                html_attachment += '<input type="file" name="attachments[]">';
                html_attachment += '<div class="mr-4" onclick="removeAttach($(this))"><i class="fa fa-times text-danger" style="font-size:18px; cursor: pointer;" aria-hidden="true"></i></div>';
                html_attachment += '</div>';
                $('#file-attach').append(html_attachment);
                attach_count++;
                if(attach_count >= max_number_attach){
                    $(this).addClass('d-none');
                };
            });

            $('#btn-add-comment').on('click', function() {
                var form = $('#form-add-comment')
                form.parsley();

                form.submit();
            })
        })

        function removeAttach(e, attachName) {
            attach_count--;
            $('#btn-add-attachment').removeClass('d-none');
            e.closest('.attachment').remove();
        }

        function change_ticket_option(e){
            var data = e.val();
            var colName = e.attr('name');
            console.log(colName);
            $.ajax({
                url: "{{ route('support-tickets.update') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    colName: colName,
                    data: data,
                    id: $('[name="id"]').val()
                },
                success: function(json) {
                    if (json.success) {
                        $('#ticket_detail').html(json.html);
                        $('#alert').html('<div class="alert alert-success w-75 mb-1 alert-dismissible fade show" role="alert">Ticket detail has been changed.</div>');
                    } else {
                        $('#alert').html('<div class="alert alert-warning w-75 mb-1 alert-dismissible fade show" role="alert">An error has occurred.</div>');
                    }
                    $('#alert').show().fadeOut(3000);
                },
                error: function(json) {
                    console.log('An error has occurred');
                }
            });
        }
    </script>
@endsection