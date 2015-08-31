<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 25.02.2015
 * Time: 10:30
 */

class RemindableController extends Controller {

    private static $allowed_actions = array(
        'rss'
    );

    function init() {
        parent::init();
        // Feed kann via URL mit Zugangsdaten abonniert werden
        // @Todo: SSL wichtig, wegen der Übergabe der Zugangsdaten
        $member = BasicAuth::requireLogin('Reminder');
        if($member instanceof Member) $member->logIn();
    }


    public function rss() {
        $rss = new RSSFeed(
            Reminder::get()->limit(30),
            $this->Link(),
            "Shop Todos",
            "Zeigt eine Liste aktueller Todos (max. 30)",
            "Subject",
            "SummaryForRss"
        );

        return $rss->outputToBrowser();
    }

}