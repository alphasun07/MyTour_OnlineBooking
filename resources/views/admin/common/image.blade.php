@php
    use App\Models\PcmDmsDocumentImage;
@endphp
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center w-50">Image</th>
            <th class="text-center w-10">Published</th>
            <th class="text-center w-5"></th>
        </tr>
    </thead>
    <tbody id="document_images_area">
        @if(isset($document) && !$document->images->isEmpty())
            @foreach ($document->images as $image)
            <tr id="document_image_{{ $image->id ?? 0 }}">
                <td class="text-center" style="width:60%">
                    <img id="ImgDocumentPreview{{ $image->id ?? 0 }}" src="{{ asset('storage/documents/'.($document->id ?? '').'/'.($image->image ?? '')) }}" class="preview{{ $image->id ?? 0 }}" style="max-width:80px;max-height:80px;" />
                </td>
                <td class="text-center" style="width:25%;">
                    <select name="document_image[published][old][{{ $image->id ?? 0 }}]" class="form-control">
                        @foreach (PcmDmsDocumentImage::PUBLISHED as $key=>$val)
                        <option value="{{ $key ?? '' }}" {{ (isset($image->published) && !old('document_image[published][old]['.$image->id.']') && $image->published==$key) || (old('document_image[published][old]['.$image->id.']') && old('document_image[published][old]['.$image->id.']') == $key) ? 'selected' : '' }}>{{ $val ?? '' }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="text-align: center;"><input type="button" class="btn btn-sm btn-danger" name="btnRemove" value="Delete" onclick="removeDocumentImage({{ $image->id ?? 0 }}, {{ $image->id ?? '' }});" /></td>
            </tr>
            @endforeach
        @else
            <tr id="document_image_0">
                <td class="text-center width-50">
                    <span class="btn_upload p-t-1"><input type="file" name="document_image[image][]" id="documentImage0" onchange="uploadImageDocument(this, 0)"/></span>
                    <img id="ImgDocumentPreview0" src="" class="preview0" style="max-width:80px;max-height:80px;" />
                    <input type="button" id="removeImage0" onclick="removeImagePreview(0)" value="x" class="btn-rmv btn-rmv0" />
                </td>
                <td class="text-center">
                    <select name="document_image[published][new][]" class="form-control">
                        @foreach (PcmDmsDocumentImage::PUBLISHED as $key=>$val)
                        <option value="{{ $key ?? '' }}">{{ $val ?? '' }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="text-align: center;"><input type="button" class="btn btn-sm btn-danger" name="btnRemove" value="Delete" onclick="removeDocumentImage(0);" /></td>
            </tr>
        @endisset
        <input type="hidden" name="maxImgID" value="{{ $maxImgID ?? 0 }}">
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center"><input type="button" style="width: 50px;" class="btn btn-sm btn-primary" value="ADD" onclick="addDocumentImage();" /></td>
            @error('document_image.image.*')
            <td>
                <div class="text-danger p-3 text-center" role="alert">
                    <strong>{{ 'The file uploaded must be an image.' }}</strong>
                </div>
            </td>
            @enderror
            @error('document_image.published.*')
            <td>
                <div class="text-danger p-3 text-center" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            </td>
            @enderror
        </tr>
    </tfoot>
</table>
