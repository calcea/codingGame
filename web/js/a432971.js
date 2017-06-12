/**
 * Created by george on 4/20/2016.
 */

var LessonView = Backbone.View.extend({
    el: 'body',
    events: {
        'click .init-test': 'initModal',
        'change .answer-input': 'sendAnswer'
    },
    initModal: function (e) {
        $('.lesson-overlay').show();
        $('.form-dialog').dialog({
            resizable: false,
            height: 700,
            width: 700,
            modal: true,
            close: function(){
                $('.lesson-overlay').hide();
            }
        });
    },
    sendAnswer: function (e) {
        var el = $(e.target);
        if (el.hasClass('radio-answer')) {
            el = el.find('input');
        }
        var option = el.val();
        var questionId = el.parents('.form-group').data('question-id');

        el.parents('.form-group').find('.loader-wrapper').show();
        $(document).trigger('post-answer', {'option': option, 'question_id': questionId});
    },
    renderSuccessPostAnswer: function (questionId, ajaxResponse) {
        var questionContainer = $('#question-' + questionId);
        if (ajaxResponse.check) {
            questionContainer.find('.answer-loader-image').attr('src', '/images/right.png');
        } else {
            questionContainer.find('.answer-loader-image').attr('src', '/images/wrong.png');
        }
    },
    renderErrorPostAnswer: function (questionId, ajaxResponse) {
        var questionContainer = $('#question-' + questionId);
        questionContainer.find('.loader-wrapper').hide();
    },
});

/**
 * Created by george on 5/28/2016.
 */
var DisplayBadge = Backbone.View.extend({
    el: '.badge-modal',
    group: '.badge-group',
    render: function (badges) {
        var modal = this.$el.clone();
        var badgeGroup = modal.find('.badge-group');
        modal.find('.badge-group').remove();
        modal.append(this.getMessageElement());
        for (var badge in badges) {
            this.addBadgeToModal(modal, badgeGroup, badges[badge]);
        }
        $('.container').append(modal);
        modal.show();
        modal.dialog({
            resizable: false,
            height: 400,
            width: 700,
            modal: true,
            draggable: false
        });
    },
    addBadgeToModal: function (element, badgeGroupEl, badge) {
        var badgeGroup = badgeGroupEl.clone();

        badgeGroup.find('.badge-logo img').attr('src', "/" + badge.logo_url);
        badgeGroup.find('.badge-name').text(badge.name);
        badgeGroup.find('.badge-message').text(badge.message);
        element.append(badgeGroup);
    },
    getMessageElement: function () {
        var msg = $("<div></div>")
            .addClass('congratulation-message')
            .text("Felicitari! Ai castigat urmatoarele insigne:");

        return msg
    }
});
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

