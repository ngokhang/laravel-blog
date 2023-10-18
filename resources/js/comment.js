const btnReplyComment = document.querySelectorAll(".btn-reply-cmt");
const formReplyComment = document.getElementById("form-relpy-comment");

function toggleDisplay(element) {
    if (element.classList.contains("hidden")) {
        element.classList.remove("hidden");
        element.classList.add("flex");
        element.classList.add("animate-fadeIn");
        element.classList.remove("animate-fadeOut");
        return;
    }
    element.classList.remove("animate-fadeIn");
    element.classList.add("animate-fadeOut");
    setTimeout(() => {
        element.classList.remove("flex");
        element.classList.add("hidden");
    }, 1000);
    return;
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
