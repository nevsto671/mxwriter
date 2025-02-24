// GitHub- sohelrn
$(window).scroll(function () {
    var sticky = $('#navbar');
    if ($(window).scrollTop() >= 20) sticky.addClass('navbar-sticky');
    else sticky.removeClass('navbar-sticky');
});

var cookiepolicy = document.getElementById('gdpr-cookie-policy');
if (cookiepolicy) {
    cookiepolicy.addEventListener('hidden.bs.toast', () => {
        document.cookie = "_gdpr=yes; max-age=31536000; path=/";
    });
}

$(document).ready(function () {
    $('#offcanvas a.nav-link').on('click', function () {
        var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvas'));
        if (offcanvas) {
            offcanvas.hide();
        }
    });
});