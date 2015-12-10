@extends('layouts.master')

@section('title')
    {{ trans('blog::blog.title.blog') }}
@endsection
@section('subTitle')
    {{trans('core::elements.action.edit resource', ['name'=>trans('blog::blog.title.article')])}}
@endsection

@section('content')
    <form class="ui form" role="form" method="POST" action="{{route('backend::blog.article.update', $article->slug)}}">
        <input type="hidden" name="_method" value="PUT">
        {!! csrf_field() !!}

        @include('blog::backend.forms.article')

        <div class="ui basic clearing segment">
            <a href="{{route('backend::blog.article.index')}}" class="ui right floated button">
                {{ trans('core::elements.button.cancel') }}
            </a>
            <button class="ui primary right floated button" type="submit">
                {{ trans('core::elements.button.update') }}
            </button>
        </div>

    </form>


@endsection

@section('javascript')
    <script>
        var editor = new MediumEditor('.editable', {
            placeholder: {
                text: ''
            }
        });

        $('.ui.accordion')
                .accordion();
    </script>

    <script>

        var dragAndDropModule = new fineUploader.DragAndDrop({
            dropZoneElements: [document.getElementById('blogFiles')],
            classes: {
                dropActive: "cssClassToAddToDropZoneOnEnter"
            },
            callbacks: {
                processingDroppedFilesComplete: function (files, dropTarget) {
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
                onUpload: function () {
                    $('#uploadFileButton').hide();
                    $('#uploadFileProgrssbar').show();
                },
                onTotalProgress: function (totalUploadedBytes, totalBytes) {
                    $('#uploadFileProgrssbar').progress({
                        percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
                    });
                },
                onAllComplete: function (succeeded, failed) {
                    $('#uploadFileButton').show();
                    $('#uploadFileProgrssbar').hide();
                }
            }
        });

        $('#uploadFileProgrssbar').hide();
        $('#deleteAlbumButton').click(function () {
            VueInstanceFile.deleteFile()
        });

        VueInstanceFile = new Vue({
            el: '#uploadFilesSection',
            data: {
                files: null,
                meta: null,
                detailFile: null,
                loaded: false

            },
            ready: function () {

                this.$http.get('{{apiRoute('v1', 'api.blog.article.file.index', ['article' => $article->slug])}}', function (data, status, request) {

                    this.$set('files', data.data);
                    this.$set('meta', data.meta);
                    this.$set('loaded', true);

                }).error(function (data, status, request) {
                });

            },
            methods: {
                fileClass: function (mime) {

                    if (semanticFileTypeClassMap[mime]) {
                        return semanticFileTypeClassMap[mime]
                    }
                    return "file outline"
                },
                humanReadableFilesize: function (size) {
                    return filesize(size,{round: 0})
                },
                detail: function (file) {
                    this.detailFile = file;
                    $('#deleteFileButton').show();
                },
                addFile: function (file) {
                    this.files.push(file.data);
                },
                deleteFile: function (file) {

                    var resource = this.$resource('{{apiRoute('v1', 'api.blog.article.file.destroy', ['article' => $article->slug, 'file' => ':id'])}}');

                    resource.delete({id: file.id}, file, function (data, status, request) {
                        this.files.$remove(file);
                    }).error(function (data, status, request) {
                    });
                }
            }

        });

    </script>


@endsection
