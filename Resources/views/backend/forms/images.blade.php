


@section('htmlComponents')
    <script type="text/template" id="albumToolbarTemplate">
        <div class="qq-uploader-selector qq-uploader">

            <div id="uploadImageButton">

                <div class="ui basic button qq-upload-button-selector qq-upload-button" >
                    <i class="icon photo"></i>
                    @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.photo')])
                </div>
                <div class="ui red basic right floated button" id="deleteAlbumButton" style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>
            </div>

            <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadImageProgrssbar" style="display: none">
                <div class="bar"></div>
                <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.photos')])</div>
            </div>

            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals" style="display: none">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

        </div>
    </script>
@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('blog:css/Blog.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('javascript--second')
    <script>

        VueInstanceImage = new Vue({
            el: '#blogImagesSegment',
            data: {
                album:null,
                detailPhoto: null,
                loaded: false
            },
            ready: function() {

                this.$http.get('{{apiRoute('v1', 'api.blog.article.image.index', ['article' => $article->slug])}}', function (data, status, request) {

                    this.$set('album', data.data);
                    this.$set('meta', data.meta);
                    this.$set('loaded', true);

                }).error(function (data, status, request) {
                });

            },
            methods: {
                detail: function (photo) {
                    this.detailPhoto = photo;
                    $('#deleteAlbumButton').show();
                },
                addPhoto: function(photo) {
                    this.album.push(photo.data);
                },
                deletePhoto: function() {

                    var resource = this.$resource('{{apiRoute('v1', 'api.blog.article.image.destroy', ['article' => $article->slug, 'image' => ':id'])}}');

                    resource.delete({id: this.detailPhoto.id}, this.detailPhoto, function (data, status, request) {
                        this.album.pop(this.detailPhoto);
                    }).error(function (data, status, request) {
                    });
                }
            }

        });

        $('#imagesToolbar').fineUploader({
            template: $('#albumToolbarTemplate'),
            request: {
                endpoint: '{{ apiRoute('v1', 'api.blog.article.image.store', ['article' => $article->slug])}}',
                inputName: 'image',
                customHeaders: {
                    "Authorization": "Bearer " + societycms.jwtoken
                }
            },
            dragAndDrop: {
                extraDropzones: [$("#blogImages")]
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
            },
            callbacks: {
                onComplete: function (id, name, responseJSON) {
                    this.getItemByFileId(id).remove();
                    VueInstanceImage.addPhoto(responseJSON)
                },
                onUpload: function() {
                    $('#uploadImageButton').hide();
                    $('#uploadImageProgrssbar').show();
                },
                onTotalProgress: function(totalUploadedBytes, totalBytes) {
                    $('#uploadImageProgrssbar').progress({
                        percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
                    });
                },
                onAllComplete: function(succeeded, failed) {
                    $('#uploadImageButton').show();
                    $('#uploadImageProgrssbar').hide();
                }
            }
        });

        $('#deleteAlbumButton').click(function(){VueInstanceImage.deletePhoto()});

    </script>

@endsection
