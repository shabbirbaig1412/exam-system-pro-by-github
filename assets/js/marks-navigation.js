jQuery(function($) {
    $(document).on("keydown", ".esp-mark, .esp-remark", function(e) {
        var $input = $(this);
        var $td = $input.closest("td");
        var $tr = $input.closest("tr");
        var colIndex = $td.index();

        // 13: Enter -> Jump to next row in same column
        if (e.which === 13) {
            e.preventDefault();
            var $nextRow = $tr.nextAll("tr:visible").first();
            if ($nextRow.length) {
                var $nextInput = $nextRow.children().eq(colIndex).find("input:not(:disabled)");
                if ($nextInput.length) {
                    $nextInput.focus().select();
                }
            }
            return;
        }

        // 38: Arrow Up -> Jump to previous row in same column
        if (e.which === 38) {
            e.preventDefault();
            var $prevRow = $tr.prevAll("tr:visible").first();
            if ($prevRow.length) {
                var $prevInput = $prevRow.children().eq(colIndex).find("input:not(:disabled)");
                if ($prevInput.length) {
                    $prevInput.focus().select();
                }
            }
            return;
        }

        // 40: Arrow Down -> Jump to next row in same column
        if (e.which === 40) {
            e.preventDefault();
            var $nextRow = $tr.nextAll("tr:visible").first();
            if ($nextRow.length) {
                var $nextInput = $nextRow.children().eq(colIndex).find("input:not(:disabled)");
                if ($nextInput.length) {
                    $nextInput.focus().select();
                }
            }
            return;
        }
    });
});