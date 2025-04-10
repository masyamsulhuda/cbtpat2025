$('#alert-delete').click(function() {
        var getLink = $(this).attr('href');
    swal({
        title: "Apakah Anda Yakin?",
        text: "Data terpilih akan dihapus!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href = getLink
        }
    });
    return false;
});

$('input[name=checkbox]').change(function() {
    if ($(this).is(':checked')) {
      console.log("Checkbox is checked..")
    } else {
      console.log("Checkbox is not checked..")
    }
});