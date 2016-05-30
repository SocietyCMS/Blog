var VueInstance = new Vue({
    el: '#societyAdmin',
    data: {
        newArticle: {
            title: null
        }
    },
    methods: {
        newArticleModal: function () {
            $('#newArticleModal')
                .modal('setting', 'transition', 'fade up')
                .modal('show');
        },
        deleteArticleModal: function (slug) {
            $('#deleteArticleModal')
                .modal('setting', 'transition', 'fade up')
                .modal({
                    closable  : false,
                    onApprove : function() {
                        VueInstance.deleteArticle(slug)
                    }
                })
                .modal('show');
        },
        createNewArticle: function () {
            var resource = this.$resource(societycms.api.blog.article.store);

            resource.save(this.newArticle, function (data, status, request) {
                var backend;

                if (data.data.links) {
                    data.data.links.forEach(function (data) {
                        if (data.rel == "backend") {
                            backend = data.url
                        }
                    })
                }
                window.location.replace(backend)
            }).error(function (data, status, request) {
                $('#newArticleModal')
                    .modal('close');
                Toastr.error('Error');
            });
        },
        deleteArticle: function (slug) {
            var resource = this.$resource(societycms.api.blog.article.destroy);

            resource.delete({article: slug}, function (data, status, request) {
                location.reload();
            }).error(function (data, status, request) {
            });
        }
    }
});