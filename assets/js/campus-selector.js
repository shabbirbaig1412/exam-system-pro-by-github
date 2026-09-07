jQuery(function($) {
    $("#esp-campus-selector, #esp-campus-context").on("change", function() {
        var val = $(this).val();
        if (val) {
            var url = new URL(window.location.href);
            url.searchParams.set('campus', val);
            url.searchParams.delete('edit_id');
            url.searchParams.delete('esp_status');
            url.searchParams.delete('esp_error');
            window.location = url.toString();
        }
    });

    $("#esp-session-context").on("change", function() {
        var val = $(this).val();
        if (val) {
            var url = new URL(window.location.href);
            url.searchParams.set('session', val);
            url.searchParams.delete('edit_id');
            url.searchParams.delete('esp_status');
            url.searchParams.delete('esp_error');
            window.location = url.toString();
        }
    });
});

