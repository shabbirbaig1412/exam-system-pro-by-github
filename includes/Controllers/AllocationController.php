<?php

defined('ABSPATH') || exit;

class ESP_AllocationController {

    private ESP_AllocationRepository $repo;

    public function __construct() {

        $this->repo =

            new ESP_AllocationRepository();

    }

    public function index(): void {

        ESP_Capability::admin();

        $allocations =

            $this->repo->all();

        $classes =

            (new ESP_ClassRepository())

            ->all();

        $subjects =

            (new ESP_SubjectRepository())

            ->all();

        $teachers =

            (new ESP_TeacherRepository())

            ->active();

        require ESP_TEMPLATE

            .'admin/allocations.php';

    }

    public function save(

        array $data

    ): bool {

        global $wpdb;
        $campus=ESP_CampusContext::id(); $session=ESP_SessionContext::id();
        $class=(int)($data['class_id']??0); $subject=(int)($data['subject_id']??0); $teacher=(int)($data['teacher_id']??0);
        if (!$campus||!$session ||
            !$wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_classes WHERE id=%d AND campus_id=%d",$class,$campus)) ||
            !$wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_subjects WHERE id=%d AND campus_id=%d",$subject,$campus)) ||
            !$wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_teachers WHERE id=%d AND campus_id=%d AND status=1",$teacher,$campus))) return false;
        $record = [

            'class_id'=>

            (int)$data['class_id'],

            'subject_id'=>

            (int)$data['subject_id'],

            'teacher_id'=>$teacher,
            'session_id'=>$session,

            'campus_id'=>$campus,

            'created_at'=>

            current_time('mysql')

        ];

        if (

            empty($data['id'])

        ) {

            return

                $this->repo

                ->insert($record)>0;

        }

        return

            $this->repo

            ->update(

                (int)$data['id'],

                $record

            );

    }

    public function delete(

        int $id

    ): bool {

        return

            $this->repo

            ->delete($id);

    }

}
