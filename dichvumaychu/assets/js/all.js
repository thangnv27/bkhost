var view_whois = false;
var view_cart = false;
var update_cart = false;
var can_increase_item = false;
var can_decrease_item = false;
var can_increase_item_web = false;
var can_decrease_item_web = false;
var can_remove = false;
var can_update_all = false;
var can_add_list = false;
var trigger_update_cart = {};
var show_pop_up_footer = true;

$(document).ready(function () {
    $('.list-faqs li a').click(function (e) {
        e.preventDefault();
        $('.list-faqs li').find('.block-answer').stop(true, true).slideUp();
        $('.list-faqs li > a.qs').removeClass('show-as');
        $(this).addClass('show-as');
        $(this).parent().find('.block-answer').stop(true, true).slideDown();
        return false;
    });

    $('.item').hover(function () {
        var hover = $(this).find('.thumb-sv img').attr('data-hover');
        if (typeof hover !== 'undefined') {
            var src_img = $(this).find('.thumb-sv img').attr('src');
            $(this).find('.thumb-sv img').attr('src', hover);
            $(this).find('.thumb-sv img').attr('data-hover', src_img);
        }
    }, function () {
        var hover = $(this).find('.thumb-sv img').attr('data-hover');
        if (typeof hover !== 'undefined') {
            var src_img = $(this).find('.thumb-sv img').attr('src');
            $(this).find('.thumb-sv img').attr('src', hover);
            $(this).find('.thumb-sv img').attr('data-hover', src_img);
        }
    });

    $('.menu li').hover(function () {
        $(this).find('ul.sub-menu').stop(true, true).slideDown();
    }, function () {
        $(this).find('ul.sub-menu').stop(true, true).slideUp();
    });

    $('#fr-order-last-step').submit(function () {
        $(this).find('.sp-result-err').removeClass('show');
        var is_valid = true;

        var name_field = document.getElementById('name_field').value;
        name_field = $.trim(name_field);

        if (name_field.length == 0) {
            is_valid = false;
            $('#sp-name_field').text('Họ tên không được để trống!');
            $('#sp-name_field').addClass('show');
        }

        var cmnd_field = document.getElementById('cmnd_field').value;
        cmnd_field = $.trim(cmnd_field);

        if (cmnd_field.length == 0) {
            is_valid = false;
            $('#sp-cmnd_field').text('Mã số thuế hoặc CMND không được để trống!');
            $('#sp-cmnd_field').addClass('show');
        }

        var email_field = document.getElementById('email_field').value;
        email_field = $.trim(email_field);

        if (email_field.length == 0) {
            is_valid = false;
            $('#sp-email_field').text('Email không được để trống!');
            $('#sp-email_field').addClass('show');
        } else if (!validateEmail(email_field)) {
            is_valid = false;
            $('#sp-email_field').text('Email không hợp lệ!');
            $('#sp-email_field').addClass('show');
        }

        var phone_field = document.getElementById('phone_field').value;
        phone_field = $.trim(phone_field);

        if (phone_field.length == 0) {
            is_valid = false;
            $('#sp-phone_field').text('Số điện thoại không được để trống!');
            $('#sp-phone_field').addClass('show');
        }

        var address_field = document.getElementById('address_field').value;
        address_field = $.trim(address_field);

        if (address_field.length == 0) {
            is_valid = false;
            $('#sp-address_field').text('Số điện thoại không được để trống!');
            $('#sp-address_field').addClass('show');
        }

        if (is_valid) {
            return true;
        }
        return false;
    });

    $("#list-sp-sl").owlCarousel({
        autoPlay: 3000,
        items: 4,
    });
    $('#WelcomeBox .PricingTable').owlCarousel();

    $('.get_field_price').change(function () {
        document.getElementById('prod_price_' + $(this).attr('id')).value = $(this).find(':selected').attr('data-field-id');
    });
    $('.field_price_update').change(function () {
        var id = $(this).attr('data-id');
        if (!isNaN(id)) {
            trigger_update_cart['fr_update_item_' + id] = 1;
            var phi_khoi_tao = $(this).attr('data-pr-kt');
            var so_luong = document.getElementById('result_so_luong_' + id).innerHTML;
            var time = $(this).find(':selected').val();
            var list_price = $.parseJSON($(this).attr('data-price'));

            if (!isNaN(phi_khoi_tao) && !isNaN(so_luong) && !isNaN(time) && (typeof list_price == 'object')) {
                if (typeof list_price[time] !== 'undefined') {
                    so_luong = parseInt(so_luong);
                    phi_khoi_tao = parseInt(phi_khoi_tao);
                    time = parseInt(time);
                    var phi_duy_tri = parseInt(list_price[time]);
                    var js_time = document.getElementById('ip_time_rs_' + id).value;
                    js_time = $.parseJSON(js_time);
                    js_time['id'] = $(this).find(':selected').attr('data-field-id');
                    js_time['time'] = $(this).find(':selected').val();

                    if($("tr[data-row="+id+"]").attr('data-type') === "ten-mien"){
                        document.getElementById('ip_time_rs_' + id).value = JSON.stringify(js_time);
                        document.getElementById('tong_tien_' + id).innerHTML = formatNumber(phi_duy_tri + phi_khoi_tao);
                        $("form[id=fr_update_item_"+id+"]").submit();
                    } else {
                        document.getElementById('ip_time_rs_' + id).value = JSON.stringify(js_time);
                        document.getElementById('result_phi_dt_' + id).innerHTML = formatNumber(phi_duy_tri);
                        document.getElementById('tong_tien_' + id).innerHTML = formatNumber(so_luong * phi_duy_tri * time + phi_khoi_tao);
                    }
                }
            }
        }
    });

    $('a#view-whois').click(function (e) {
        if (!view_whois) {
            view_whois = true;
            e.preventDefault();
            var data = $(this).attr('data-domain');
            if (data !== null) {
                $('body').append('<div id="modal-bg"></div><div id="modal-loader"><span class="loader"></span></div>');
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: base_uri + '/api?rand=' + new Date().getTime(),
                    async: true,
                    cache: false,
                    dataType: "json",
                    data: 'controller=view_whois&data_domain=' + data,
                    success: function (jsonData) {
                        if (jsonData.status) {
                            $('#modal-loader').remove();
                            $('body').append('<a id="remove-modal" href="#" onclick="remove_modal();return false;">Close</a><div id="modal-container">' + jsonData.whois + '</div>');
                        }
                        view_whois = false;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            }
        }
        return false;
    });

    $('.amount_btn .increase_item').click(function (e) {
        e.preventDefault();
        if (!can_increase_item) {
            can_increase_item = true;
            var id = $(this).attr('data-id');
            var phi_duy_tri = document.getElementById('result_phi_dt_' + id).innerHTML;
            phi_duy_tri = text_to_money(phi_duy_tri);
            var time = $('#time_item_' + id).find(':selected').val();
            var phi_khoi_tao = $(this).attr('data-pr-kt');
            var so_luong = document.getElementById('result_so_luong_' + id).innerHTML;
            so_luong = parseInt(so_luong) <= 0 ? 1 : parseInt(so_luong);

            if (!isNaN(id) && !isNaN(phi_duy_tri) && !isNaN(time) && !isNaN(phi_khoi_tao) && !isNaN(so_luong)) {
                trigger_update_cart['fr_update_item_' + id] = 1;
                so_luong = parseInt(so_luong);
                phi_khoi_tao = parseInt(phi_khoi_tao);
                phi_duy_tri = parseInt(phi_duy_tri);
                time = parseInt(time);
                so_luong++;

                document.getElementById('ip_amount_' + id).value = so_luong;
                document.getElementById('result_so_luong_' + id).innerHTML = so_luong;
                document.getElementById('tong_tien_' + id).innerHTML = formatNumber(so_luong * phi_duy_tri * time + phi_khoi_tao);
            }

            can_increase_item = false;
        }
        return false;
    });

    $('.amount_btn .increase_item_web').click(function (e) {
        e.preventDefault();
        if (!can_increase_item_web) {
            can_increase_item_web = true;
            var id = $(this).attr('data-id');
            var so_luong = document.getElementById('result_so_luong_' + id).innerHTML;
            so_luong = parseInt(so_luong) <= 0 ? 1 : parseInt(so_luong);
            var tong_tien = $(this).attr('data-price');

            if (!isNaN(id) && !isNaN(so_luong) && !isNaN(tong_tien)) {
                trigger_update_cart['fr_update_item_' + id] = 1;
                so_luong = parseInt(so_luong);
                tong_tien = parseInt(tong_tien);
                so_luong++;

                document.getElementById('ip_amount_' + id).value = so_luong;
                document.getElementById('result_so_luong_' + id).innerHTML = so_luong;
                document.getElementById('tong_tien_' + id).innerHTML = formatNumber(so_luong * tong_tien) + ' vnđ';
            }

            can_increase_item_web = false;
        }
        return false;
    });

    $('.amount_btn .decrease_item').click(function (e) {
        e.preventDefault();
        if (!can_decrease_item) {
            can_decrease_item = true;
            var id = $(this).attr('data-id');
            var phi_duy_tri = document.getElementById('result_phi_dt_' + id).innerHTML;
            phi_duy_tri = text_to_money(phi_duy_tri);
            var time = $('#time_item_' + id).find(':selected').val();
            var phi_khoi_tao = $(this).attr('data-pr-kt');
            var so_luong = document.getElementById('result_so_luong_' + id).innerHTML;
            so_luong = parseInt(so_luong) <= 0 ? 1 : parseInt(so_luong);

            if (so_luong > 1) {
                if (!isNaN(id) && !isNaN(phi_duy_tri) && !isNaN(time) && !isNaN(phi_khoi_tao) && !isNaN(so_luong)) {
                    trigger_update_cart['fr_update_item_' + id] = 1;
                    so_luong = parseInt(so_luong);
                    phi_khoi_tao = parseInt(phi_khoi_tao);
                    phi_duy_tri = parseInt(phi_duy_tri);
                    time = parseInt(time);
                    so_luong--;

                    document.getElementById('ip_amount_' + id).value = so_luong;
                    document.getElementById('result_so_luong_' + id).innerHTML = so_luong;
                    document.getElementById('tong_tien_' + id).innerHTML = formatNumber(so_luong * phi_duy_tri * time + phi_khoi_tao);
                }
            }
            can_decrease_item = false;
        }
        return false;
    });

    $('.amount_btn .decrease_item_web').click(function (e) {
        e.preventDefault();
        if (!can_increase_item_web) {
            can_increase_item_web = true;
            var id = $(this).attr('data-id');
            var so_luong = document.getElementById('result_so_luong_' + id).innerHTML;
            so_luong = parseInt(so_luong) <= 0 ? 1 : parseInt(so_luong);
            var tong_tien = $(this).attr('data-price');

            if (so_luong > 1) {
                if (!isNaN(id) && !isNaN(so_luong) && !isNaN(tong_tien)) {
                    trigger_update_cart['fr_update_item_' + id] = 1;
                    so_luong = parseInt(so_luong);
                    tong_tien = parseInt(tong_tien);
                    so_luong--;

                    document.getElementById('ip_amount_' + id).value = so_luong;
                    document.getElementById('result_so_luong_' + id).innerHTML = so_luong;
                    document.getElementById('tong_tien_' + id).innerHTML = formatNumber(so_luong * tong_tien) + ' vnđ';
                }
            }

            can_increase_item_web = false;
        }
        return false;
    });

    $('.fr-update-item').submit(function () {
        var id_key = $(this).attr('id');
        if (typeof trigger_update_cart[id_key] !== 'undefined') {
            return true;
        } else {
            return false;
        }
    });

    $('.add_list_to_cart').click(function (e) {
        if (!can_add_list) {
            can_add_list = true;
            e.preventDefault();
            var content_type = $(this).attr('data-content');
            var data_add = {};
            var can_add_ajax = false;

            $('.list_add_domain .id_add_list_domain').each(function () {
                if ($(this).is(":checked")) {
                    can_add_ajax = true;
                    var data_id = $(this).val();
                    data_add[data_id] = {};
                    data_add[data_id]['name'] = $(this).attr('data-name');
                    data_add[data_id]['time'] = 1;
                }
            });

            if (can_add_ajax) {

                if (content_type === null) {
                    content_type = 'cart_only';
                }
                $('body').append('<div id="modal-bg"></div><div id="modal-loader"><span class="loader"></span></div>');

                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: base_uri + '/api?rand=' + new Date().getTime(),
                    async: true,
                    cache: false,
                    dataType: "json",
                    data: 'controller=add_list_cart&content_type=' + content_type + '&data_add=' + JSON.stringify(data_add),
                    success: function (jsonData) {
                        if (jsonData.status) {
                            show_popup_cart(jsonData);
                            update_numb_cart(jsonData.count_total);
                        }
                        can_add_list = false;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $('#modal-loader').remove();
                        remove_modal();
                        can_add_list = false;
                        console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus + "\n" + 'ErrorThrown: ' + errorThrown);
                    }
                });
            } else {
                can_add_list = false;
            }
        }
        return false;
    });

    $('#update_all_cart').click(function (e) {
        console.log(can_update_all);
        e.preventDefault();
        if (!can_update_all) {
            can_update_all = true;
            var data_update = get_data_update_cart();
            $('body').append('<div id="modal-bg"></div><div id="modal-loader"><span class="loader"></span></div>');
            $.ajax({
                type: 'POST',
                headers: {"cache-control": "no-cache"},
                url: base_uri + '/api?rand=' + new Date().getTime(),
                async: true,
                cache: false,
                dataType: "json",
                data: {"data_rf": JSON.stringify(data_update), "controller": "refresh_cart"},
                success: function (jsonData) {
                    if (jsonData.status) {
                        $('#modal-loader').remove();
                        remove_modal();
                    }
                    can_update_all = false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#modal-loader').remove();
                    remove_modal();
                    can_update_all = false;
                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus + "\n" + 'ErrorThrown: ' + errorThrown);
                }
            });
        }
        return false;
    });
    
    
    
    
    
    
    
    
    /*slide*/
    
    if (typeof $('.testimonials').html() !== 'undefined') {
            var testSlide = $('.testimonials');
            testSlide.lightSlider({
                pager: true,
                item: 1,
                loop: true
            });
            testSlide.play();
        }
    
    
    /* Cloud VPS */
    $('#CloudSlider').slider({
			max : 8,
			min : 0,
			value : 2,
			step : 1,
			range : "min"
		}).slider('pips', {
			rest : 'label',
			labels : ['Start', '1', '2', '3', '4', '5', '6', '7', '8']
		}).slider();
    
    
    
    
    
    
});

function remove_modal() {
    $('#modal-bg, #remove-modal, #modal-container').remove();
    return false;
}

function update_item_cart(id_item) {
    var list_sl = $('.cart_popout').find('input[type=checkbox]');
    var i = 0;
    var id_opt;
    var check_input;
    var line_sp;
    var data_send = [];
    for (i; i < list_sl.length; i++) {
        id_opt = list_sl[i].id;
        if (typeof id_opt !== 'undefined') {
            check_input = document.getElementById(id_opt).checked;
            id_opt = id_opt.replace(/[^0-9]/g, '');
            line_sp = check_input ? 1 : 0;
            data_send.push(id_opt + '-' + line_sp);
        }
    }
    if (!update_cart) {
        update_cart = true;
        remove_modal();
        $('body').append('<div id="modal-bg"></div><div id="modal-loader"><span class="loader"></span></div>');
        $('.dynamic-attach-' + id_item + ' li').remove();
        $('.cart-attach-' + id_item + ' li').remove();
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: base_uri + '/api?rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'controller=update_opt_cart&data_update=' + data_send + '&data_id=' + id_item,
            success: function (jsonData) {
                if (jsonData.status) {
                    remove_modal();
                    $('body').append('<div id="modal-bg"></div>');
                    show_popup_cart(jsonData);
                    if (typeof jsonData.data.attach !== 'undefined') {
                        var append_html = '';
                        var fr_hidden_html = '';
                        $.each(jsonData.data.attach, function (key, value) {
                            if (value.check == 1) {
                                console.log(value);
                                append_html += '<li class="sl-attach-obj-' + key + '"><p>' + value.name + '<span><i class="count_total_price">' + formatNumber(parseInt(value.price)) + '</i>đ</span></p></li>';
                                fr_hidden_html += '<li class="sl-attach-obj-' + key + '"><input type="hidden" name="checkout_san_pham[' + id_item + '][kem_theo][' + key + '][ten]" value="' + value.name + '"/>';
                                fr_hidden_html += '<input type="hidden" name="checkout_san_pham[' + id_item + '][kem_theo][' + key + '][gia]" value="' + value.price + '"/></li>';
                            }
                        });
                    }
                    $('.cart-attach-' + id_item).append(fr_hidden_html);
                    $('.dynamic-attach-' + id_item).append(append_html);
                }
                update_cart = false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#modal-loader').remove();
                remove_modal();
                update_cart = false;
                console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus + "\n" + 'ErrorThrown: ' + errorThrown);
            }
        });
    }
    return false;
}

function formatNumber(number) {
    var number = number.toFixed(2) + '';
    var x = number.split('.');
    var x1 = x[0];
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1
}

function get_phi_duy_tri(obj, time)
{
    var data = obj.attr('data-cvtpr');
    data = JSON.parse(data);

    if ((typeof data !== 'undefined') && (time in data)) {
        return data[time];
    }

    return 0;
}

function show_popup_cart(jsonData)
{
    if (jsonData.type == 3) {
        if (jsonData.data.item.has_attach !== 0) {
            var result_title = '<span class="sp_success">Thêm vào giỏ hàng thành công!</span>';
            show_result_with_data(jsonData, result_title);
        } else {
            var result_title = '<span class="sp_success">Cập nhật giỏ hàng thành công!</span>';
            show_result_with_text(jsonData, result_title);
        }
    } else if (jsonData.type == 2) {
        var result_title = '<span class="sp_success">Cập nhật giỏ hàng thành công!</span>';
        show_result_with_text(jsonData, result_title);
    } else {
        if (jsonData.data.item.has_attach !== 0) {
            var result_title = '<span class="sp_update">Cập nhật thông tin giỏ hàng:</span>';
            show_result_with_data(jsonData, result_title);
        } else {
            var result_title = '<span class="sp_success">Cập nhật giỏ hàng thành công!</span>';
            show_result_with_text(jsonData, result_title);
        }
    }
}

function show_result_with_data(jsonData, result_title)
{
    var result_html = '<div class="result_content">' + result_title + '<i>Chọn thêm các dịch vụ bổ xung nếu cần</i><table class="cart_popout"><thead><tr><td>Dịch vụ bổ xung</td><td>Giá tiền</td></tr></thead><tbody>';
    if (typeof jsonData.data.attach !== 'undefined') {
        $.each(jsonData.data.attach, function (key, value) {
            var class_html = (key % 2 === 0) ? 'odd' : 'even';
            var input_checked = value.check == 1 ? ' checked="checked"' : '';
            result_html += '<tr class="' + class_html + '"><td><input type="checkbox" id="sl-attach-obj-' + key + '"' + input_checked + '/><label for="sl-attach-obj-' + key + '">' + value.name + '</label></td><td>' + value.price + '</td></tr>';
        });
        result_html += '</tbody></table><a href="#" class="btn-action first_child" onclick="update_item_cart(' + jsonData.data.item.id + ');return false;">Thêm lựa chọn</a><a href="' + base_uri + '/gio-hang" class="btn-action btn_pay">Thanh toán</a><a href="#" class="btn-action" onclick="remove_modal();return false;">Bỏ qua</a></div>';
    }
    $('#modal-loader').remove();
    $('body').append('<a id="remove-modal" href="#" onclick="remove_modal();return false;">Close</a><div id="modal-container">' + result_html + '</div>');
}

function show_result_with_text(jsonData, result_title)
{
    var result_html = '<div class="result_content">' + result_title + '<div class="clearfix"><a href="' + base_uri + '/gio-hang" class="btn-action btn_pay">Thanh toán</a><a href="#" class="btn-action" onclick="remove_modal();return false;">Tiếp tục mua sắm</a></div></div>';
    $('#modal-loader').remove();
    $('body').append('<a id="remove-modal" href="#" onclick="remove_modal();return false;">Close</a><div id="modal-container" class="text_only_container">' + result_html + '</div>');
}

function render_price()
{
    var count_total_price = 0;
    $('.count_total_price').each(function () {
        var count_value = $(this).text();
        count_value = count_value.split(',');
        count_value = count_value.join('');
        count_value = parseInt(count_value);
        count_total_price += count_value;
    });
    document.getElementById('result_count_total_price').innerHTML = formatNumber(count_total_price);
    document.getElementById('checkout_tong_tien').value = count_total_price;
}

function render_vat()
{
    var total_price = document.getElementById('result_count_total_price').innerHTML;
    total_price = total_price.split(',');
    total_price = total_price.join('');
    total_price = parseInt(total_price);
    var vat_price = total_price * 0.1;
    document.getElementById('result_vat_price').innerHTML = formatNumber(vat_price);
    document.getElementById('checkout_vat').value = vat_price;
}

function render_total_price()
{
    var total_price = document.getElementById('result_count_total_price').innerHTML;
    total_price = total_price.split(',');
    total_price = total_price.join('');
    total_price = parseInt(total_price);
    var vat_price = document.getElementById('result_vat_price').innerHTML;
    vat_price = vat_price.split(',');
    vat_price = vat_price.join('');
    vat_price = parseInt(vat_price);
    document.getElementById('total_sum_price').innerHTML = formatNumber(total_price + vat_price);
    document.getElementById('checkout_tong_tien_thanh_toan').value = total_price + vat_price;
}

function text_to_money(text)
{
    text = text.split(',');
    text = text.join('');
    return parseInt(text);
}

function update_numb_cart(numb)
{
    if (numb <= 0) {
        document.getElementById('count_cart').innerHTML = '(trống rỗng)';
    } else {
        document.getElementById('count_cart').innerHTML = numb + ' sản phẩm';
    }
}
function cart_blank()
{
    $('.cart_list tbody, .next_pay_cart ul.ul-info-cart, .next_pay_cart .total_cart_info, .cart_list a.bot-tab').remove();
    $('.cart_list').append('<p class="empty_cart">Bạn phải thêm vào giỏ hàng một hoặc nhiều dịch vụ trước khi đăng ký dịch vụ!</p>');
    $('.next_pay_cart').append('<p class="empty_cart">Không có thông tin đơn hàng!</p>');
}

function get_data_update_cart()
{
    var result = {};
    $('.cart_list tbody tr').each(function () {
        var data_id = $(this).attr('class');
        data_id = data_id.replace('t_item_', '');
        data_id = parseInt(data_id);
        var data_name = $(this).find('td.item_name_' + data_id).text();
        var data_time = $(this).find('#time_item_' + data_id).val();
        var data_amount = $(this).find('span#result_so_luong_' + data_id).text();
        result[data_id] = {};
        result[data_id]['item'] = {};
        result[data_id]['item']['id'] = data_id;
        result[data_id]['item']['name'] = data_name;
        result[data_id]['item']['time'] = parseInt(data_time);
        result[data_id]['item']['amount'] = parseInt(data_amount);
    });
    return result;
}

function validateEmail(email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function close_ads_footer() {
    if (show_pop_up_footer) {
        $('.ads-footer').stop(true, true).animate({
            'bottom':'-304px' 
         });
        $('a.close-ads').text('Show');
        show_pop_up_footer = false;
    } else {
        $('.ads-footer').stop(true, true).animate({
            'bottom':'-6px' 
         });
         $('a.close-ads').text('Close');
        show_pop_up_footer = true;
    }
    return false;
}

function close_ads_pop_up() {
    $('.ads-pop-up').remove();
}