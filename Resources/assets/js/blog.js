var VueInstance = new Vue({
    el: '#societyAdmin',
    data: {
        newArticle: {
            title: null
        }
    },
    methods: {
        newArticleModal: function() {
            $('#newArticleModal')
                .modal('setting', 'transition', 'fade up')
                .modal('show');
        },
        createNewArticle: function() {
            var resource = this.$resource(societycms.api.blog.article.store);

            resource.save(this.newArticle, function (data, status, request) {
            }).error(function (data, status, request) {
            });
        },
    }
});