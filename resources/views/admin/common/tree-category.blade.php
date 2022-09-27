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
    <div class="collapse list-unstyled text-dark p-3" id="js-display">
        <ul class="list-unstyled">
            <li class="d-flex flex-row mt-2">
                <div data-toggle="collapse" data-target="#js-modal__category--genre--top1" aria-expanded="false" aria-controls="js-modal__category--genre--top1" class="collapsed js-showHide--plusMinus">
                    <i class="fas fa-plus p-1 border border-dark" id="is-modal__plus--change"></i>
                    <i class="fas fa-minus p-1 border border-dark o-displayNone" id="is-modal__minus--change"></i>
                </div>
                <label for="" class="ml-2 pt-1">総合トップ</label>
                <span class="flex-fill o-iconRight pt-1">
                    <input @if(old('is_top', $is_top)) checked @endif type="checkbox" name="is_top" value="{{ DtbSliderMainCategory::IS_TOP }}">
                </span>
            </li>
            <div class="collapse list-unstyled text-dark" id="js-modal__category--genre--top1">
                <div class="d-flex flex-row">
                    <ul class="list-unstyled flex-fill">
                        @if(isset($treeCategory['level1']))
                        @php
                        $level1Arr = $treeCategory['level1'];
                        $count1 = 1;
                        @endphp
                        @foreach ($level1Arr as $cat_lv1 )
                        <li class="d-flex flex-row mt-2">
                            @if(count($level1Arr) != $count1)
                            @php $count1 ++; @endphp
                            ┠
                            @else
                            ┗
                            @endif
                            <div class="ml-2 collapsed js-showHide--plusMinus" data-toggle="collapse" data-target="#js-modal__category--A2_{{$cat_lv1->id}}" aria-expanded="false" aria-controls="js-modal__category--A2_{{$cat_lv1->id}}">
                                <i class="fas fa-plus p-1 border border-dark" id="is-modal__category--A2_{{$cat_lv1->id}}--plus--change"></i>
                                <i class="fas fa-minus p-1 border border-dark o-displayNone" id="is-modal__category--A2_{{$cat_lv1->id}}--minus--change"></i>
                            </div>
                            <label for="" class="ml-2 pt-1">{{ $cat_lv1->name }}</label>
                            <span class="flex-fill o-iconRight pt-1">
                                <input @if(in_array($cat_lv1->id ,old('category', $relationIds))) checked @endif type="checkbox" name="category[]" value="{{ $cat_lv1->id }}">
                            </span>
                        </li>
                        <div class="collapse list-unstyled text-dark" id="js-modal__category--A2_{{$cat_lv1->id}}">
                            <ul class="list-unstyled ml-3 flex-fill">
                                @if(isset($treeCategory['level2'][$cat_lv1->id]))
                                @php
                                $level2Arr = $treeCategory['level2'][$cat_lv1->id];
                                $count2 = 1;
                                @endphp
                                @foreach ($level2Arr as $cat_lv2 )
                                <li class="d-flex flex-row mt-2">
                                    @if(count($level2Arr) != $count2)
                                    @php $count2++; @endphp
                                    ┠
                                    @else
                                    ┗
                                    @endif
                                    <div class="ml-2 collapsed js-showHide--plusMinus" data-toggle="collapse" data-target="#js-modal__category--A3_{{$cat_lv2->id}}" aria-expanded="false" aria-controls="js-modal__category--A3_{{$cat_lv2->id}}">
                                        <i class="fas fa-plus p-1 border border-dark" id="is-modal__category--A3_{{$cat_lv2->id}}--plus--change"></i>
                                        <i class="fas fa-minus p-1 border border-dark o-displayNone" id="is-modal__category--A3_{{$cat_lv2->id}}--minus--change"></i>
                                    </div>
                                    <label for="" class="ml-2 pt-1">{{ $cat_lv2->name }}</label>
                                    <span class="flex-fill o-iconRight pt-1">
                                        <input @if(in_array($cat_lv2->id ,old('category', $relationIds))) checked @endif type="checkbox" name="category[]" value="{{ $cat_lv2->id }}">
                                    </span>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </ul>
    </div>
</div>