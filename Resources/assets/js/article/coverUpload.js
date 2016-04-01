var dragAndDropModule = new fineUploader.DragAndDrop({
    dropZoneElements: [document.getElementById('blogCovers')],
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
            endpoint: Vue.url(societycms.api.blog.article.cover.store,{slug:societycms.blog.article.slug}),
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
    onTotalProgress: function (totalUploadedBytes, totalBytes) {
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

var VueInstanceImage = new Vue({
    el: '#blogImagesSegment',
    data: {
        cover:null,
        loaded: false,
        meta:null
    },
    ready: function() {

        var resource = this.$resource(societycms.api.blog.article.cover.index);

        resource.get({slug:societycms.blog.article.slug}, function (data, status, request) {
            this.$set('cover', data.data);
            this.$set('meta', data.meta);
            this.$set('loaded', true);
        }).error(function (data, status, request) {
        });

    },
    methods: {
        addPhoto: function(photo) {
            this.cover = photo.data;
        },
        deletePhoto: function() {
            var resource = this.$resource(societycms.api.blog.article.cover.destroy);
            resource.delete({slug:societycms.blog.article.slug}, function (data, status, request) {
                this.cover = null;
            }).error(function (data, status, request) {
            });
        }
    }

});

$('#deleteAlbumButton').click(function(){VueInstanceImage.deletePhoto()});