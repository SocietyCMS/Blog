<div class="ui blue segment" id="blogFilesSegment">

    <div class="ui basic segment" id="filesToolbar">

        <div class="ui basic button" id="uploadFileButton">
            <i class="icon photo"></i>
            @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
        </div>
        <div class="ui red basic right floated button" id="deleteFileButton" style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>


        <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadFileProgrssbar" style="display: none">
            <div class="bar"></div>
            <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.files')])</div>
        </div>
    </div>

    <div class="ui grid qq-upload-drop-area" id="blogFiles">
        <div class="eight wide tablet two wide computer photo column"  v-for="file in files" v-bind:class="{'selected': file == detailFile }" v-on:click="detail(file)">
            <a class="ui basic file raised segment">
                <i class="massive file image outline icon"></i> @{{ file.file_name }}
            </a>
        </div>
    </div>

</div>


@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('blog:css/Blog.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('javascript--third')
    <script>

        var dragAndDropModule = new fineUploader.DragAndDrop({
                    dropZoneElements: [document.getElementById('blogFiles')],
                    classes: {
                        dropActive: "cssClassToAddToDropZoneOnEnter"
                    },
                    callbacks: {
                        processingDroppedFilesComplete: function(files, dropTarget) {
                            fineUploaderBasicInstance.addFiles(files);
                        }
                    }
                });

        var fineUploaderBasicInstance = new fineUploader.FineUploaderBasic({
                    button: document.getElementById('uploadFileButton'),
                    request: {
                        endpoint: '{{ apiRoute('v1', 'api.blog.article.file.store', ['article' => $article->slug])}}',
                        inputName: 'file',
                        customHeaders: {
                            "Authorization": "Bearer {{$jwtoken}}"
                        }
                    },
                    callbacks: {
                        onComplete: function (id, name, responseJSON) {
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

    </script>

@endsection
