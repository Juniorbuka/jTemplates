<?php

use Illuminate\Support\Facades\Event;

Event::listen('evolution.OnDocFormTemplateRender', static function (array $params): string {
    global $content;

    $document = isset($content) && is_array($content) ? $content : [];

    return jTemplates::getInstance($document, $params)->renderTemplate();
});

Event::listen('evolution.OnDocFormRender', static function (array $params): string {
    global $content;

    $document = isset($content) && is_array($content) ? $content : [];

    return jTemplates::getInstance($document, $params)->renderAfterTemplate();
});

Event::listen('evolution.OnDocFormSave', static function (array $params): void {
    (new jTemplates([], $params))->OnDocFormSave(
        (int) ($params['id'] ?? 0),
        (string) ($params['mode'] ?? '')
    );
});

Event::listen('evolution.OnTempFormRender', static function (array $params): string {
    return (new jTemplatesBuilder($params))->renderTemplate();
});

Event::listen('evolution.OnTempFormSave', static function (array $params): void {
    (new jTemplatesBuilder($params))->saveTemplate();
});

Event::listen('evolution.OnTempFormDelete', static function (array $params): void {
    (new jTemplatesBuilder($params))->deleteTemplate((int) ($params['id'] ?? 0));
});
