$(document).ready(function () {
    // Get the current page URL
    var currentPageUrl = window.location.href;

    // Loop through each nav link
    $('.nav-link').each(function () {
        // Get the href attribute of the nav link
        var navLinkUrl = $(this).attr('href');

        // Check if the current page URL contains the nav link URL
        if (currentPageUrl.indexOf(navLinkUrl) !== -1) {
            // Add the 'active' class to the nav link
            $(this).addClass('active');
        }
    });
});