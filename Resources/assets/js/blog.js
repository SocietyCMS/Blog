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
    }
});