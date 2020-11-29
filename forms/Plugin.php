<?php namespace JD\Forms;

use Backend;
use JD\Forms\Components\Form;
use System\Classes\PluginBase;

/**
 * Forms Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'JD Forms',
            'description' => 'An OctoberCMS plugin that enables you to use backend forms on the front-end.',
            'author'      => 'JD',
            'icon'        => 'icon-list'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            Form::class => 'jdForm',
        ];
    }
}
