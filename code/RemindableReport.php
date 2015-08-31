<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 25.02.2015
 * Time: 13:07
 */

class RemindableReport extends SS_Report {

    public function title() {
        return "Liste aller Reminders";
    }

    public function columns() {
        return array(
            'Subject' => array(
                'title' => 'Name',
                'formatting' => '<a href=\"{$Link}\" title=\"go...\">{$value}</a>',
            ),
            'DueDate' => array(
                'title' => 'Fälligkeit',
                'casting' => 'SS_DateTime->DE_Time'
            ),
            'Comment.Summary' => array(
                'title' => 'Auszug'
            ),
            'AssignName' => array(
                'title' => 'Zuweisung',
            )
        );
    }
    public function sourceRecords($params = null) {
        /* @var DataList */
        $data = Reminder::get();
        return $data;
    }

}