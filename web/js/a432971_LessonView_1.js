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
