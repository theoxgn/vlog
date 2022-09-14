<?php

use SilverStripe\ORM\DataObject;

class VideoComment extends DataObject{

    private static $db = [
        'Name' => 'Varchar',
        'Comment' => 'Text'
    ];

    private static $has_one = [
        'VideoPage' => VideoPage::class
    ];
}