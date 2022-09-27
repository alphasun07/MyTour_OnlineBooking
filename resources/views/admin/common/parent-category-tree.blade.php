@php
use App\Models\DtbSliderMainCategory;
@endphp
<div class="col-12 o-col__padding--right--left o-container__background--white mt-2 small">
    <a href='#js-display' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#js-display' aria-controls='js-display' onclick="arrow_display()">
        <span class="d-flex flex-row justify-content-between">
            表示箇所
            <div class="is-arrowDown o-iconRight" id="is-displayArrow__down"></div>
            <div class="is-arrowUp o-iconRight o-displayNone" id="is-displayArrow__up"></div>
        </span>
    </a>
    @if($errors->has('category'))
        <ul class="parsley-errors-list filled" style="padding-left: 15px;">
            <li class="parsley-required">{{$errors->first('category')}}</li>
        </ul>
    @endif
    <div class="collapse list-unstyled text-dark p-3" id="js-display">
        <ul class="list-unstyled">
            <li class="d-flex flex-row mt-2">
                <div data-toggle="collapse" data-target="#js-modal__category--genre--top0" aria-expanded="false" aria-controls="js-modal__category--genre--top0" data-id="0" onclick="slideToggleCategory(this)">
                    <i class="fas fa-plus p-1 border border-dark" id="is-modal__plus--change"></i>
                </div>
                <label for="" class="ml-2 pt-1">総合トップ</label>
                <span class="flex-fill o-iconRight pt-1">
                    <input @if(old('is_top', $is_top)) checked @endif type="checkbox" name="is_top" value="{{ DtbSliderMainCategory::IS_TOP }}">
                </span>
            </li>
            <div class="ml-2 collapse list-unstyled text-dark js-slideToggle0" id="js-modal__category--genre--top0">
                <div class="d-flex flex-row">
                    <ul class="list-unstyled flex-fill">
                        @foreach($categories as $category)
                        <li class="d-flex flex-row mt-2">
                            <strong>┠</strong>
                            <div class="ml-2" data-toggle="collapse" data-target="#js-modal__category--genre--top{{$category->id}}" aria-expanded="false" aria-controls="js-modal__category--genre--top{{$category->id}}" data-id="{{$category->id}}" onclick="slideToggleCategory(this)">
                                <i class="fas fa-{{ (count($category->childs)) ? 'plus' : 'minus' }} p-1 border border-dark" id="is-modal__plus--change"></i>
                            </div>
                            <label for="" class="ml-2 pt-1">{{$category->name}}</label>
                            <span class="flex-fill o-iconRight pt-1">
                                <input @if(in_array($category->id ,old('category', $category_id_relation_ids))) checked @endif type="checkbox" name="category[]" value="{{ $category->id }}">
                            </span>
                        </li>
                        @if (count($category->childs))
                            @include('admin.common.child-category-tree', ['categories' => $category->childs, 'parent_id' => $category->id, 'level' => 2, 'category_id_relation_ids' => $category_id_relation_ids])
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </ul>
    </div>
</div>