jQuery(function($) {
    $("#esp_request_resubmit").on("click", function() {
        var examId = $("#esp_exam").val();
        var classId = $("#esp_class").val();
        var subjectId = $("#esp_subject").val();

        if (!examId || !subjectId) {
            alert("Please select an exam and subject first.");
            return;
        }

        if (!confirm("Request administrator to allow a one-time resubmission for this marks sheet?")) {
            return;
        }

        var $btn = $(this).prop("disabled", true);

        $.post(
            ESP.ajax || ajaxurl,
            {
                action: "esp_request_resubmit",
                _wpnonce: ESP.nonce,
                exam_id: examId,
                class_id: classId,
                subject_id: subjectId
            },
            function(r) {
                var msg = r.data && r.data.message ? r.data.message : (r.success ? "Resubmission requested." : "Request failed.");
                var $notice = $("#esp_marks_notice");
                $notice
                    .removeClass("notice-error notice-success notice-warning")
                    .addClass(r.success ? "notice-success" : "notice-error")
                    .show()
                    .find("p")
                    .html("<strong>" + msg + "</strong>");
            }
        ).always(function() {
            $btn.prop("disabled", false);
        });
    });
});

