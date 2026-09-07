jQuery(function($) {
    var $examSelect = $("#esp_exam");
    var $classSelect = $("#esp_class");
    var $subjectSelect = $("#esp_subject");
    var $loadBtn = $("#esp_load_marks");
    var $saveBtn = $("#esp_save_marks");
    var $submitBtn = $("#esp_submit_marks");
    var $resubmitBtn = $("#esp_request_resubmit");
    var $tableBody = $("#esp_marks_table tbody");
    var $notice = $("#esp_marks_notice");
    var $statusBadge = $("#esp_sheet_status_badge");
    var $subjectBadge = $("#esp_subject_info_badge");

    function showNotice(msg, type) {
        type = type || "error";
        $notice
            .removeClass("notice-success notice-error notice-warning")
            .addClass("notice-" + type)
            .show()
            .find("p")
            .html(msg);
    }

    function hideNotice() {
        $notice.hide().find("p").empty();
    }

    function filterClassesByExam(examId) {
        $classSelect.prop("disabled", !examId);
        $classSelect.find("option").each(function() {
            var $option = $(this);
            if (!$option.val()) {
                $option.show();
                return;
            }
            var examIds = [];
            try {
                examIds = JSON.parse($option.attr("data-exam-ids") || "[]");
            } catch (e) {
                examIds = [];
            }
            $option.toggle(examIds.indexOf(parseInt(examId, 10)) !== -1);
        });
        var selectedClass = $classSelect.find("option:selected");
        var selectedExamIds = [];
        try {
            selectedExamIds = JSON.parse(selectedClass.attr("data-exam-ids") || "[]");
        } catch (e) {
            selectedExamIds = [];
        }
        if (!examId || selectedExamIds.indexOf(parseInt(examId, 10)) === -1) {
            $classSelect.val("");
            $subjectSelect.val("");
        }
    }

    filterClassesByExam($examSelect.val());

    // Dependent synchronization: Exam Selection
    $examSelect.on("change", function() {
        var examId = $(this).val();
        filterClassesByExam(examId);
    });

    // Dependent synchronization: Class Selection
    $classSelect.on("change", function() {
        var classId = $(this).val();
        if (!classId) return;

        filterSubjectsByClass(classId);

    });

    function filterSubjectsByClass(classId) {
        if (!window.ESP_MARKS_INIT || !window.ESP_MARKS_INIT.class_subject_map) return;
        var map = window.ESP_MARKS_INIT.class_subject_map;
        var allowedSubjects = map[classId] || [];

        // If map has entries for this class, filter subject options
        if (allowedSubjects.length > 0) {
            $subjectSelect.find("option").each(function() {
                var sId = parseInt($(this).val(), 10);
                if (!sId) {
                    $(this).show();
                } else if (allowedSubjects.indexOf(sId) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            // If current subject is hidden, reset it
            var curSubject = parseInt($subjectSelect.val(), 10);
            if (curSubject && allowedSubjects.indexOf(curSubject) === -1) {
                $subjectSelect.val("");
            }
        } else {
            $subjectSelect.find("option").show();
        }
    }

    // Load Marks Button Click
    $loadBtn.on("click", function() {
        hideNotice();
        var examId = $examSelect.val();
        var classId = $classSelect.val();
        var subjectId = $subjectSelect.val();

        if (!examId) {
            showNotice("<strong>" + (ESP.i18n_missing_exam || "Please select an Exam.") + "</strong>", "warning");
            $examSelect.focus();
            return;
        }

        if (!subjectId) {
            showNotice("<strong>" + (ESP.i18n_missing_subject || "Please select a Subject.") + "</strong>", "warning");
            $subjectSelect.focus();
            return;
        }

        // Set Loading state
        $loadBtn.prop("disabled", true).find(".dashicons").addClass("spin");
        $saveBtn.prop("disabled", true);
        $submitBtn.prop("disabled", true);
        $resubmitBtn.hide();
        $statusBadge.hide();
        $subjectBadge.hide();

        $tableBody.html(
            '<tr class="esp-loading-row"><td colspan="7" style="text-align:center;padding:40px 20px;color:#2271b1;"><span class="spinner is-active" style="float:none;vertical-align:middle;margin-right:8px;"></span> <strong>Loading marks sheet…</strong></td></tr>'
        );

        $.post(
            ESP.ajax || ajaxurl,
            {
                action: "esp_load_marks",
                _wpnonce: ESP.nonce,
                exam: examId,
                class: classId,
                subject: subjectId
            }
        )
        .done(function(res) {
            if (res.success && res.data) {
                $tableBody.html(res.data.html);

                if (res.data.class_id && !$classSelect.val()) {
                    $classSelect.val(res.data.class_id);
                }

                var count = res.data.count || 0;
                var isLocked = !!res.data.is_locked;
                var resubmitActive = !!res.data.resubmit_active;
                var canRequestResubmit = !!res.data.can_resubmit_request;

                // Update subject info badge
                if (res.data.subject_name) {
                    $subjectBadge
                        .text(res.data.subject_name + " (Max: " + res.data.total_marks + " | Pass: " + res.data.passing_marks + ")")
                        .show();
                }

                // Update sheet status badge & buttons
                if (isLocked) {
                    $statusBadge
                        .text("Locked / Submitted")
                        .css({ background: "#fcf0f1", color: "#b32d2e", border: "1px solid #e2a1a2" })
                        .show();
                    $saveBtn.prop("disabled", true);
                    $submitBtn.prop("disabled", true);
                    if (canRequestResubmit) {
                        $resubmitBtn.css("display", "inline-flex");
                    }
                } else if (resubmitActive) {
                    $statusBadge
                        .text("Resubmission Active (1x)")
                        .css({ background: "#fbf3e0", color: "#996800", border: "1px solid #ecd58c" })
                        .show();
                    if (count > 0) {
                        $saveBtn.prop("disabled", false);
                        $submitBtn.prop("disabled", false);
                    }
                } else {
                    $statusBadge
                        .text("Open for Editing")
                        .css({ background: "#edfaef", color: "#1a7f37", border: "1px solid #9ee0a7" })
                        .show();
                    if (count > 0) {
                        $saveBtn.prop("disabled", false);
                        $submitBtn.prop("disabled", false);
                    }
                }

                // Trigger progress calculation
                if (typeof window.espUpdateProgress === "function") {
                    window.espUpdateProgress();
                }

                // Auto-focus first mark input
                setTimeout(function() {
                    $tableBody.find(".esp-mark:not(:disabled):first").focus().select();
                }, 100);

            } else {
                var errorMsg = res.data && res.data.message ? res.data.message : "Failed to load marks sheet.";
                showNotice("<strong>" + errorMsg + "</strong>", "error");
                $tableBody.html(
                    '<tr class="esp-error-row"><td colspan="7" style="text-align:center;padding:35px 20px;color:#d63638;"><span class="dashicons dashicons-warning" style="font-size:24px;width:24px;height:24px;vertical-align:middle;margin-right:6px;"></span> ' +
                    errorMsg +
                    "</td></tr>"
                );
            }
        })
        .fail(function(xhr) {
            var err = "Connection error. Please check your network and try again.";
            if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                err = xhr.responseJSON.data.message;
            }
            showNotice("<strong>" + err + "</strong>", "error");
            $tableBody.html(
                '<tr class="esp-error-row"><td colspan="7" style="text-align:center;padding:35px 20px;color:#d63638;"><span class="dashicons dashicons-warning" style="font-size:24px;width:24px;height:24px;vertical-align:middle;margin-right:6px;"></span> ' +
                err +
                "</td></tr>"
            );
        })
        .always(function() {
            $loadBtn.prop("disabled", false).find(".dashicons").removeClass("spin");
        });
    });
});
