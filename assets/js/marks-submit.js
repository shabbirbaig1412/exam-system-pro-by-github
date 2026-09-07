jQuery(function($) {
    var $submitBtn = $("#esp_submit_marks");
    var $notice = $("#esp_marks_notice");

    function showNotice(msg, type) {
        type = type || "success";
        $notice
            .removeClass("notice-success notice-error notice-warning")
            .addClass("notice-" + type)
            .show()
            .find("p")
            .html(msg);
        $('html, body').animate({ scrollTop: $notice.offset().top - 40 }, 200);
    }

    $submitBtn.on("click", function() {
        var examId = $("#esp_exam").val();
        var classId = $("#esp_class").val();
        var subjectId = $("#esp_subject").val();

        if (!examId || !subjectId) {
            showNotice("<strong>Please select an exam and subject first.</strong>", "warning");
            return;
        }

        if (!window.confirm("Are you sure you want to SUBMIT and LOCK this marks sheet?\n\nOnce locked, marks cannot be modified unless an administrator grants a resubmission.")) {
            return;
        }

        $submitBtn.prop("disabled", true).text("Submitting & Locking…");

        $.post(ESP.ajax || ajaxurl, {
            action: "esp_submit_marks",
            _wpnonce: ESP.nonce,
            exam_id: examId,
            class_id: classId,
            subject_id: subjectId
        })
        .done(function(response) {
            if (response.success) {
                var msg = response.data && response.data.message ? response.data.message : "Marks submitted and sheet locked successfully.";
                showNotice("<strong>" + msg + "</strong>", "success");

                // Lock all inputs
                $("#esp_marks_table tbody input").prop("disabled", true);
                $("#esp_save_marks").prop("disabled", true);
                $submitBtn.prop("disabled", true).html('<span class="dashicons dashicons-lock" style="font-size:16px;width:16px;height:16px;"></span> Sheet Locked');

                $("#esp_sheet_status_badge")
                    .text("Locked / Submitted")
                    .css({ background: "#fcf0f1", color: "#b32d2e", border: "1px solid #e2a1a2" })
                    .show();

                if (!window.ESP_MARKS_INIT || !window.ESP_MARKS_INIT.is_admin) {
                    $("#esp_request_resubmit").css("display", "inline-flex");
                }
            } else {
                var err = response.data && response.data.message ? response.data.message : "Submission failed.";
                showNotice("<strong>" + err + "</strong>", "error");
                $submitBtn.prop("disabled", false).html('<span class="dashicons dashicons-lock" style="font-size:16px;width:16px;height:16px;"></span> Submit & Lock Sheet');
            }
        })
        .fail(function(xhr) {
            var err = "Submission failed due to network or server error.";
            if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                err = xhr.responseJSON.data.message;
            }
            showNotice("<strong>" + err + "</strong>", "error");
            $submitBtn.prop("disabled", false).html('<span class="dashicons dashicons-lock" style="font-size:16px;width:16px;height:16px;"></span> Submit & Lock Sheet');
        });
    });
});

