@php
$name = isset($name) ? $name  : '';
$label = isset($label) ? $label : '選んでください';
@endphp
<select name="{{$name}}" class="p-2 flex-fill" {{ (isset($required) && $required) ? 'data-parsley-errors-container=#category-name-error__'.$name.' required data-parsley-required-message=選択してください。' : ''}}>
    <option selected value="">{{$label}}</option>
</select>