# JD Form

An OctoberCMS plugin that enables you to use backend forms on the front-end.

This enables fast bootstrapping, form maintenance & helps prevent duplicate code.

## Example usage

```
title = "Form Demonstration"
url = "/form/:context/:id?"
layout = "default"

[jdForm]
model_id = "{{ :id }}"
form_context = "{{ :context }}"
model_class = "Author\Plugin\Models\Model"
==

<div class="container">
    {% component 'jdForm' %}
</div>

```

Then visit;
* https://mysite.example/form/create to create a new model record.
* https://mysite.example/form/update/1 to update a models record.

## Fields definition
You can define fields definition using the `definition` parameter for the `jdForm` component.

By default the plugin will look for a front-end fields file. It will look for a file called `fields_frontend.yaml` inside your models directory.
Otherwise it will use your `fields.yaml` file, the same one that is used on the backend.

## Including the functionality in your own component

You can add the JD Form component to your own component using the addComponent method
```
$this->controller->addComponent("jdForm", "jdForm", [
    "model_id" => 1,
    "form_context" => "update",
    "model_class" => "Author\Plugin\Models\Model"
])
```

## Override form field templates (untested)
_Borrowed from https://octobercms.com/plugin/luketowers-easyforms_

You can easily override any backend partial that would be rendered by the form & it's included widgets by replicating the desired partial under the `themes/$activeTheme/partials/$componentAlias` directory. If a match isn't found in that directory it will fall back by looking at the `themes/$activeTheme/partials/jdForm` directory.

In order for a given partial to be overridden, it must be copied under the above directory using the exact same (case-sensitive) application root relative path as where it exists normally. For instance, if you wanted to override the `/path/to/october/modules/backend/widgets/form/partials/_field_text.htm` partial, then you would need to create a file under `/path/to/october/themes/$activeTheme/partials/$widgetAlias/modules/backend/widgets/form/partials/_field_text.htm`.
