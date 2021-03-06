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
        endpoint: Vue.url(societycms.api.blog.article.file.store, {slug: societycms.blog.article.slug}),
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

var VueInstanceFile = new Vue({
    el: '#uploadFilesSection',
    data: {
        files: null,
        meta: null,
        detailFile: null,
        loaded: false

    },
    ready: function () {


        var resource = this.$resource(societycms.api.blog.article.file.index);

        resource.get({slug: societycms.blog.article.slug}, function (data, status, request) {
            this.$set('files', data.data);
            this.$set('meta', data.meta);
            this.$set('loaded', true);
        }).error(function (data, status, request) {
        });

    },
    methods: {
        addFile: function (file) {
            this.files.push(file.data);
        },
        deleteFile: function (file) {

            var resource = this.$resource(societycms.api.blog.article.file.destroy);

            resource.delete({slug: societycms.blog.article.slug, id: file.id}, file, function (data, status, request) {
                this.files.$remove(file);
            }).error(function (data, status, request) {
            });
        }
    }

});

$('#uploadFileProgrssbar').hide();
