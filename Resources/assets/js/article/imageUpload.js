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
            endpoint: Vue.url(societycms.api.blog.article.cover.store,{article:societycms.blog.article.slug}),
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
        album:null,
        detailPhoto: null,
        loaded: false,
        meta:null
    },
    ready: function() {

        this.$http.get({article:societycms.blog.article.slug}, societycms.api.blog.article.cover.index, function (data, status, request) {

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

            var resource = this.$resource(societycms.api.blog.article.cover.destroy);

            resource.delete({article:societycms.blog.article.slug, id: this.detailPhoto.id}, this.detailPhoto, function (data, status, request) {
                this.album.pop(this.detailPhoto);
            }).error(function (data, status, request) {
            });
        }
    }

});

$('#deleteAlbumButton').click(function(){VueInstanceImage.deletePhoto()});