<select id="category_id_title" required data-parsley-required-message="選択してください。" name="category_id_title" data-parsley-errors-container="#category_id_title-errors" class="p-2 flex-fill">
    <option disabled selected value>選択してください</option>
        @if(isset($category_titles))
        @foreach ($category_titles as $title)
            <option value="{{$title->id}}" {{isset($category_id_title) && $category_id_title == $title->id ? 'selected' : '' }}>
                {{ $title->name }}
            </option>
        @endforeach
        @endif
</select>