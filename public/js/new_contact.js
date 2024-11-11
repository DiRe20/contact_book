$(document).ready(function () {
    $('#contactModal').on('show.bs.modal', function () {
        $('#modal-title-new').html('New Contact')
        $.ajax({
            url: newContactUrl,
            method: "GET",
            success: function (html) {
                $('.modal-body').html(html);
            }
        });
    });
    $('#modal-body-new').on('submit', '#contactForm', function (event) {
        event.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: newContactUrl,
            method: "POST",
            data: formData,
            success: function (data) {
                console.log(data);
                if (data.success) {
                    $('#contactModal').modal('hide');
                    location.reload();
                }
                $('#modal-body-new').html(data);
            }
        });
    });
});