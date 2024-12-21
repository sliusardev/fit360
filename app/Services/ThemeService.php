<?php

namespace App\Services;

use Storage;

class ThemeService
{
    const THEME_PATH = 'themes';
    const DEFAULT_THEME = 'default';

    const THEMES_CONFIG_FOLDER = 'conf';

    private array $templatesDirectories;

    public function __construct()
    {
        $this->templatesDirectories = Storage::disk('views')->directories(self::THEME_PATH);
    }

    public static function templateRecoursePath(): string
    {
        return SettingService::value('theme') ?? self::DEFAULT_THEME;
    }

    public static function themeView(string $bladeName, array $params = [])
    {
        if (empty(self::templateRecoursePath())) {
            return redirect('welcome');
        }

        return view(self::templateRecoursePath() .'/'.$bladeName, $params);
    }

    public static function themeSettings(string $templateName): array
    {
        if(empty($templateName)) {
            return [];
        }

        return include resource_path(
            'views/' . $templateName . '/' . self::THEMES_CONFIG_FOLDER . '/settings.php'
        ) ?? [];
    }

    public static function getThemeFunctions(string $templateName)
    {
        if(empty($templateName)) {
            return null;
        }
        return include resource_path(
            'views/' . $templateName . '/' . self::THEMES_CONFIG_FOLDER . '/functions.php'
        );
    }

    public function getAllTemplatesSettings(): array
    {
        $templates = [];

        foreach ($this->templatesDirectories as $template) {
            $templates[$template] = self::themeSettings($template);
        }

        return $templates;
    }

    public function getAllTemplatesNames(): array
    {
        $templates = [];

        foreach ($this->templatesDirectories as $template) {
            $file = $this->getAllTemplatesSettings();

            if(!empty($file[$template]['name'])) {
                $templates[$template] = $file[$template]['name'];
            } else {
                $templates[$template] = $template;
            }
        }

        return $templates;
    }

    public function getCurrentTemplatePageNames(): array
    {
        $templateName = SettingService::value('theme');
        $pagePaths = Storage::disk('templates')->files($templateName.'/pages');
        $templates = [];
        foreach ($pagePaths as $item) {
            $itemArr = explode('/', $item);
            $last = end($itemArr);
            $result = str_replace('.blade.php','',$last);
            $templates[$result] = $result;
        }

        return $templates;
    }
}
