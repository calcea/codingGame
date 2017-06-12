var UsersList = Backbone.View.extend({
    el: '.users',
    initialize: function () {
        this.initTooltips();
    },
    initTooltips: function () {
        var _this = this;
        this.$el.find('.user').each(function (index, el) {
            _this.initTooltipByUser($(el));
        });
    },
    initTooltipByUser: function (user) {
        user.tooltipster({
            content: this.getTooltipContent(user),
            position: "right",
            theme: "tooltipster-shadow"
        });
    },
    getTooltipContent: function (user) {
        var userBadges = user.find('.info').data('badges');
        var userXp = user.find('.info').data('xp');
        var wrapper = $("<div></div>").addClass('user-tooltip-wrapper');

        wrapper.append($("<p></p>").text("Experienta (XP):").css("font-weight", "bold"));
        $.each(userXp, function(index, value){
            wrapper.append($("<li></li>").text(index + " : " + value + " xp"));
        });

        if(Object.keys(userBadges).length <= 0){
            return wrapper;
        }
        wrapper.append($("<p></p>").text("Insigne obtinute:").css("font-weight", "bold"));
        $.each(userBadges, function (index, value) {
            var badge = $("<div></div>");
            var ul = $('<ul></ul>');
            badge.append(ul);
            var img = $('<img>').attr('src', "/" + value.badge_logo_url).addClass('img-circle');
            var name = $('<span></span>').text(value.badge_title);
            ul.append($("<li></li>").append(img).append(name));
            wrapper.append(badge);
        });

        return wrapper;
    }

});

var obj = new UsersList();