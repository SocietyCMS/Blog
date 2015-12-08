<div class="ui blue segment" id="blogFilesSegment">

    <div class="ui basic segment" id="filesToolbar">
    </div>

    <div class="ui grid qq-upload-drop-area" id="blogFiles">
        <div class="eight wide tablet two wide computer photo column"  v-for="file in files" v-bind:class="{'selected': file == detailFile }" v-on:click="detail(file)">
            <a class="ui basic file raised segment">
                <i class="massive file image outline icon"></i> @{{ file.file_name }}
            </a>
        </div>
    </div>

</div>



<script type="text/template" id="filesToolbarTemplate">
    <div class="qq-uploader-selector qq-uploader">

        <div id="uploadFileButton">

            <div class="ui basic button qq-upload-button-selector qq-upload-button" >
                <i class="icon photo"></i>
                @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
            </div>
            <div class="ui red basic right floated button" id="deleteFileButton" style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>
        </div>

        <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadFileProgrssbar" style="display: none">
            <div class="bar"></div>
            <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.files')])</div>
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

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('blog:css/Blog.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('javascript--third')
    <script>

        VueInstanceFile = new Vue({
            el: '#blogFilesSegment',
            data: {
                files:null,
                detailFile: null,
                loaded: false
            },
            ready: function() {

                this.$http.get('{{apiRoute('v1', 'api.blog.article.file.index', ['article' => $article->slug])}}', function (data, status, request) {

                    this.$set('files', data.data);
                    this.$set('meta', data.meta);
                    this.$set('loaded', true);

                }).error(function (data, status, request) {
                });

            },
            methods: {
                detail: function (file) {
                    this.detailFile = file;
                    $('#deleteFileButton').show();
                },
                addFile: function(file) {
                    this.files.push(file.data);
                },
                deleteFile: function() {

                    var resource = this.$resource('{{apiRoute('v1', 'api.blog.article.image.destroy', ['article' => $article->slug, 'file' => ':id'])}}');

                    resource.delete({id: this.detailFile.id}, this.detailFile, function (data, status, request) {
                        this.files.pop(this.detailFile);
                    }).error(function (data, status, request) {
                    });
                }
            }

        });

        $('#filesToolbar').fineUploader({
            template: $('#filesToolbarTemplate'),
            request: {
                endpoint: '{{ apiRoute('v1', 'api.blog.article.file.store', ['article' => $article->slug])}}',
                inputName: 'file',
                customHeaders: {
                    "Authorization": "Bearer {{$jwtoken}}"
                }
            },
            dragAndDrop: {
                extraDropzones: [$("#blogFiles")]
            },
            callbacks: {
                onComplete: function (id, name, responseJSON) {
                    this.getItemByFileId(id).remove();
                    VueInstanceFile.addFile(responseJSON)
                },
                onUpload: function() {
                    $('#uploadFileButton').hide();
                    $('#uploadFileProgrssbar').show();
                },
                onTotalProgress: function(totalUploadedBytes, totalBytes) {
                    $('#uploadFileProgrssbar').progress({
                        percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
                    });
                },
                onAllComplete: function(succeeded, failed) {
                    $('#uploadFileButton').show();
                    $('#uploadFileProgrssbar').hide();
                }
            }
        });

        $('#deleteAlbumButton').click(function(){VueInstanceFile.deleteFile()});

    </script>

@endsection
