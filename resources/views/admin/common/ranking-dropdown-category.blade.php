@php
$label = isset($label) ? $label : '選んでください';
@endphp
<select name="{{$name}}" class="p-2 flex-fill" id="js-selectCategory" data-level="{{$level}}" {{ (isset($required) && $required) ? 'data-parsley-errors-container=#category-name-error__'.$name.' required data-parsley-required-message=選択してください。' : ''}} data-type="{{isset($type) ? $type : ''}}" {{(!$none_change) ? "onchange=changeCategory(this)" : '' }}>
    <option disabled selected value>選択してください</option>
        @foreach ($categories as $category)
            <option {{($category->id == $category_id) ? 'selected="selected"' : ''}} value="{{$category->id}}{{$category->quantity_profit_flag ? ','. $category->quantity_profit_flag : ''}}" label="{{ $category->name }}">
            </option>
        @endforeach
</select>