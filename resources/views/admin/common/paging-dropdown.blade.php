@php
    $limits = [20,40,60,80,100];
@endphp
<select name="limit" class="{{ $valueClass ?? 'form-control input-sm w-auto' }}" id="limit" onclick="window.onbeforeunload = null;" onchange="this.form.submit()">
    @foreach($limits as $value)
    <option value="{{ $value }}" {{ (!empty($limit) && $limit == $value) ? 'selected' : '' }}>{{ $value }}件</option>
    @endforeach
</select>