const btnReplyComment = document.querySelectorAll(".btn-reply-cmt");
const formReplyComment = document.getElementById("form-relpy-comment");

function toggleDisplay(element) {
    if (element.classList.contains("hidden")) {
        element.classList.add("animate-fadeIn");
        setTimeout(() => {
            element.classList.remove("hidden");
        }, 1000);
        return;
    }
    setTimeout(() => {
        element.classList.add("hidden");
    }, 1000);
    element.classList.remove("animate-fadeIn");
    element.classList.add("animate-fadeOut");
}

btnReplyComment.forEach((btn) => {
    btn.addEventListener("click", function (event) {
        event.preventDefault();

        const targetSelector = btn.getAttribute("data-target");
        const targetElement = document.querySelectorAll(
            `[data-target="${targetSelector}"]`
        )[1];

        toggleDisplay(targetElement);
    });
});
