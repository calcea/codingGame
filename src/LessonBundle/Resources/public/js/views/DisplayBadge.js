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