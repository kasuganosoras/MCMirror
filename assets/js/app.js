require('bulma');
require('animate.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('../css/app.css');

const $ = require('jquery');
const ClipboardJS = require('clipboard.js');

function toggleModalClasses(event) {
    var modalId = event.currentTarget.dataset.modalId;
    var modal = $(modalId);
    modal.toggleClass('is-active');
    $('html').toggleClass('is-clipped');
}

$('.open-modal').click(toggleModalClasses);
$('.close-modal').click(toggleModalClasses);

$("input:checkbox").click(function () {
    var showAll = true;
    var tr = $('tr');

    tr.not('.first').hide();
    $('input[type=checkbox]').each(function () {
        if ($(this)[0].checked) {
            showAll = false;
            var status = $(this).attr('rel');
            var value = $(this).val();
            $('td.' + status + '[rel="' + value + '"]').parent('tr').show();
        }
    });
    if (showAll) {
        tr.show();
    }
});
$(document).ready(function () {
    $("#search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('.dropdown').click(function() {
        $(this).toggleClass("is-active");
    });

    var filter = [];
    $('.is-filter').click(function() {
        $(this).toggleClass("is-focused");

        if ($(this).hasClass('is-focused')) {
            filter.push($(this).attr('rel'));
        } else {
            var index = filter.indexOf($(this).attr('rel'));
            if (index > -1) {
                filter.splice(index, 1);
            }
        }

        if (filter.length > 0) {
            $('.application').hide();
            for (var i in filter) {
                $('.application.panel-block > span > span[rel="' + filter[i] + '"]').parent().parent().show();
            }
        } else {
            $('.application').show();
        }
    });
});

new ClipboardJS('button');