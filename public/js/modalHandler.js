function handleNonaktif(id, status, type) {
    var modalMessage = document.getElementById('modalMessage-' + type + '-' + id);
    var nonaktifForm = document.getElementById('nonaktifForm-' + type + '-' + id);

    if (modalMessage && nonaktifForm) {
        if (status === 0) {
            modalMessage.innerHTML = "Status " + (type === 'package' ? "paket" : "menu") + " ini sudah nonaktif.";
            nonaktifForm.querySelector("button[type='submit']").disabled = true;
        } else {
            modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status " + (type === 'package' ? "paket" : "menu") + " ini?";
            nonaktifForm.querySelector("button[type='submit']").disabled = false;
        }

        let modalId = '#nonaktifModal-' + type + '-' + id;
        $(modalId).modal('show');

        // Once the modal is closed, check if there's a success message and show "BerhasilModal"
        $(modalId).on('hidden.bs.modal', function () {
            let successMessage = $('body').attr('data-success'); // Get stored success message
            if (successMessage) {
                $('#BerhasilModal .modal-body').html(successMessage);
                $('#BerhasilModal').modal('show');
                $('body').removeAttr('data-success'); // Remove message to prevent repeated display
            }
        });
    } else {
        console.error("Modal elements not found for ID:", id, "Type:", type);
    }
}
