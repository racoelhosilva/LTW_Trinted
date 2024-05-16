"use strict";
const contactCards = document.querySelectorAll(".contact-side");
contactCards.forEach((contactCard) => {
    const userId = contactCard.dataset.userId;
    let avatar = contactCard.querySelector(".contact-avatar");
    if (!avatar || !contactCard) {
        return;
    }
    contactCard.addEventListener("click", () => document.location.assign(`/messages?id=${userId}`));
    avatar.addEventListener("click", (event) => {
        event.stopPropagation();
        document.location.assign(`/profile?id=${userId}`);
        return;
    });
});
