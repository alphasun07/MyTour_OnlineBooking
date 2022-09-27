@php
use App\Models\DtbSliderMainCategory;
@endphp
<div class="collapse list-unstyled text-dark js-slideToggle{{$parent_id}}" id="js-modal__category--genre--top{{$parent_id}}">
    <div class="d-flex flex-row">
        <ul class="list-unstyled flex-fill">
            @foreach ($categories as $category)
            <li class="d-flex flex-row mt-2">
                <span class="d-flex flex-row ml-{{$level}} w-100">
                    ┗
                    <div class="ml-2" data-toggle="collapse" data-target="#js-modal__category--genre--top{{$category->id}}" aria-expanded="false" aria-controls="js-modal__category--genre--top{{$category->id}}" data-id="{{$category->id}}" onclick="slideToggleCategory(this)">
                        <i class="fas fa-{{ (count($category->childs)) ? 'plus' : 'minus' }} p-1 border border-dark" id="is-modal__title--A1--plus--change"></i>
                    </div>
                    <label for="" class="ml-2 pt-1">{{$category->name ?? $category->title}}</label>
                    <span class="flex-fill o-iconRight pt-1">
                        <input @if(in_array($category->id ,old('category', $category_id_relation_ids))) checked @endif type="checkbox" name="category[]" value="{{ $category->id }}">
                    </span>
                </span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
