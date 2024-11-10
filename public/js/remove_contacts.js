var listChecked = [];
function checkedList() {
    $(':checkbox').each(function () {
        if (this.checked && this.className === 'line-js-contact') {
            listChecked.push(this.id);
        }
    });
}
$('.js-remove-list').on('click', function (e) {
    e.preventDefault();

    checkedList();
    var url = $(this).data('url');
    $.ajax({
        url: url,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ ids: listChecked }),
        success: function(response) {
            if (response.status === 'success') {
                alert('Contacts deleted');
                location.reload();
            }
        },
        error: function(response) {
            alert('Error:' +response.statusText);
        }
    });
});