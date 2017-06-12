/**
 * Created by george on 4/20/2016.
 */

var lessonService = (function () {

    var LessonService = function () {

        this.init();
        this.bindActions();
    };

    LessonService.prototype.model = null;
    LessonService.prototype.view = null;
    LessonService.prototype.displayBadgesView = null;

    LessonService.prototype.init = function () {
        this.view = new LessonView();
        this.model = new LessonModel();
        this.displayBadgesView = new DisplayBadge();
    };

    LessonService.prototype.bindActions = function () {
        var _this = this;
        var events = {
            'post-answer': 'postAnswer'
        };

        function registerListener(evtName, callbackName) {
            if (typeof _this[callbackName] === "function") {
                $(document).on(evtName, function (e, eventData) {
                    _this[callbackName](eventData);
                });
            }
        }

        for (var i in events) {
            if (typeof events[i] === "object") {
                for (var j in events[i]) {
                    registerListener(i, events[i][j]);
                }
            } else {
                registerListener(i, events[i]);
            }
        }
    };

    LessonService.prototype.postAnswer = function (data) {
        var _this = this;
        var  questionId = data.question_id;
        this.model.postAnswer(data, function(data){
            _this.successPostAnswerCallback(questionId, data);
        },
        function(data){
            _this.errorPostAnswerCallback(questionId, data);

        });
    };

    LessonService.prototype.successPostAnswerCallback = function (questionId, data) {
        if(typeof data.badges !== "undefined" && Object.keys(data.badges).length > 0){
            this.displayBadgesView.render(data.badges);
        }
        this.view.renderSuccessPostAnswer(questionId, data);
    };

    LessonService.prototype.errorPostAnswerCallback = function (questionId, data) {
        this.view.renderErrorPostAnswer(questionId, data);

    };

    var service = new LessonService();
    return service;
})();

