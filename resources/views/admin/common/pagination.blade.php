@php
$item_per_pages = [20, 50, 100, 150, 200, 250];
@endphp
<select name="per_page" id="per_page" class="p-3 bd-highlight">
@foreach($item_per_pages as $item_per_page)
    <option {{ (isset($per_page) && $per_page == $item_per_page) ? 'selected' : '' }} value="{{ $item_per_page }}">{{ $item_per_page }}件</option>
@endforeach
</select>