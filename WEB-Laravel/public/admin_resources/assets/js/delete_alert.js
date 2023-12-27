function ajaxDelete(url, csrfToken) {
    const swalInit = swal.mixin({
        buttonsStyling: false,
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
            denyButton: "btn btn-light",
        },
    });
    swalInit
        .fire({
            title: "Apakah Anda Yakin?",
            text: "Data yang dihapus tidak dapat dipulihkan kembali!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: url,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    success: function (data) {
                        swalInit.fire({
                            title: "Hapus Berhasil!",
                            text: "Data sudah dihapus!",
                            icon: "success",
                            showConfirmButton: false,
                        });
                        location.reload();
                    },
                    error: function (data) {
                        Swal.fire(
                            "Error!",
                            "Terjadi kesalahan saat menghapus data.",
                            "error"
                        );
                    },
                });
            }
        });
}

