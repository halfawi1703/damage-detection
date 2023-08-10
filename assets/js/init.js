$(function () {
    $('#loading').show().fadeOut(500);
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    $.ajaxSetup({
        error: function (xhr) {
            notification('error', xhr.statusText, 3000, true);
            console.log(xhr);
            if (xhr.status == 401) {
                window.location.replace(BASE_URL + 'login');
            }
        }
    });
});

$(window).on('beforeunload', function() {
    $('#loading').show();
});

$(window).on('pageshow', function() {
    $('#loading').show().fadeOut(500);
});

function notification(type, message, duration = 2000, closeButton = true, progressBar = false) {
    toastr.options.positionClass = 'toast-bottom-center';
    toastr.options.closeHtml = '<button type="button"></button>';

    if (type == 'success') {
        toastr.success(message, "", {
            "closeButton": closeButton,
            "progressBar": progressBar,
            "timeOut": duration
        });
    } else if (type == 'warning') {
        toastr.warning(message, "", {
            "closeButton": closeButton,
            "progressBar": progressBar,
            "timeOut": duration
        });
    } else if (type == 'error') {
        toastr.error(message, "", {
            "closeButton": closeButton,
            "progressBar": progressBar,
            "timeOut": duration
        });
    } else {
        toastr.info(message, "", {
            "closeButton": closeButton,
            "progressBar": progressBar,
            "timeOut": duration
        });
    }
}

const OBSERVER = lozadz();
OBSERVER.observe();

let btnText = [];

function btnLoader(el) {
    if (el.hasClass('loading')) {
        let times = el.find('.loader').attr('data-loader');
        el.html(btnText[times]);
        el.removeClass('loading');
        el.removeAttr('disabled');
        el.removeAttr('style');
        delete btnText[times];
    } else {
        let times = Date.now();
        let width = el.outerWidth();
        el.find('.waves-ripple').fadeOut().delay(500).remove();
        btnText[times] = el.html();
        el.attr('style', 'width:' + width + 'px;');
        el.html('');
        el.addClass('loading');
        el.attr('disabled', '');
        el.append('<div class="loader" data-loader="'+ times + '"></div>');
    }
}

function copyStringToClipboard(str) {
   // Create new element
   var el = document.createElement('textarea');
   // Set value (string to be copied)
   el.value = str;
   // Set non-editable to avoid focus and move outside of view
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Select text inside element
   el.select();
   // Copy text to clipboard
   document.execCommand('copy');
   // Remove temporary element
   document.body.removeChild(el);
}

$(document).click(function(e) {
    $('.nav-menu').removeClass('open');
    $('.overlay').remove();
    $('.action-dropdown').removeClass('open');
});

$('.nav-close').click(function(e) {
    $('.nav-menu').removeClass('open');
    $('.overlay').remove();
});

$('body').on('click', '.action-dropdown .btn-action', function () {
    $('.action-dropdown').removeClass('open');
    $(this).parents('.action-dropdown').addClass('open');
    $('.overlay').remove();
    $('body').append('<div class="overlay"></div>');
    $('.overlay').show();
    $('.overlay').css('opacity', 1);
});

$('body').on('click', '.nav-menu', function (e) {
    e.stopPropagation();
});

$('body').on('click', '.action-dropdown', function (e) {
    e.stopPropagation();
});

$('body').on('click', '.action-dropdown-item', function (e) {
    e.stopPropagation();
    $('.action-dropdown').removeClass('open');
    $('.overlay').remove();
});

$('.nav-top .nav-toggle').click(function (e) {
    $('.nav-menu').addClass('open');
    $('.overlay').remove();
    $('body').append('<div class="overlay"></div>');
    $('.overlay').show();
    $('.overlay').css('opacity', 1);
    e.stopPropagation();
});

$('.app').on('click', '[maintenance="true"]', function (e) {
    e.stopPropagation();
    e.preventDefault();
    notification('info', 'This feature is under construction');
})

Offline.options = {
  // Should we check the connection status immediatly on page load.
  checkOnLoad: true,

  // Should we monitor AJAX requests to help decide if we have a connection.
  interceptRequests: false,

  // Should we automatically retest periodically when the connection is down (set to false to disable).
  reconnect: false,

  // Should we store and attempt to remake requests which fail while the connection is down.
  requests: true,

  // Should we show a snake game while the connection is down to keep the user entertained?
  // It's not included in the normal build, you should bring in js/snake.js in addition to
  // offline.min.js.
  game: false
}

let dotLoader = '<div class="loader">';
dotLoader += '<div class="dot-loader"></div>';
dotLoader += '</div>';