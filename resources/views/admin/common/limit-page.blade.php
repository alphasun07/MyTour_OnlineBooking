<select name="limit" class="bd-highlight p-2">
    @foreach ($limitArray as $limit_number => $text_limit)
        <option @if(!empty($postData['limit']) && $postData['limit'] == $limit_number) selected @endif value="{{$limit_number}}">{{$limit_number}}件</option>
    @endforeach
</select>