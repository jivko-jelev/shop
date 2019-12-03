String.prototype.replaceAt = function (index, replacement) {
    return this.substr(0, index) + replacement + this.substr(index + replacement.length);
};

String.prototype.splice = function (start, delCount, newSubStr) {
    return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
};

function showErrors(data) {
    $('.error').remove();
    for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
        if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
            let key = Object.keys(data.responseJSON.errors)[i];
            if (key.indexOf('.') != -1) {
                for (let j = key.length - 1; j >= 0; j--) {
                    if (j == key.length - 1) {
                        key += ']';
                    } else if (key[j] == '.') {
                        if (key.indexOf('.') < j) {
                            key = key.splice(j, 1, '][');
                        } else {
                            key = key.replaceAt(j, '[');
                        }
                    }
                }
            }

            console.log(data.responseJSON.errors[Object.keys(data.responseJSON.errors)[i]]);
            $(`[name="${key}"]`).parent().parent().append(`<span class="error">${data.responseJSON.errors[Object.keys(data.responseJSON.errors)[i]]}</span>`);
            console.log($(`[name="${key}"]`).next().attr('class'));
            //append('<span class="error" id="email-error"></span>'))
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

function showErrorMessage(message) {
    Lobibox.notify('error', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: `${message}`
    });
}

function showSuccessMessage(message) {
    Lobibox.notify('success', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: `${message}`,
    });
}