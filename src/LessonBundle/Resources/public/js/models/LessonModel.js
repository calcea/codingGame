/**
 * Created by george on 4/20/2016.
 */
var LessonModel = Backbone.Model.extend({
    urlPostAnswer: '/post-answer',
    postAnswer: function (data, successCallback, errorCallback) {
        data.format = 'json';
        var _this = this;
        var request = $.ajax({
            url: _this.urlPostAnswer,
            method: "POST",
            data: data,
            dataType: "json"
        });
        request.done(function (data) {
            if (typeof successCallback === "function") {
                successCallback(data);
            }
        });

        request.fail(function (data) {
            if (typeof errorCallback === "function") {
                errorCallback(data);
            }
        });
    }
});