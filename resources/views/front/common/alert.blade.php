<div class="x_content bs-example-popovers">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('success_html'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{!! $message !!}</strong>
        </div>
    @endif
    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
</div>