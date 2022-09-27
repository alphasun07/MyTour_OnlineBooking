<div class="collapse list-unstyled text-dark js-slideToggle{{$parent_id}} {{ (in_array($parent_id, $list_parent_ids)) ? 'show' : ''}}" id="js-modal__category--genre--top{{$parent_id}}">
    <div class="d-flex flex-row">
        <ul class="p-category__list list-unstyled w-100 ml-{{$level}}">
            @foreach ($category->childs as $category)
            @php
            $listTree = $tree .'/'. $category->name ;
            @endphp
            <li class="d-flex flex-row mt-2 js-li_{{$category->id}}" data-id="{{$category->id}}">
                ┠
                <div class="ml-2" data-toggle="collapse" data-target="#js-modal__category--genre--top{{$category->id}}" aria-expanded="false" aria-controls="js-modal__category--genre--top{{$parent_id}}" data-id="{{$category->id}}" onclick="slideToggleCategory(this)" id="js-titleA1">
                    <i class="fas fa-{{ (count($category->childs) && !in_array($category->id, $list_parent_ids)) ? 'plus' : 'minus' }} p-1 border border-dark" id="is-modal__title--A1--plus--change"></i>
                </div>
                <span class="ml-1" data-tree="{{$listTree}}" data-name="{{ $category->name ?? $category->title}}" onclick="selectCategory('{{$category->id}}', '{{$single}}', this, '{{$inputNumber}}')">{{ $category->name ?? $category->title }}</span>
            </li>
            @if (count($category->childs))
            @include('admin.common.child-category-select', ['categories' => $category->childs, 'parent_id' => $category->id, 'level' => $level + 1, 'tree' => $listTree, 'single' => $single, 'inputNumber' => $inputNumber])
            @endif
            @endforeach
        </ul>
    </div>
</div>
