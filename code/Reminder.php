<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 24.02.2015
 * Time: 20:04
 */

class Reminder extends DataObject {

    private static $db = array(
        'RefClass' => 'Varchar',
        'RefID' => 'Int',
        'Name' => 'Varchar',
        'DueDate' => 'SS_DateTime',
        'Comment' => 'Text',
        'Assignment' => "Enum('Member,Group','Member')"
    );

    private static $has_one = array(
        'Assignee' => 'Member',
        'AssignGroup' => 'Group',
    );

    public function getCMSFields() {
        $f = parent::getCMSFields();
        $f->dataFieldByName('AssigneeID')->displayIf('Assignment')->isEqualTo('Member')->end();
        $f->dataFieldByName('AssignGroupID')->displayIf('Assignment')->isEqualTo('Group')->end();
        return $f;
    }


    public function SummaryForRss($format='html') {
        return implode( ($format=='html'?"<br>":"\n"), array($this->Comment, ($format=='html'?"<hr>":"-----------")."Zuständig: ".$this->AssignName) );
    }

    public function getAssignName() {
        switch( $this->Assignment ) {
            case "Member":
                return $this->Assignee()->Surname;
            case "Group";
                return $this->AssignGroup()->Title;
        }
    }

    public function Link() {
        if( is_subclass_of($this->RefClass, 'SiteTree') ) {
            return singleton('CMSMain')->LinkPageEdit( $this->RefID );
        }
        $link = '#no-link';
        try {
            $link = DataObject::get_by_id($this->RefClass, $this->RefID)->AdminLink();
        }catch(Exception $e) {}
        return $link;
    }

    /** wird für Report benötigt **/
    public function getLink() {
        return $this->Link();
    }

    public function getSubject() {
        return sprintf("[%s:%s] %s", $this->RefClass, $this->RefID, $this->Name);
    }


    public function onBeforeWrite() {
        if( $this->Assignment == 'Member' ) $this->AssignGroupID=0;
        if( $this->Assignment == 'Group' )  $this->AssigneeID=0;
        parent::onBeforeWrite();
    }


}
