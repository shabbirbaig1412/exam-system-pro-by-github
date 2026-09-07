jQuery(function($) {
    window.espUpdateProgress = function() {
        var $marks = $(".esp-mark");
        var total = $marks.length;
        var filled = 0;

        $marks.each(function() {
            if ($(this).val() !== "") {
                filled++;
            }
        });

        var percent = total > 0 ? Math.round((filled / total) * 100) : 0;
        $("#esp_progress").text(percent + "%");
        $("#esp_progress_count").text("(" + filled + "/" + total + ")");
    };

    $(document).on("input keyup change", ".esp-mark", function() {
        if (typeof window.espUpdateProgress === "function") {
            window.espUpdateProgress();
        }
    });

    window.espUpdateProgress();
});