    $('#saveCat').on('click', function() {
        const form = $('#catForm'); // define the form
        const url = form.data('action');
        $('.text-danger, .invalid-feedback').remove(); // clear old errors
        form.find('.is-invalid').removeClass('is-invalid');
        $.post(url, form.serialize())
            .done(() => location.reload())
            .fail(res => {
                if (res.responseJSON && res.responseJSON.errors) {
                    let errors = res.responseJSON.errors;
                    for (let field in errors) {
                        let input = form.find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + errors[field][0] + '</div>');
                    }
                } else {
                    alert('An unexpected error occurred.');
                }
            });
    });

    /* ----------- ITEM CRUD ------------ */
    $('#saveItem').on('click', function() {
        const form = $('#itemForm'); // define the form
        const url = form.data('action');
        $('.text-danger, .invalid-feedback').remove(); // clear old errors
        form.find('.is-invalid').removeClass('is-invalid');

        $.post(url, form.serialize())
            .done(() => location.reload())
            .fail(res => {
                if (res.responseJSON && res.responseJSON.errors) {
                    let errors = res.responseJSON.errors;
                    for (let field in errors) {
                        let input = form.find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + errors[field][0] + '</div>');
                    }
                } else {
                    alert('An unexpected error occurred.');
                }
            });
    });

    $('#saveTx').on('click', function() {
        // $('.text-danger').remove(); // Clear old errors
        const form = $('#txForm'); // define the form
        const url = form.data('action');
        $('.text-danger, .invalid-feedback').remove(); // clear old errors
        form.find('.is-invalid').removeClass('is-invalid');
        $.post(url, form.serialize())
            .done(tx => {
                $('#txModal').modal('hide');
                let row = `<tr id="tx-${tx.id}">
              <td>${tx.id}</td><td>${tx.tx_date}</td><td>${tx.type.name}</td>
              <td>${tx.category.name}</td><td>${tx.item.name}</td>
              <td>${tx.quantity}</td><td>${tx.amount}</td>
              <td>${tx.client ? tx.client.name : ''}</td>
              <td><button class="btn btn-sm btn-danger del-tx" data-id="${tx.id}">✕</button></td>
          </tr>`;
                $('#txTable tbody').prepend(row);
                $('#txForm')[0].reset();
            })
            .done(() => location.reload())
            .fail(res => {
                if (res.responseJSON && res.responseJSON.errors) {
                    let errors = res.responseJSON.errors;
                    for (let field in errors) {
                        let input = form.find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + errors[field][0] + '</div>');
                    }
                } else {
                    alert('An unexpected error occurred.');
                }
            });
    });

    $(document).on('click', '.del-tx', function(e) {
        e.preventDefault();

        const url = $(this).data('url');
        const row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: () => {
                        row.remove();
                        Swal.fire(
                            'Deleted!',
                            'Transaction has been deleted.',
                            'success'
                        );
                    },
                    error: (res) => {
                        console.error(res);
                        Swal.fire(
                            'Error!',
                            'Failed to delete transaction.',
                            'error'
                        );
                    }
                });
            }
        });
    });


    $(document).on('click', '.updateTxBtn', function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const form = $('#editTxForm-' + id);
        const url = form.data('url');

        Swal.fire({
            title: 'Update Transaction?',
            text: 'Do you want to save changes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(), // includes _method=PUT
                    success: function(updatedTx) {
                        $('#editTxModal-' + id).modal('hide');
                        Swal.fire('Updated!', 'Transaction updated successfully.', 'success')
                            .then(() => location.reload()); // or update table row dynamically
                    },
                    error: function(res) {
                        if (res.responseJSON && res.responseJSON.errors) {
                            let errors = res.responseJSON.errors;
                            for (let field in errors) {
                                let input = form.find('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + errors[field][0] + '</div>');
                            }
                        } else {
                            Swal.fire('Error!', 'Failed to update.', 'error');
                        }
                    }
                });
            }
        });
    });
