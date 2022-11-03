<?php

namespace BrandStudio\Translations\Http\Controllers;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use BrandStudio\Starter\Http\Controllers\DefaultCrudController;

use BrandStudio\Translations\Http\Requests\TranslationRequest;

class TranslationCrudController extends DefaultCrudController
{

    protected $class;
    protected $requestClass = TranslationRequest::class;

    public function __construct()
    {
        parent::__construct();

        $this->class = config('translations.translation_class');
    }


    public function setup()
    {
        parent::setup();

        CRUD::setEntityNameStrings(trans_choice('translations::admin.translations', 1), trans_choice('translations::admin.translations', 2));

        // CRUD::denyAccess(['create', 'delete', 'show']);
    }

    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::removeAllButtonsFromStack('line');

        CRUD::addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'value_ru',
                'label' => trans_choice('translations::admin.translations', 1) . '( ru )',
                'limit' => 3000,
                'view_namespace' => 'brandstudio::translations',
                'type' => 'translation',
                'lang' => 'ru',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('value->ru', 'like', '%'.$searchTerm.'%');
                },
            ],
            [
                'name' => 'value_en',
                'label' => trans_choice('translations::admin.translations', 1) . '( en )',
                'limit' => 3000,
                'view_namespace' => 'brandstudio::translations',
                'type' => 'translation',
                'lang' => 'en',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('value->en', 'like', '%'.$searchTerm.'%');
                },
            ],
            [
                'name' => 'value_kk',
                'label' => trans_choice('translations::admin.translations', 1) . '( kk )',
                'limit' => 3000,
                'view_namespace' => 'brandstudio::translations',
                'type' => 'translation',
                'lang' => 'kk',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('value->kk', 'like', '%'.$searchTerm.'%');
                },
            ],
        ]);

    }

    protected function setupCreateOperation()
    {
        parent::setupCreateOperation();

        CRUD::addField([
            'name' => 'value',
            'label' => trans_choice('translations::admin.translations', 1),
            'type' => 'textarea',
            'hint' => '<small>'.trans('translations::admin.translation_hint').'</small>',
        ]);
    }

    protected function setupUpdateOperation()
    {
        parent::setupUpdateOperation();

        CRUD::addField([
            'name' => 'value_ru',
            'label' => '',
            'type' => 'custom_html',
        ])->makeFirstField();
    }

}
