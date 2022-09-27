@php
use App\Models\PcmDmsCategory;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Category management' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Category management'])
@endsection
<div class="row ml-0">
    <div class="col-12 pl-0">
        <div class="d-flex flex-row">
            <span class="w-25">
                <a class="btn btn-success btn-block" href="{{route('admin.category.add')}}">Add new</a>
            </span>
        </div>
    </div>
    <div class="col-12 pl-0">
        <div class="d-flex flex-row">
            <div class="o-container__background--white x_panel">
                <form method="get" action="">
                    <div class="border-bottom p-2 pl-2">
                        <input type="text" name="name" class="col-4 p-2" value="{{ $searchData['name'] ?? '' }}" placeholder="Search category">
                        <input type="submit" class="btn btn-dark ml-2" value="Search">
                    </div>
                </form>
                <dl class="o-dl__display--table">
                    <dt class="o-dtDd__display--table-cell o-dt__width--1">　</dt>
                    <dt class="o-dtDd__display--table-cell o-dt__width--1">&nbsp;</dt>
                    <dt class="o-dtDd__display--table-cell text-left">Name</dt>
                    <dt class="o-dtDd__display--table-cell o-dt__width--5">　</dt>
                </dl>
                <div id="js-sortable">
                    @if ($parent_categories->count() != 0)
                    @foreach ($parent_categories as $category)
                    <div class="p0">
                        <dl class="o-dl__display--table parent" data-sort="{{ $category->id }}">
                            <dd class="o-dtDd__display--table-cell o-dt__width--1"><i class="fas fa-bars"></i></dd>
                            <dd class="o-dtDd__display--table-cell o-dt__width--1" onclick="showHideChildCategory('{{ $category->id }}', this)"><i class="fas fa-{{count($category->childs) ? 'plus' : 'minus'}} p-1 border border-dark" id="is-modal__plus--change"></i></dd>
                            <dd class="o-dtDd__display--table-cell text-left">{{$category->name ?? ''}}</dd>
                            <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.category.detail', ['id' => $category->id])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a><i data-action="{{ route('admin.category.delete')}}" data-id="{{ $category->id}}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
                        </dl>
                        @if (count($category->childs))
                        @include('admin.common.list-child-category', ['categories' => $category->childs, 'parent_id' => $category->id, 'level' => 2])
                        @endif
                    </div>
                    @endforeach
                    @else
                    <tr>
                        <center>
                            <td colspan="4" style="text-align: center;">No data found</td>
                        </center>
                    </tr>
                    @endif
                    <div class="d-flex justify-content-center">{{$parent_categories->links()}}</div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="category_id" value="">
</div>
@endsection
@section('head')
<style>
    .dropzone {
        min-height: 0;
        border: dashed;
    }

    .dropzone .dz-message {
        text-align: unset;
        margin: 0;
    }

    .dz-preview .dz-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    .pagination {
        justify-content: center;
    }

    @for($i=2; $i < 10; $i++) .ol- {
            {
            $i
        }
    }

        {
        position: relative;

        left: {
                {
                $i * 10
            }
        }

        px;
    }

    @endfor .p-hide__category {
        display: none;
    }
</style>
@stop
@section('scripts')
<script src="{{ asset('js/admin/bootbox.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        processSortable = function() {
            var ids = new Array(),
                i = 1;
            $('.parent').each(function() {
                ids[i] = $(this).data('sort');
                i++;
            });
            console.log(ids)
            $.ajax({
                url: "{{ route('admin.category.ordering') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    ids: ids,
                },
                success: function(json) {
                    location.reload();
                }
            })
        }
        $("#js-sortable").sortable({
            items: ".p0",
            stop: function() {
                setTimeout(processSortable(), 10000)
            }
        });
        @foreach($parent_ids as $parentId)
        $("#js-sortable{{$parentId}}").sortable({
            items: ".p{{$parentId}}",
            stop: function() {
                setTimeout(processSortable(), 10000)
            }
        });
        @endforeach
        showHideChildCategory = function(parentId, ethis) {
            if ($("div").hasClass('is-show__hide--child' + parentId)) {
                if ($('.is-show__hide--child' + parentId).is(":visible")) {
                    $(ethis).children('i.fas').removeClass('fa-minus').addClass('fa-plus');
                } else {
                    $(ethis).children('i.fas').removeClass('fa-plus').addClass('fa-minus');
                }
                $('.is-show__hide--child' + parentId).slideToggle();
            }
        }
    })
</script>
@endsection