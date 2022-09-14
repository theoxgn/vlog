<?php

use SilverStripe\Control\HTTP;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Forms\FormAction;

class VideoSearchPageController extends PageController {

	private static $allowed_actions = [
		'VideoSearchForm'
	];

	public function index(HTTPRequest $request){
		$videos = VideoObject::get();
		$activeFilters = ArrayList::create();

		if($search = $request->getVar('Keywords')){
			$activeFilters->push(ArrayData::create([
				'Label' => 	"'$search'",
				'RemoveLink' => HTTP::setGetVAr('Keywords', null, null, '&')
			]));

			$videos = $videos->filter([
				'Tittle:PartialMatch' => $search
			]);
		}

		if($search = $request->getVar('Category')){
			$activeFilters->push(ArrayData::create([
				'Category' => VideoCategory::get()->filter(['ID' => $search])->first()->Tittle
			]));

			$videos = $videos->filter([
				'Categories.ID' => $search
			]);
		}

		$paginatedVideos = PaginatedList::create(
			$videos,
			$request
		)->setPageLength(5)->setPaginationGetVar('s');

		$data = [
			'Results' => $paginatedVideos,
			'ActiveFilters' => $activeFilters
		];


		return $data;
	}

	public function VideoSearchForm(){
		$form = Form::create(
			$this,
			'VideoSearchForm',
			FieldList::create(
				TextField::create('Keywords')
					->setAttribute('placeholder', 'Search for a video'),
				DropdownField::create('Category', 'Category', VideoCategory::get()->map('ID', 'Title'))
					->setEmptyString('Search in category')
			),
			FieldList::create(FormAction::create('doVideoSearch', 'Search'))

		);

		$form->setFormMethod('GET')
			 ->setFormAction($this->Link())
			 ->disableSecurityToken()
			 ->loadDataFrom($this->request->getVars());

		return $form;
	}
}
