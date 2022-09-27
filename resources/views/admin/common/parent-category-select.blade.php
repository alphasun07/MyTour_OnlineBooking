<div class="modal fade" id="js-category_{{$inputNumber}}" tabindex="-1" role="dialog" aria-labelledby="categoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryLabel">Select a category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body p-5">
                <ul class="list-unstyled w-100 p-category__list">
                    @foreach($categories as $category)
                    <li class="d-flex flex-row mt-2 js-li_{{$category->id}}" data-id="{{$category->id}}">
                        <div data-toggle="collapse" data-target="#js-modal__category--genre--top{{$category->id}}" aria-expanded="false" aria-controls="js-modal__category--genre--top{{$category->id}}" data-id="{{$category->id}}" onclick="slideToggleCategory(this)" id="js-categoryTop">
                            <i class="fas fa-{{ (count($category->childs) && !in_array($category->id, $list_parent_ids)) ? 'plus' : 'minus' }} p-1 border border-dark" id="is-modal__plus--change"></i>
                        </div>
                        <span for="js-categoryTop" class="ml-2 pt-1" data-name="{{ $category->title }}" data-tree="{{ $category->title }}" onclick="selectCategory('{{$category->id}}', '{{$single}}', this, '{{$inputNumber}}')">{{ $category->title ?? $category->name }}</span>
                    </li>
                    @if (count($category->childs))
                    @include('admin.common.child-category-select', ['categories' => $category->childs, 'parent_id' => $category->id, 'level' => 1, 'tree' => $category->title, 'single' => $single, 'inputNumber' => $inputNumber, 'list_parent_ids' => $list_parent_ids])
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer border-top-0 justify-content-center">
                <button type="button" data-input="{{$inputNumber}}" id="js-assign-new-categories" onclick="choiceCategory('{{$single}}', '{{$inputNumber}}')" class="btn btn-dark rounded w-25" {{ (count($categories) == 0) ? 'disabled' : '' }}>Select</button>
                <button type="button" class="btn btn-light border border-dark rounded w-25" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="categoryId_selected_tmp_{{$inputNumber}}" value="" />
<input type="hidden" name="categoryLabel_selected_tmp_{{$inputNumber}}" value="" />
