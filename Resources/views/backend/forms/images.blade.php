<div class="ui blue segment">

    <div class="ui basic segment" id="imagesToolbar">
    </div>

    <div class="ui grid qq-upload-drop-area" id="blogImages">
        <div class="eight wide tablet two wide computer photo column"  v-for="photo in album" v-bind:class="{'selected': photo == detailPhoto }" v-on:click="detail(photo)">
            <a class="ui basic photo raised segment">
                <div class="photo image"><img class="ui medium bordered image" v-bind:src="photo.thumbnail.medium"></div>
            </a>
        </div>
    </div>

</div>


@section('htmlComponents')
    <script type="text/template" id="albumToolbarTemplate">
        <div class="qq-uploader-selector qq-uploader">

            <div id="uploadButton">

                <div class="ui basic button qq-upload-button-selector qq-upload-button" >
                    <i class="icon photo"></i>
                    @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.photo')])
                </div>
                <div class="ui red basic right floated button" id="deleteAlbumButton" style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>
            </div>

            <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadProgrssbar" style="display: none">
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

        VueInstance = new Vue({
            el: '#societyAdmin',
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
                customHeaders: {
                    "Authorization": "Bearer {{$jwtoken}}"
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
                    VueInstance.addPhoto(responseJSON)
                },
                onUpload: function() {
                    $('#uploadButton').hide();
                    $('#uploadProgrssbar').show();
                },
                onTotalProgress: function(totalUploadedBytes, totalBytes) {
                    $('#uploadProgrssbar').progress({
                        percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
                    });
                },
                onAllComplete: function(succeeded, failed) {
                    $('#uploadButton').show();
                    $('#uploadProgrssbar').hide();
                }
            }
        });

        $('#deleteAlbumButton').click(function(){VueInstance.deletePhoto()});

    </script>

@endsection



<!--
<div class='box collapsed-box'>
    <div class='box-header'>
        <h3 class='box-title'>{{ trans('blog::blog.images.title') }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <dropzone-image
                url="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.blog.article.image.store',$article->slug)}}?token={{$jwtoken}}"
                init="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.blog.article.image.index',$article->slug)}}?token={{$jwtoken}}"
                destroy="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.blog.article.image.destroy',['article' => $article->slug, 'image' => '[$1]'])}}/?token={{$jwtoken}}"
                ></dropzone-image>
    </div>
</div>

-->
