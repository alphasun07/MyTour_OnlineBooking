<li><a href="{{ route('home.category.show', $category->id) }}">{{ $category->name}}
    @if (count($category->childs) > 0)
        <ul>
            @foreach ($category->childs as $sub)
                @include('front.dms.category.sub_category', ['category' => $sub])
            @endforeach
        </ul>
    @endif
</a></li>