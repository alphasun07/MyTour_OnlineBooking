<div id="topbar" class="d-flex align-items-center fixed-top" style="background: #0DA0F2; max-height: 37px !important; height: 37px !important">
    <div class="container d-flex justify-content-end">
        <div class="d-none d-lg-flex align-items-center">
            <div class="div4 social-links">
                <a href="{{ route('download.list') }}">{{ trans('home.my_download') }}</a>
                <span style="color: rgba(255, 255, 255, 0.3); padding-left: 10px;"> | </span>
                <a href="{{ route('support-tickets.index') }}">{{ trans('home.support_ticket') }}</a>
                <span style="color: rgba(255, 255, 255, 0.3); padding-left: 10px;"> | </span>
                <a href="{{ route('home.post.contact') }}">{{ trans('home.contact_us') }}</a>
            </div>
        </div>
    </div>
</div>
