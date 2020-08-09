$(document).ready(function () {
    // script needed for the autocompletion search engine
    $('#auto').autocomplete({
        source: '../../../php/includes/autocomplete.php?extraParams=title',
        minLength: 2
    });

    $('#search_text_side').autocomplete({
        source: '../../../php/includes/autocomplete.php?extraParams=title',
        minLength: 2,
        position: {
            my: 'left top',
            at: 'right top',
            of: $('#skin_side'),
            collision: 'flipfit none'
        }
    });

    // Hide the auto-completion list when the window is resized,
    // as it won't follow the new position of the search box
    $(window).resize(function () {
        $('.ui-autocomplete').css('display', 'none');
    });

    // Skin switcher
    $('.clearfix li a').click(function () {
        var skin = $(this).data('skin');
        var cssPath = '../../../themes/styles/' + skin + '/css/style.css';
        var logoImgPath = '../../../themes/styles/' + skin + '/images/logos/top_logo01.png';
        var logoImg480Path = '../../../themes/styles/' + skin + '/images/logos/top_logo01_480.png';
        var logoBeePath = '../../../themes/styles/' + skin + '/images/top_right01.png';

        $('link#main_stylesheet').attr('href', cssPath);
        $('#logo_img').attr('src', logoImgPath);
        $('#logo_img_480').attr('src', logoImg480Path);
        $('#img_bee').attr('src', logoBeePath);
        $.post('../../../php/main/front/skin_switcher.php?action=skinswitch&skin=' + skin);
        return false;
    });

    // script needed for the side menu
    $('[data-toggle]').click(function () {
        var toggleEl = $(this).data('toggle');
        $(toggleEl).toggleClass('open-sidebar');
    });

    // script needed log in menu
    $('#login-trigger').click(function () {
        $(this).next('#login-content').slideToggle();
        $(this).toggleClass('active');

        if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
        else $(this).find('span').html('&#x25BC;')
    })

    // The 'go to the top' button
    $(document).on('scroll', function () {
        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
        } else {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    $('.scroll-top-wrapper').on('click', function () {
        var element = $('body');
        var offset = element.offset();
        var offsetTop = offset.top;
        $('html, body').animate({
            scrollTop: offsetTop
        }, 500, 'linear');
    });
});

window.OSDMessageDisplay = function (message) {
    $.notify_osd.create({
        'text': message, // notification message
        'icon': '../../../themes/styles/1/images/osd_icons/star.png', // icon path, 48x48
        'sticky': false, // if true, timeout is ignored
        'timeout': 4, // disappears after 6 seconds
        'dismissable': true // can be dismissed manually
    });
}
