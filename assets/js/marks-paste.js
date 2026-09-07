jQuery(function($) {
    // 1. Direct cell paste (Excel tab-separated / newline)
    $("#esp_marks_table").on("paste", ".esp-mark, .esp-remark", function(e) {
        var clipboard = (e.originalEvent || e).clipboardData.getData("text");
        if (!clipboard || clipboard.indexOf("\n") === -1 && clipboard.indexOf("\t") === -1) {
            return; // Normal single cell paste
        }

        e.preventDefault();
        var rows = clipboard.trim().split(/\r?\n/);
        var $startInput = $(this);
        var $startTd = $startInput.closest("td");
        var $startTr = $startInput.closest("tr");
        var startRowIndex = $startTr.index();
        var startColIndex = $startTd.index();

        var $allRows = $("#esp_marks_table tbody tr:visible");

        rows.forEach(function(r, i) {
            var $targetRow = $allRows.eq(startRowIndex + i);
            if (!$targetRow.length) return;

            var cols = r.split("\t");
            cols.forEach(function(val, j) {
                var $targetInput = $targetRow.children().eq(startColIndex + j).find("input:not(:disabled)");
                if ($targetInput.length) {
                    $targetInput.val(val.trim()).trigger("input");
                }
            });
        });
    });

    // 2. Export Excel (CSV)
    $("#esp_export_excel").on("click", function() {
        var $rows = $("#esp_marks_table tbody tr[data-student]:visible");
        if (!$rows.length) {
            alert("Please load a marks sheet first to export.");
            return;
        }

        var csvContent = "Roll No,Student Name,Marks\n";
        $rows.each(function() {
            var roll = $(this).find(".esp-col-roll").text().trim();
            var name = $(this).find(".esp-col-name").text().trim();
            // escape quotes in name for valid CSV
            if (name.includes(",") || name.includes('"')) {
                name = '"' + name.replace(/"/g, '""') + '"';
            }
            var marks = $(this).find(".esp-mark").val() || "";
            csvContent += roll + "," + name + "," + marks + "\n";
        });

        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement("a");
        var url = URL.createObjectURL(blob);
        
        var exam = $("#esp_exam option:selected").text().trim();
        var cls = $("#esp_class option:selected").text().trim();
        var sub = $("#esp_subject option:selected").text().trim();
        var filename = "Marks_" + exam + "_" + cls + "_" + sub + ".csv";
        filename = filename.replace(/[^a-z0-9]/gi, '_').toLowerCase() + ".csv";

        link.setAttribute("href", url);
        link.setAttribute("download", filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // 3. Import Excel (CSV File Reader)
    $("#esp_import_file").on("change", function(e) {
        var file = e.target.files[0];
        if (!file) return;

        var $rows = $("#esp_marks_table tbody tr[data-student]:visible");
        if (!$rows.length) {
            alert("Please load a marks sheet first before importing data.");
            $(this).val("");
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            var text = e.target.result;
            var lines = text.split(/\r?\n/);
            var appliedCount = 0;

            // Build roll number index map
            var rollMap = {};
            $rows.each(function(idx) {
                var roll = $(this).find(".esp-col-roll").text().trim().toLowerCase();
                if (roll && roll !== "—") {
                    rollMap[roll] = $(this);
                }
            });

            lines.forEach(function(line, idx) {
                line = line.trim();
                if (!line) return;
                
                // Skip header if it contains 'roll no'
                if (idx === 0 && line.toLowerCase().includes("roll")) {
                    return;
                }

                // Parse CSV line (simple split by comma, ignoring complex quotes for marks usually)
                // A better parser handles quotes, but for roll, name, marks, splitting by last comma works too.
                var parts = line.split(",");
                if (parts.length >= 2) {
                    var roll = parts[0].trim().toLowerCase();
                    // Marks should be the last column in our export
                    var markVal = parts[parts.length - 1].trim();
                    var $matchedRow = rollMap[roll];

                    if ($matchedRow && $matchedRow.length) {
                        var $input = $matchedRow.find(".esp-mark:not(:disabled)");
                        if ($input.length) {
                            $input.val(markVal).trigger("input");
                            appliedCount++;
                        }
                    }
                }
            });

            var $notice = $("#esp_marks_notice");
            $notice
                .removeClass("notice-error notice-warning")
                .addClass("notice-success")
                .show()
                .find("p")
                .html("<strong>Imported " + appliedCount + " marks from CSV. Review and click 'Save Marks' to persist.</strong>");
        };

        reader.readAsText(file);
        
        // Reset file input so same file can be selected again
        $(this).val("");
    });
});