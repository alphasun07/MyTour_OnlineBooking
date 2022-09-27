@php
use App\Models\PcmDmsCategory;
@endphp
<div id="js-sortable{{$parent_id}}" class="p-hide__category is-show__hide--child{{$parent_id}}">
    @foreach ($categories as $category)
    <div class="p{{$parent_id}}">
        <dl class="o-dl__display--table parent" data-sort="{{ $category->id }}">
            <dd class="o-dtDd__display--table-cell o-dt__width--2"><i class="fas fa-bars"></i></dd>
            <dd class="o-dtDd__display--table-cell o-dt__width--2 ol-{{$level}}" onclick="showHideChildCategory('{{ $category->id }}', this)"><i class="fas fa-{{count($category->childs) ? 'plus' : 'minus'}} p-1 border border-dark" id="is-modal__plus--change"></i></dd>
            <dd class="o-dtDd__display--table-cell text-left ol-{{$level}}">{{$category->title ?? ''}}</dd>
            <dd class="o-dtDd__display--table-cell o-dt__width--10 text-left">{{$category->category_url ?? ''}}</dd>
            <dd class="o-dtDd__display--table-cell o-dt__width--5 text-center">
                @if ($category->icon)
                <input type="checkbox" disabled="disabled" checked="checked">
                @endif
            </dd>
            <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.helpdesk.category.detail', ['id' => $category->id])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a>
                <i data-action="{{ route('admin.helpdesk.category.delete')}}" data-id="{{ $category->id}}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
        </dl>
        @if (count($category->childs))
        @include('admin.common.list-child-category-helpdesk', ['categories' => $category->childs, 'parent_id' => $category->id, 'level' => $level + 1])
        @endif
    </div>
    @endforeach
</div>
