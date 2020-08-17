jQuery(document).ready(function ($) {

    //tabs
    $('.s9-options-tab-btns li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('.s9-options-tab-btns li').removeClass('s9-active');
        $('.s9-tab-frame').removeClass('s9-active');

        $(this).addClass('s9-active');
        $("#" + tab_id).addClass('s9-active');
    });

    var loginRadiusSharingHorizontalSharingProviders;
    var loginRadiusSharingVerticalSharingProviders;

    function init() {
        loginRadiusSharingHorizontalSharingProviders = $('.Social9_hz_share_providers');
        loginRadiusSharingVerticalSharingProviders = $('.Social9_ve_share_providers')

        var h_selected = $('input:radio[name="Social9_share_settings[horizontal_share_interface]"]:checked').val();
        var v_selected = $('input:radio[name="Social9_share_settings[vertical_share_interface]"]:checked').val();

        if (h_selected == "32-h" || h_selected == "16-h" || h_selected == "responsive") {
            $('#s9_hz_ve_theme_options').hide();
            $('#s9_hz_theme_options,#s9_hz_hz_theme_options,#login_radius_horizontal_rearrange_container').show();
        } else if (h_selected == "hybrid-h-h" || h_selected == "hybrid-h-v") {
            $('').show();
            $('#s9_hz_hz_theme_options').hide();
            $('#s9_hz_theme_options,#s9_hz_ve_theme_options,#login_radius_horizontal_rearrange_container').show();
        } else {
            $('#s9_hz_theme_options,#login_radius_horizontal_rearrange_container').hide();
        }

        if (v_selected == "32-v" || v_selected == "16-v") {
            $('#s9_ve_ve_theme_options').hide();
            $('#s9_ve_theme_options,#s9_ve_hz_theme_options,#login_radius_vertical_rearrange_container').show();
        } else if (v_selected == "hybrid-v-h" || v_selected == "hybrid-v-v") {
            $('#s9_ve_theme_options,#s9_ve_ve_theme_options').show();
            $('#s9_ve_hz_theme_options,#login_radius_vertical_rearrange_container').hide();
        } else {
            $('#s9_ve_theme_options,#login_radius_vertical_rearrange_container').hide();
        }
    }

    if ($('#s9-enable-horizontal').is(':checked')) {
        $(".s9-option-disabled-hr").hide();
    } else {
        $(".s9-option-disabled-hr").show();
    }

    if ($('#s9-enable-vertical').is(':checked')) {
        $(".s9-option-disabled-vr").hide();
    } else {
        $(".s9-option-disabled-vr").show();
    }

    $('input:radio[name="Social9_share_settings[horizontal_share_interface]"]').change(function () {
        if (this.value == "32-h" || this.value == "16-h" || this.value == "responsive") {
            $('#s9_hz_ve_theme_options').hide();
            $('#s9_hz_theme_options,#s9_hz_hz_theme_options,#login_radius_horizontal_rearrange_container').show();
        } else if (this.value == "hybrid-h-h" || this.value == "hybrid-h-v") {
            $('#s9_hz_theme_options,#s9_hz_ve_theme_options').show();
            $('#s9_hz_hz_theme_options,#login_radius_horizontal_rearrange_container').hide();
        } else {
            $('#s9_hz_theme_options,#login_radius_horizontal_rearrange_container').hide();
        }
    });

    $('input:radio[name="Social9_share_settings[vertical_share_interface]"]').change(function () {
        if (this.value == "32-v" || this.value == "16-v") {
            $('#s9_ve_ve_theme_options').hide();
            $('#s9_ve_theme_options,#s9_ve_hz_theme_options,#login_radius_vertical_rearrange_container').show();
        } else if (this.value == "hybrid-v-h" || this.value == "hybrid-v-v") {
            $('#s9_ve_theme_options,#s9_ve_ve_theme_options').show();
            $('#s9_ve_hz_theme_options,#login_radius_vertical_rearrange_container').hide();
        } else {
            $('#s9_ve_theme_options,#login_radius_vertical_rearrange_container').hide();
        }
    });

    $("#loginRadiusHorizontalSortable").sortable({
        scroll: false,
        revert: true,
        tolerance: 'pointer',
        items: '> li:not(.s9-pin)',
        containment: 'parent',
        axis: 'x'
    });

    $("#loginRadiusVerticalSortable").sortable({
        scroll: false,
        revert: true,
        tolerance: 'pointer',
        items: '> li:not(.s9-pin)',
        containment: 'parent',
        axis: 'y'
    });

    // prepare rearrange provider list
    function loginRadiusRearrangeProviderList(elem, sharingType) {
        $ul = $('#loginRadius' + sharingType + 'Sortable');
        if (elem.checked) {
            $listItem = $('<li />');
            $listItem.attr({
                id: 'loginRadius' + sharingType + 'LI' + elem.value,
                title: elem.value,
                class: 'lrshare_iconsprite32 s9-icon-' + elem.value.toLowerCase()
            });

            // append hidden field
            $provider = $('<input />');
            $provider.attr({
                type: 'hidden',
                name: 'Social9_share_settings[' + sharingType.toLowerCase() + '_rearrange_providers][]',
                value: elem.value
            });
            $listItem.append($provider);
            $ul.append($listItem);
        } else {
            if ($('#loginRadius' + sharingType + 'LI' + elem.value)) {
                $('#loginRadius' + sharingType + 'LI' + elem.value).remove();
            }
        }
    }

    // limit maximum number of providers selected in horizontal sharing
    function loginRadiusHorizontalSharingLimit(elem) {
        var checkCount = 0;
        for (var i = 0; i < loginRadiusSharingHorizontalSharingProviders.length; i++) {
            if (loginRadiusSharingHorizontalSharingProviders[i].checked) {
                // count checked providers
                checkCount++;
                if (checkCount >= 9) {
                    elem.checked = false;
                    $('#loginRadiusHorizontalSharingLimit').show().delay(3000).fadeOut();
                    return;
                }
            }
        }
    }

    // limit maximum number of providers selected in horizontal sharing
    function loginRadiusHorizontalVerticalSharingLimit(elem) {
        var checkCount = 0;
        var inputs = document.getElementsByClassName(elem.className);

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                // count checked providers
                checkCount++;
                if (checkCount >= 9) {
                    elem.checked = false;
                    $('#loginRadiusHorizontalVerticalSharingLimit').show().delay(3000).fadeOut();
                    return;
                }
            }
        }
    }

    // limit maximum number of providers selected in vertical sharing
    function loginRadiusVerticalSharingLimit(elem) {
        var checkCount = 0;
        for (var i = 0; i < loginRadiusSharingVerticalSharingProviders.length; i++) {
            if (loginRadiusSharingVerticalSharingProviders[i].checked) {
                // count checked providers
                checkCount++;
                if (checkCount >= 9) {
                    elem.checked = false;
                    $('#loginRadiusVerticalSharingLimit').show().delay(3000).fadeOut();
                    return;
                }
            }
        }
    }

    function loginRadiusVerticalVerticalSharingLimit(elem) {
        var checkCount = 0;
        var inputs = document.getElementsByClassName(elem.className);
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                // count checked providers
                checkCount++;
                if (checkCount >= 9) {
                    elem.checked = false;
                    $('#loginRadiusVerticalVerticalSharingLimit').show().delay(3000).fadeOut();
                    return;
                }
            }
        }
    }

    $('.Social9_hz_share_providers').change(function () {
        loginRadiusHorizontalSharingLimit(this);
        loginRadiusRearrangeProviderList(this, 'Horizontal');
    });

    $('.Social9_hz_ve_share_providers').change(function () {
        loginRadiusHorizontalVerticalSharingLimit(this);
    });

    $('.Social9_ve_share_providers').change(function () {
        loginRadiusVerticalSharingLimit(this);
        loginRadiusRearrangeProviderList(this, 'Vertical');
    });

    $('.Social9_ve_ve_share_providers').change(function () {
        loginRadiusVerticalVerticalSharingLimit(this);
    });

    $('#s9-clicker-hr-home').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-hr-home-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-hr-home-options').prop('checked', false);
        }
    });

    $('#s9-clicker-hr-post').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-hr-post-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-hr-post-options').prop('checked', false);
        }
    });

    $('#s9-clicker-hr-static').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-hr-static-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-hr-static-options').prop('checked', false);
        }
    });

    $('#s9-clicker-hr-excerpts').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-hr-excerpts-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-hr-excerpts-options').prop('checked', false);
        }
    });

    $('#s9-enable-horizontal').change(function () {
        if ($(this).is(':checked')) {
            $('#s9-clicker-hr-home').prop('checked', true);
            $('.s9-clicker-hr-home-options.default').prop('checked', true);
            $('#s9-clicker-hr-post').prop('checked', true);
            $('.s9-clicker-hr-post-options.default').prop('checked', true);
            $('#s9-clicker-hr-static').prop('checked', true);
            $('.s9-clicker-hr-static-options.default').prop('checked', true);
            $('#s9-clicker-hr-excerpts').prop('checked', true);
            $('.s9-clicker-hr-excerpts-options.default').prop('checked', true);

        } else {
            $('#s9-clicker-hr-home').prop('checked', false);
            $('.s9-clicker-hr-home-options').prop('checked', false);
            $('#s9-clicker-hr-post').prop('checked', false);
            $('.s9-clicker-hr-post-options').prop('checked', false);
            $('#s9-clicker-hr-static').prop('checked', false);
            $('.s9-clicker-hr-static-options').prop('checked', false);
            $('#s9-clicker-hr-excerpts').prop('checked', false);
            $('.s9-clicker-hr-excerpts-options').prop('checked', false);
        }
    });

    $('#s9-clicker-vr-home').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-vr-home-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-vr-home-options').prop('checked', false);
        }
    });

    $('#s9-clicker-vr-post').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-vr-post-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-vr-post-options').prop('checked', false);
        }
    });

    $('#s9-clicker-vr-static').change(function () {
        if ($(this).is(':checked')) {
            $('.s9-clicker-vr-static-options.default').prop('checked', true);
        } else {
            $('.s9-clicker-vr-static-options').prop('checked', false);
        }
    });

    $('#s9-enable-vertical').change(function () {
        if ($(this).is(':checked')) {
            $('#s9-clicker-vr-home').prop('checked', true);
            $('.s9-clicker-vr-home-options.default').prop('checked', true);
            $('#s9-clicker-vr-post').prop('checked', true);
            $('.s9-clicker-vr-post-options.default').prop('checked', true);
            $('#s9-clicker-vr-static').prop('checked', true);
            $('.s9-clicker-vr-static-options.default').prop('checked', true);

        } else {
            $('#s9-clicker-vr-home').prop('checked', false);
            $('.s9-clicker-vr-home-options').prop('checked', false);
            $('#s9-clicker-vr-post').prop('checked', false);
            $('.s9-clicker-vr-post-options').prop('checked', false);
            $('#s9-clicker-vr-static').prop('checked', false);
            $('.s9-clicker-vr-static-options').prop('checked', false);
        }
    });

    $('#s9-enable-horizontal').change(function () {
        if ($(this).is(':checked')) {
            $(".s9-option-disabled-hr").hide();
        } else {
            $(".s9-option-disabled-hr").show();
        }
    });

    $('#s9-enable-vertical').change(function () {
        if ($(this).is(':checked')) {
            $(".s9-option-disabled-vr").hide();
        } else {
            $(".s9-option-disabled-vr").show();
        }
    });

    init();
})
