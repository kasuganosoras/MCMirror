
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

    $('.is-filter').click(function() {
        $(this).toggleClass("is-focused");

        if ($(this).hasClass('is-focused')) {
            $('.panel-block > span > span[rel="' + $(this).attr('rel') + '"]').parent().parent().show();
        } else {
            $('.panel-block > span > span[rel="' + $(this).attr('rel') + '"]').parent().parent().hide();
        }
    });
});
