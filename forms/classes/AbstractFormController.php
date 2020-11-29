<?php

namespace JD\Forms\Classes;

use Backend\Behaviors\FormController;
use Backend\Classes\Controller;

class AbstractFormController extends Controller {

    public $implement = [
        FormController::class,
    ];

    public $formConfig = '';

    public function __construct($modelClass, $fieldsDefinition)
    {
        $this->formConfig = [
            'modelClass' => $modelClass,
            'form' => $fieldsDefinition
        ];

        parent::__construct();
    }


}
