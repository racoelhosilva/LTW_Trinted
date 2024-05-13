var contactCards = document.querySelectorAll(".contact-side");
contactCards.forEach(function (contactCard) {
    var userId = contactCard.dataset.userId;
    var avatar = contactCard.querySelector(".contact-avatar");
    if (!avatar || !contactCard) {
        return;
    }
    contactCard.addEventListener("click", function () { return document.location.assign("/messages?id=".concat(userId)); });
    avatar.addEventListener("click", function (event) {
        event.stopPropagation();
        document.location.assign("/profile?id=".concat(userId));
        return;
    });
});
