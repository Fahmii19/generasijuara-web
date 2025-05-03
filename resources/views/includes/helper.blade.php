<script type="text/javascript">
    Inputmask.extendAliases({
        rupiah: {
            alias: "numeric",
            prefix: "Rp ",
            groupSeparator: ".",
            radixPoint: ",",
            placeholder: "0",
            autoGroup: true,
            digits: 0,
            digitsOptional: false,
            allowPlus: false,
            allowMinus: false,
            rightAlign: false,
            clearMaskOnLostFocus: false,
            autoUnmask: true,
            removeMaskOnSubmit: true,
        },
        ribuan: {
            alias: "numeric",
            prefix: "",
            groupSeparator: ".",
            radixPoint: ",",
            placeholder: "0",
            autoGroup: true,
            digits: 0,
            digitsOptional: false,
            allowPlus: false,
            allowMinus: false,
            rightAlign: false,
            clearMaskOnLostFocus: false,
            autoUnmask: true,
            removeMaskOnSubmit: true,
        },
    });
    Inputmask("rupiah").mask('.rupiah-format');
    Inputmask("ribuan").mask('.ribuan-format');

    function formatRibuan(nStr) {
        var thousand = '.';
        var comma = ',';
        nStr += '';
        x = nStr.split(comma);
        x1 = x[0];
        x2 = x.length > 1 ? comma + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + thousand + '$2');
        }
        return x1 + x2;
    }

    function confirmDelete(url, desc) {
        if (confirm('Anda yakin akan menghapus data ini? (' + desc + ') ? ')) window.location.href = url;
        else {
            return false;
        }
    }

    function confirmRedirect(url, desc) {
        if (confirm(desc)) window.location.href = url;
        else {
            return false;
        }
    }

    function confirmDefault(desc = "Apakah anda yakin?") {
        if (confirm(desc)) return true;
        else return false;
    }
    
    function ajaxCallbackError(response) {
        let resJson = response.responseJSON;
        let message = "";

        switch (response.status) {
            case (422):
                if(Object.keys(resJson.errors).length > 0){
                    $.each(resJson.errors, function (i, row) {
                        message += "<li>"+row+"</li>";
                    });
                }
                break
            default:
                message = resJson.message;
                break
        }
        $("#toastDanger").find('.toast-body').html(message);
        $("#toastDanger").toast("show");
    }

    function showError(message) {
        $("#toastDanger").find('.toast-body').text(message);
        $("#toastDanger").toast("show");
    }

    function showSuccess(message) {
        $("#toastSuccess").find('.toast-body').text(message);
        $("#toastSuccess").toast("show");
    }

    async function enableLoadingButton(element){
        $(element).prop("disabled", true);
        $(element).append(' <span class="spinner-border spinner-border-sm my-1" role="status" aria-hidden="true"></span>');
    }

    async function disableLoadingButton(element){
        $(element).prop("disabled", false);
        $(element + ' .spinner-border').remove();
    }

    // for back function
    function goBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = document.referrer;
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }

    // Check form
    checkForm = function(form){
        var isValid = true;
        $(form).find(".required").each(function(){
            var inputValidate = checkInput(this)
            isValid = isValid && inputValidate;

            $(this).removeClass("is-valid").removeClass("is-invalid");
            if (inputValidate) {
                $(this).addClass("is-valid");
            } else {
                $(this).addClass("is-invalid");
            }
        });

        var errorElements = $('.required.is-invalid')
        if (errorElements.length > 0) {
            var modal = errorElements.parents('.modal')
            if (modal.length > 0) {
                var modalBody = modal.find('.modal-body')
                modal.animate({
                    scrollTop: $(errorElements[0]).offset().top - modalBody.offset().top
                }, 500);
            } else {
                var headerHeight = 0
                var topHeight = 0
                $('html, body').animate({
                    scrollTop: $(errorElements[0]).offset().top - headerHeight - topHeight - 30
                }, 500);
            }
        }

        // console.log('testt global check form')
        // return false

        return isValid;
    }

    // Check input form
    checkInput = function(input){
        var isValid = true;
        if($(input).val() != "" && $(input).prop("validity").valid && $(input).val() !== null){
            isValid = true;
        } else{
            isValid = false;
        }
        return isValid;
    }

    // First Letter Uppercase
    function toUpperCase(str) {
        var splitStr = str.toLowerCase().split(' ');
        for (var i = 0; i < splitStr.length; i++) {
            splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
        }
        return splitStr.join(' '); 
    }

    function ajaxOperation(context) {
        var ajaxParams = {
            type: context.type,
            url: context.url,
            headers: context.headers ?? {},
            data: context.data,
            success: function(res) {
                if (!res.error) {
                    if (context.withCallback) {
                        context.callback();
                    }
                    if (context.withSuccessMessage) {
                        swalSuccess({
                            text: context.successMessage,
                            withConfirmButton: true
                        });
                    }
                    if (context.withSweetAlertTimer) {
                        sweetAlertTimer({
                            title: context.swalTitle,
                            text: context.swalText,
                            type: context.swalType,
                            timer: context.swalTimer,
                        });
                    }
                    if (context.withReloadTable) {
                        context.table.ajax.reload();
                    }
                    if (context.withReloadPage) {
                        location.reload();
                    }
                    if (context.reloadWithTimeout) {
                        setTimeout(function(){
                            location.reload();
                        }, context.reloadTimeout);
                    }
                    if (context.withHideModal) {
                        $(context.modal).modal('hide');
                    }
                    if (context.withResetForm) {
                        $(context.form)[0].reset();
                    }
                }
            },
            error: function(err) {
                ajaxCallbackError(err);
                if (context.withErrorCallback) {
                    context.errorCallback();
                }
                if (context.withDisabledElement) {
                    context.elementToDisabled.prop("disabled", true);
                }
                if (context.withEnabledElement) {
                    context.elementToEnabled.prop("disabled", false);
                }
            }
        }

        if (context.cache != null) {
            ajaxParams.cache = context.cache;
        }
        if (context.contentType != null) {
            ajaxParams.contentType = context.contentType;
        }
        if (context.processData != null) {
            ajaxParams.processData = context.processData;
        }

        $.ajax(ajaxParams);
    }

    function swalSuccess(context) {
        Swal.fire({
            title: 'Sukses',
            text: context.text,
            icon: 'success',
            showConfirmButton: context.withConfirmButton ?? false,
            timer: context.timer ?? null
        }).then(function() {
            if (context.withReloadTable) {
                context.table.ajax.reload();
            }
            if (context.withReloadPage) {
                location.reload();
            }
            if (context.withRedirect) {
                window.location.href = context.redirectUrl;
            }
            if (context.withGoBack) {
                goBackWithRefresh();
            }
            if (context.reloadWithTimeout) {
                setTimeout(function(){
                    location.reload();
                }, context.reloadTimeout);
            }
        });
    };

    function swalError(context) {
        Swal.fire({
            title: 'Gagal',
            text: context.text,
            icon: 'error',
            showConfirmButton: context.withConfirmButton ?? false,
            timer: context.timer ?? null
        });
    };

    /**
     * SweetAlert2 with action
     * @param {object} context - Context of the function
     */
    function sweetAlertAction(context) {
        Swal.fire({
            title: context.title,
            text: context.text,
            icon: context.type,
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                if (context.withCallback) {
                    context.callback();
                }
                if (context.withTableReload) {
                    context.table.ajax.reload();
                }
                if (context.withReloadPage) {
                    window.location.reload();
                }
                if (context.withRedirect) {
                    window.location.href = context.redirectUrl;
                }
                if (context.withDisabledElement) {
                    context.elementToDisabled.prop("disabled", true);
                }
                if (context.withEnabledElement) {
                    context.elementToEnabled.prop("disabled", false);
                }
            } else {
                if (context.withCancelCallback) {
                    context.cancelCallback();
                }
            }
        })
    }

    /**
     * SweetAlert2 without button
     * @param {object} context - Context of the function
     */
    function sweetAlertTimer(context) {
        Swal.fire({
            title: context.title,
            text: context.text,
            icon: context.type,
            showConfirmButton: false,
            timer: context.timer
        })
    }
</script>