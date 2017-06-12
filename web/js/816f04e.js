/**
 * Created by george on 5/28/2016.
 */

var LessonsList = Backbone.View.extend({
    el: '.lessons',
    initialize: function () {
        this.initTooltips();
    },
    initTooltips: function () {
        $('.lesson-blocked').each(function (index, el) {
            var element = $(el);
            var scoreToUnlock = element.data('score_to_unlock');
            var totalScore = element.data('total_score');
            element.tooltipster({
                content: "Pentru a debloca aceasta lectie trebuie sa adunati minim " + scoreToUnlock + " xp. In total ati strans " + totalScore + " xp.",
                //position: {my: 'center bottom', at: "center top-11"}

            });
        });
    }
});

var obj = new LessonsList();