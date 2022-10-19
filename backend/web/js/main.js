$('#unlim_checkbox').click(function () {
    if ($(this).is(':checked')) {
        $("#trafic_id").val("unlim");
        $("#trafic_id").attr('disabled', 'disabled');
    } else {
        $("#trafic_id").attr('disabled', false);
        $("#trafic_id").val(" ");
    }
});