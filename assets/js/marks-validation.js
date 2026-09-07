jQuery(function($) {
    $(document).on("input change keyup", ".esp-mark", function() {
        var $input = $(this);
        var $row = $input.closest("tr");
        var max = parseFloat($input.data("max")) || 100;
        var passing = parseFloat($input.data("passing")) || 40;
        var raw = $input.val();
        var val = parseFloat(raw);
        var $statusBadge = $row.find(".esp-row-status");

        window.espDirty = true;

        if (raw !== "" && (isNaN(val) || val > max || val < 0)) {
            $input.addClass("esp-invalid").attr("title", "Must be between 0 and " + max);
        } else {
            $input.removeClass("esp-invalid").removeAttr("title");
        }

        if (raw !== "" && !isNaN(val)) {
            if (val >= passing) {
                $statusBadge
                    .text("PASS")
                    .removeClass("esp-status-fail esp-status-pending")
                    .addClass("esp-status-pass");
            } else {
                $statusBadge
                    .text("FAIL")
                    .removeClass("esp-status-pass esp-status-pending")
                    .addClass("esp-status-fail");
            }
        } else {
            $statusBadge
                .text("—")
                .removeClass("esp-status-pass esp-status-fail")
                .addClass("esp-status-pending");
        }

        if (typeof window.espUpdateProgress === "function") {
            window.espUpdateProgress();
        }
    });
});