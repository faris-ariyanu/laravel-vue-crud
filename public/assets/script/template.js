/* menu sidebar */
$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#mobile-sidebar').toggleClass('mobile-active');
        $('.site-content').toggleClass('full');
        $('.navbar-fixed-top').toggleClass('left50');
        $(this).toggleClass('active');
    });
});