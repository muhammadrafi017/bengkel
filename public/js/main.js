let base_url = $('meta[name="base_url"]').attr('content');
let table, modal, opened_modal;

$(document).ready(function() {
    $('.select2plain').select2({
        width: '100%'
    });
});

$(document).on('show.bs.modal', '.modal', function() {
    modal = 1;
    opened_modal = '#' + $(this).attr('id');
});

$(document).on('hidden.bs.modal', '.modal', function() {
    modal = 0;
    opened_modal = null;
});

$(document).on('click', '.submit', function(e) {
    e.preventDefault();
    //clean rupiah format
    if ($('.balance').length > 0) {
        $('.balance').each(function(i, v) {
            $(this).val(parseFloat($(this).val().split('.').join('')));
        });
    }
    let form = new FormData($(this).closest('#form')[0]);
    let action = $(this).closest('#form').attr('action');
    $.ajax({
        url : action,
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        beforeSend: function() {
            Swal.showLoading();
            $('button').attr('disabled', true);
        },
        success: function(x) {
            ajaxSuccess(x);
        },
        error: function(x) {
            ajaxError(x);
        },
        complete: function() {
            $('button').attr('disabled', false);
        }
    });
});

$(document).on('click', '.refresh-button', function() {
    table.ajax.reload();
});

$(document).on('click', '.delete-button', function() {
    let content = $(this).data('content');
    let id = $(this).val();
    Swal.fire({
        title: ' yakin untuk menghapus ?',
        text: 'Data yang sudah di hapus tidak dapat dikembalikan lagi',
        icon : 'warning',
        showCancelButton : true,
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: content +'/delete/'+ id,
                type: 'delete',
                beforeSend: function() {
                    Swal.showLoading();
                    $('button').attr('disabled', true);
                },
                success: function(x) {
                    ajaxSuccess(x);
                },
                error: function(x) {
                    ajaxError(x);
                },
                complete: function() {
                    $('button').attr('disabled', false);
                }
            });
        }
    });
});

$(document).on('click', '.status-button', function() {
    let status;
    let content = $(this).data('content');
    let id = $(this).val();
    let element_id = $(this).attr('id');
    if (element_id == 'disable') {
        status = 0;
    } else {
        status = 1;
    }
    $.ajax({
        url: content +'/status/'+ id,
        type: 'post',
        data: {
            status : status
        },
        beforeSend: function() {
            Swal.showLoading();
            $('button').attr('disabled', true);
        },
        success: function(x) {
            ajaxSuccess(x);
        },
        error: function(x) {
            ajaxError(x);
        },
        complete: function() {
            $('button').attr('disabled', false);
        }
    });
});

$(document).on('click', '.remove-button', function(e) {
    e.preventDefault();
    $(this).closest('.removeable').remove();
});

function select2Generator(id , url , placeholder , parameters, returns) {
    let default_param = function (params) {
        return {
            q: $.trim(params.term)
        };
    }
    let default_return = function (data) {
            return {
                results: $.map(data.data, function(item) {
                    return {
                        text: item.nama,
                        id: item.id
                    }
                })
            }
    }

    if (parameters == null) {
        parameters = default_param;
    }

    if (returns == null) {
        returns = default_return;
    }
    
    $(id).select2({
        width: '100%',
        placeholder: placeholder,
        ajax: {
            url: url,
            type: 'post',
            dataType: 'json',
            data: parameters,
            processResults: returns,
        },
        cache: true
    });
}

function dateGenerator(id, params) {
    $(id).datetimepicker(params);
} 


function ajaxSuccess(x) {
    Swal.fire({
        title: 'Sukses!',
        text: 'Pekerjaan anda berhasil di simpan',
        icon: 'success',
        timer: 1500
    }).then(function() {
        if (modal) {
            $(opened_modal).modal('toggle');
        }
        if (table) {
            table.ajax.reload();
        } else {
            window.location.replace(base_url);
        }
        $('#form').find('input').val('');
        $('.select-input').val(null).trigger('change');
    });

}

function ajaxError(x, e) {
    if (x) {
        if (x.responseJSON.message) {
            let errors = '';
            $.each(x.responseJSON.errors, function(i, v) {
                errors += v + '<br>';
            });
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: x.responseJSON.message,
                footer: errors
            });
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops..',
            text: 'Telah terjadi error, silahkan coba lagi'
        });
    }
}

function inputOnlyNumber(e) {
    e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
}

function inputRupiah(e) {
    inputOnlyNumber(e);
    e.target.value = formatRupiah(e.target.value);
}
const formatRupiah = (angka, prefix) => {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split           = number_string.split(','),
    sisa            = split[0].length % 3,
    rupiah          = split[0].substr(0, sisa),
    ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}