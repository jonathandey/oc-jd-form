<?php namespace JD\Forms\Components;

use Str;
use File;
use Backend\Behaviors\FormController;
use Cms\Classes\ComponentBase;
use JD\Forms\Classes\AbstractFormController;

class Form extends ComponentBase
{
    public $view;

    public $context;

    private $model;

    private $formController;

    public function componentDetails()
    {
        return [
            'name'        => 'Form Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            "definition" => [
                "name" => "Form Definition",
            ],
            "form_context" => [
                "name" => "Form Context",
                "default" => "create"
            ],
            "model_id" => [
                "name" => "Model ID",
                "default" => null
            ],
            "model_class" => [
                "name" => "Model Class"
            ]
        ];
    }

    public function init()
    {
        $this->context = $this->property('form_context', FormController::CONTEXT_CREATE);

        $modelClass = $this->property("model_class");
        $fieldsDefinition = $this->property("definition", null);

        if (is_null($fieldsDefinition)) {
            $fieldsDefinition = $this->autoResolveFields($modelClass);
        }

        $this->formController = new AbstractFormController($modelClass, $fieldsDefinition);

        $this->model = new $modelClass;
        if ($modelId = $this->property("model_id", null)) {
            $this->model = $modelClass::findOrFail($modelId);
        }

        $this->formController->asExtension("FormController")
            ->initForm($this->model, $this->context)
        ;
    }

    public function render()
    {
        return $this->formController->asExtension("FormController")->formRender();
    }

    public function onSave()
    {
        $formMethod = $this->context . "_onSave";

        if (method_exists($this->formController->asExtension("FormController"), $formMethod)) {
            $params = [$this->context];

            if (! is_null($this->model->getKey())) {
                array_unshift($params, $this->model->getKey());
            }

            call_user_func_array([$this->formController->asExtension("FormController"), $formMethod], $params);
        }

        return redirect()->refresh();
    }

    private function autoResolveFields($modelClass)
    {
        $path = "$";

        $path .= preg_replace(
            "$\\\\$",
            "/",
            Str::lower(
                Str::normalizeClassName($modelClass)
            )
        );

        $frontEndFieldsSuffix = "_frontend.yaml";

        if (File::isFile($path . "/fields$frontEndFieldsSuffix")) {
            return $path .= "/fields$frontEndFieldsSuffix";
        }

        return $path .= "/fields.yaml";
    }
}
