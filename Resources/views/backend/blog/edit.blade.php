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

        <div class="ui detail accordion field">
            <div class="title">
                <i class="icon dropdown"></i>
                @lang('core::elements.button.optional details')
            </div>
            <div class="content field">


                <div class="ui segment field">
                    <div class="ui toggle checkbox">
                        <input type='hidden' value='0' name='pinned'>
                        <input type="checkbox" name="pinned" value="1" @if(isset($article) && $article->pinned) checked @endif >
                        <label>@lang('blog::blog.state.pinned')</label>
                    </div>
                </div>

                @include('blog::backend.blog.components.media')
            </div>
        </div>

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
        $('.ui.detail.accordion')
                .accordion();
    </script>

    <script>


        var dragAndDropModule = new fineUploader.DragAndDrop({
            dropZoneElements: [document.getElementById('blogImages')],
            classes: {
                dropActive: "cssClassToAddToDropZoneOnEnter"
            },
            callbacks: {
                processingDroppedFilesComplete: function (files, dropTarget) {
                    fineUploaderBasicInstanceImages.addFiles(files);
                }
            }
        });

        var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
            button: document.getElementById('uploadImageButton'),
            request: {
                endpoint: '{{ apiRoute('v1', 'api.blog.article.image.store', ['article' => $article->slug])}}',
                inputName: 'image',
                customHeaders: {
                    "Authorization": "Bearer " + societycms.jwtoken
                }
            },
            callbacks: {
                onComplete: function (id, name, responseJSON) {
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

        $('#deleteAlbumButton').click(function(){VueInstanceImage.deletePhoto()});

    </script>

    <script>

        var dragAndDropModule = new fineUploader.DragAndDrop({
            dropZoneElements: [document.getElementById('blogFiles')],
            classes: {
                dropActive: "cssClassToAddToDropZoneOnEnter"
            },
            callbacks: {
                processingDroppedFilesComplete: function (files, dropTarget) {
                    fineUploaderBasicInstanceFiles.addFiles(files);
                }
            }
        });

        var fineUploaderBasicInstanceFiles = new fineUploader.FineUploaderBasic({
            button: document.getElementById('uploadFileButton'),
            request: {
                endpoint: '{{ apiRoute('v1', 'api.blog.article.file.store', ['article' => $article->slug])}}',
                inputName: 'file',
                customHeaders: {
                    "Authorization": "Bearer " + societycms.jwtoken
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

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('blog:css/Blog.css')}}" rel="stylesheet" type="text/css">
@endsection
