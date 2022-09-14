<?php

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextAreaField;
use SilverStripe\Forms\FormAction;

class VideoPageController extends PageController {

	private static $allowed_actions = [
		'CommentForm'
	];

	public function CommentForm()
	{
		$form = Form::create(
			$this,
            'CommentForm',
			FieldList::create(
				TextField::create('Name'),
				TextAreaField::create('Comment')
			),
			FieldList::create(
				FormAction::create('HandleForm', 'Submit Comment')
			)
		);

		return $form;
	}

	public function HandleForm($data, $form)
	{
		$comment = VideoComment::create();
		$comment->VideoPageID = $this->ID;
		$form->saveInto($comment);
		$comment->write();

		return $this->redirectBack();
	}
}