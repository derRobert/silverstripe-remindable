<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 24.02.2015
 * Time: 20:11
 */

class Remindable extends DataExtension {


    public function Reminders() {
        return Reminder::get()->filter(array(
            'RefClass' => $this->owner->ClassName,
            'RefID' => $this->owner->ID
        ));
    }

    public function updateCMSFields( FieldList $fieldList ) {
        $grid = GridField::Create('Reminders', 'Reminder', $this->owner->Reminders());
        $grid->setConfig(GridFieldConfig_RelationEditor::create());
        $detailForm = $grid->getConfig()->getComponentByType('GridFieldDetailForm');
        $fields = singleton('Reminder')->getCMSFields();
        $fields->replaceField('RefClass', HiddenField::create('RefClass', 'RefClass', $this->owner->ClassName));
        $fields->replaceField('RefID', HiddenField::create('RefID', 'RefID', $this->owner->ID));
        $detailForm->setFields( $fields );
        $fieldList->addFieldToTab('Root.Reminder', $grid);
    }


}