$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse');
            $('#button-toggle').hide();
        } else {
            $('div.sidebar-collapse').removeClass('collapse');
            $('#button-toggle').show();
        }
    })
})
