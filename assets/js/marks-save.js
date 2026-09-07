jQuery(function($) {
    var $saveBtn = $("#esp_save_marks");
    var $notice = $("#esp_marks_notice");

    function showNotice(msg, type) {
        type = type || "success";
        $notice
            .removeClass("notice-success notice-error notice-warning")
            .addClass("notice-" + type)
            .show()
            .find("p")
            .html(msg);
        if ($notice.length && $notice.offset()) {
            $('html, body').animate({ scrollTop: Math.max(0, $notice.offset().top - 50) }, 200);
        }
    }

    $saveBtn.on("click", function() {
        var examId = $("#esp_exam").val();
        var classId = $("#esp_class").val();
        var subjectId = $("#esp_subject").val();

        if (!examId || !subjectId) {
            showNotice("<strong>Please load a valid marks sheet first.</strong>", "warning");
            return;
        }

        var invalidInputs = $("#esp_marks_table tbody .esp-mark.esp-invalid");
        if (invalidInputs.length > 0) {
            if (!confirm("Some entered marks exceed the maximum marks allowed. Do you still want to save?")) {
                invalidInputs.first().focus();
                return;
            }
        }

        var marksData = collectMarks();
        if (marksData.length === 0) {
            showNotice("<strong>No student marks found to save.</strong>", "warning");
            return;
        }

        $saveBtn.prop("disabled", true).text("Saving…");

        $.post(ESP.ajax || ajaxurl, {
            action: "esp_save_marks",
            _wpnonce: ESP.nonce,
            exam_id: examId,
            class_id: classId,
            subject_id: subjectId,
            data: marksData
        })
        .done(function(response) {
            if (response.success) {
                var msg = response.data && response.data.message ? response.data.message : "Marks saved successfully.";
                showNotice("<strong>" + msg + "</strong>", "success");
                window.espDirty = false;

                if (response.data && response.data.resubmit_used) {
                    $("#esp_sheet_status_badge")
                        .text("Locked / Submitted")
                        .css({ background: "#fcf0f1", color: "#b32d2e", border: "1px solid #e2a1a2" });
                }
            } else {
                var err = response.data && response.data.message ? response.data.message : "Marks could not be saved.";
                showNotice("<strong>" + err + "</strong>", "error");
            }
        })
        .fail(function(xhr) {
            var err = "Server error while saving marks.";
            if (xhr.responseJSON) {
                if (xhr.responseJSON.data && xhr.responseJSON.data.message) {
                    err = xhr.responseJSON.data.message;
                } else if (xhr.responseJSON.message) {
                    err = xhr.responseJSON.message;
                }
            } else if (xhr.responseText && xhr.responseText.indexOf('<') === -1) {
                err = xhr.responseText;
            }
            showNotice("<strong>" + err + "</strong>", "error");
        })
        .always(function() {
            $saveBtn.prop("disabled", false).html('<span class="dashicons dashicons-saved" style="font-size:16px;width:16px;height:16px;"></span> Save Marks (Ctrl+S)');
        });
    });

    function collectMarks() {
        var data = [];
        $("#esp_marks_table tbody tr[data-student]").each(function() {
            var $row = $(this);
            var studentId = $row.data("student");
            var $input = $row.find(".esp-mark");
            var $remark = $row.find(".esp-remark");
            var subId = $input.data("subject") || $("#esp_subject").val();
            var val = $input.val();

            if (studentId) {
                data.push({
                    student_id: studentId,
                    subject_id: subId,
                    obtained_marks: val !== "" ? val : 0,
                    remarks: $remark.val() || ""
                });
            }
        });
        return data;
    }
});

