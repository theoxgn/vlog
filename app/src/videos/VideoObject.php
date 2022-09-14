<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxSetField;

class VideoObject extends DataObject {

    private static $db = [
        'Tittle' => 'Text',
        'Description' => 'Text'
    ];

    private static $has_one = [
        'VideoSource' => File::class,
        'VideoPage' => VideoPage::class,
        'VideoThumbnail' => Image::class
    ];

    private static $many_many = [
        'Categories' => VideoCategory::class
    ];
    
    private static $owns = [
        'VideoSource',
        'VideoThumbnail'
    ];

    public function getCMSFields(){
        return new FieldList(
            TextField::create('Tittle'),
            TextareaField::create('Description'),
            UploadField::create('VideoSource'),
            UploadField::create('VideoThumbnail'),
            CheckboxSetField::create('Categories', 'Categories', VideoCategory::get())
        );
    }
    
}