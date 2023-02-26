function isLoading(status = false) {
    if (status) {
        $("#icon-loading").fadeIn(300);
    } else {
        setTimeout(function () {
            $("#icon-loading").fadeOut(300);
        }, 500);
    }
}
