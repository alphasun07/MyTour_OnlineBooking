<div class="modal fade" id="js-media" tabindex="-1" role="dialog" aria-labelledby="mediaLabel" aria-hidden="true">
    <div class="modal-dialog p-modalDialog__width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaLabel">メディアの追加</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li>
                        <div class="p-2 w-100 popup-upload-image">
                            <div id="is-image__url" class="d-flex flex-row border-secondary o-borderDash justify-content-center pb-4 pt-4 ml-3">
                                <div class="dz-default dz-message d-flex flex-row p-2 justify-content-center">
                                    <i class="fas fa-cloud-download p-3 fa-3x icon-color"></i>
                                    <span class="align-self-center small">画像をドラッグ＆ドロップまたは</span>
                                    <span class="mt-2 flex-fill ml-3 align-self-center">
                                        <label for="product_main_image_url" class="filelabel o-buttonSize">ファイル選択</label>
                                    </span>
                                </div>
                            </div>
                            <div id="error-image_url" class="error-message mt-1">
                                <ul class="parsley-errors-list filled"></ul>
                            </div>
                            <input require type="hidden" name="image_url" value="">
                        </div>
                    </li>
                    <li>
                        <div class="d-flex flex-row">
                            <div class="w-75 o-col__padding--right--left">
                                <div class="d-flex flex-column" id="is-listImage__preview">
                                    <div class="o-iconCenter mt-5">
                                        <button class="btn btn-dark btn-sm rounded font-weight-bold is-insertImage" disabled>画像を挿入</button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-25 o-col__padding--right--left pt-3 pl-3 pr-2">
                                <ul class="list-unstyled flex-fill">
                                    <li class="border-bottom">
                                        <span>画像情報</span>
                                    </li>
                                    <li class="d-flex flex-column">
                                        <!-- 画像の情報をDBからとってきて表示 -->
                                        <span class="mt-2" id="is-image__create"></span>
                                        <span class="mt-2" id="is-image__size"></span>
                                        <span class="mt-2 p-image__name" id="is-image__name"></span>
                                        <button type="button" class="btn o-button__color--white btn-block btn-outline-dark w-50 mt-3 js-image__delete">削除</button>
                                    </li>
                                    <li class="d-flex flex-column">
                                        <label class="mt-2" for="">ALT</label>
                                        <input type="text" name="" id="" placeholder="画像の代替テキスト" class="rounded is-altImage">
                                    </li>
                                    <li class="d-flex flex-column">
                                        <span class="mt-2">URL</span>
                                        <!-- コピー対象はinputのvalue -->
                                        <input id="p-modal__copy--Target" type="text" class="rounded mt-2 is-image__url" readonly>
                                        <button type="button" class="btn btn-dark btn-sm rounded mt-4" onclick="modal_copyToClipboard()">URLのコピー</button>
                                    </li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>