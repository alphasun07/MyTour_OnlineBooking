@php
$label = isset($label) ? $label : '選んでください';
@endphp
<select name="{{$name}}" class="p-2 flex-fill w-100" id="js-selectCategory" data-level="{{$level}}" {{ (isset($required) && $required) ? 'data-parsley-errors-container=#category-name-error__'.$name.' required data-parsley-required-message=選択してください。' : ''}} data-type="{{isset($type) ? $type : ''}}" {{(!$noneChange) ? "onchange=changeCategory(this)" : '' }}>
    <option selected value="">{{$label}}</option>
        @foreach ($categories as $category)
            <option {{($category->id == $category_id) ? 'selected="selected"' : ''}} value="{{$category->id}}">
                {{ $category->title ?? $category->name }}
            </option>
        @endforeach
</select>
