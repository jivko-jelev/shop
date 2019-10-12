function showErrors(data) {
    $('.error').html('');
    for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
        if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
            let key = Object.keys(data.responseJSON.errors)[i];
            $('#' + key + '-error').html(data.responseJSON.errors[key]);
        }
    }
    Lobibox.notify('error', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: 'Възникна някаква грешка при опита за промяна на данните'
    });
}

function showError(data) {
    for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
        if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
            let key = Object.keys(data.responseJSON.errors)[i];
            Lobibox.notify('error', {
                showClass: 'rollIn',
                hideClass: 'rollOut',
                msg: `${data.responseJSON.errors[key]}`
            });
        }
    }
}

function showSuccessMessage(message) {
    Lobibox.notify('success', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: `${message}`,
    });
}