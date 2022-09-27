@php
@endphp
@extends('front.common.app', ['active' => 'new'])
@section('title')
Support Tickets - Add New
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
</section>
<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title pb-0">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="section-main-title w-100">New Ticket</h2>
                </div>
            </div>
            <form method="POST" action="{{ route('support-tickets.store') }}" id="form-new-ticket" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3 mt-3">
                    <label class="pt-2 col-md-2">Category<span class="text-danger">*</span></label>
                    <div class="col-md-10 row">
                        <div class="col-md-4">
                            <select class="form-select" name="category_id" data-parsley-required>
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{old('category_id') && old('category_id')==$category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="pt-2 col-md-2">Subject<span class="text-danger">*</span></label>
                    <div class="col-md-10 row">
                        <div class="col-md-6">
                            <input type="text" name="subject" value="{{ old('subject', '') }}" class="form-control" data-parsley-required data-parsley-maxlength="255">
                        </div>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="pt-2 col-md-2">Priority<span class="text-danger">*</span></label>
                    <div class="col-md-10 row">
                        <div class="col-md-4">
                            <select class="form-select" name="priority_id" data-parsley-required>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}" {{ (old('priority_id') && old('priority_id')==$priority->id) || ($priority->id==$config->default_ticket_priority_id) ? 'selected' : '' }}>{{ $priority->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="pt-2 col-md-2">Message<span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea name="message"  rows="7" class="form-control w-100" data-parsley-required>{{ old('message', '') }}</textarea>
                    </div>
                </div>
                @if($config->enable_attachment)
                <div class="row mb-3 mt-3">
                    <label class="pt-2 col-md-2">Attachments</label>
                    @if($config->max_number_attachments>0)
                    <div class="col-md-10">
                        <div class="mb-3">
                            <div id="file-attach">
                                <div class="attachment d-flex justify-content-between">
                                    <input type="file" name="attachments[]" id="cmt-file" class="w-100">
                                    <div class="mr-4" onclick="removeAttach($(this))"><i class="fa fa-times text-danger" style="font-size:18px; cursor: pointer;" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" id="btn-add-attachment">Add attachment</button>
                            </div>
                            @error('attachments.*')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                <div class="d-flex justify-content-center">
                    <input type="submit" id="btn-new-ticket" class="btn btn-primary me-3" value="Submit Ticket">
                    <input type="button" class="btn btn-primary" value="Cancel">
                </div>
            </form>
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

            $('#btn-new-ticket').on('click', function() {
                var form = $('#form-new-ticket');
                form.parsley();

                form.submit();
            })
        })

        function removeAttach(e, attachName) {
            attach_count--;
            $('#btn-add-attachment').removeClass('d-none');
            e.closest('.attachment').remove();
        }
    </script>
@endsection