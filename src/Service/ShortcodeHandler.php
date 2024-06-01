<?php

namespace App\Service;

use App\Service\FetchService;
use App\Service\CheckString;
use App\Service\ShortcodesFactory;

use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class ShortcodeHandler
{
    private $templating;
    private $fetchService;
    private $filesystem;
    private $checkString;
    private $shortcodesFactory;

    public function __construct(Environment $templating, FetchService $fetchService, Filesystem $filesystem, CheckString $checkString, ShortcodesFactory $shortcodesFactory)
    {
        $this->templating = $templating;
        $this->fetchService = $fetchService;
        $this->filesystem = $filesystem;
        $this->checkString = $checkString;
        $this->shortcodesFactory = $shortcodesFactory;
    }

    public function processContent(string $content): string
    {
        $open = $_ENV["SHORTCODE_START_REGEXP"];
        $close = $_ENV["SHORTCODE_END_REGEXP"];
        $pattern = "/{$open}(\w+)(.*?){$close}/";

        return preg_replace_callback($pattern, [$this, 'replaceShortcode'], $content);
    }

    private function replaceShortcode(array $matches): string
    {
        if ($matches) {
            $shortcodeName = $matches[1];
            $shortcodeParams = $matches[2];
    
            if ($shortcodeName) {
                $templatePath = "shortcodes/{$shortcodeName}/{$shortcodeName}.twig";
    
                $shortcodeTwigTemplatePath = __DIR__ . "/../../templates/{$templatePath}";
                if ($this->filesystem->exists($shortcodeTwigTemplatePath)) {
                    $shortcodeContent = $shortcodeParams;
    
                    $attributesPattern = $shortcodeParams;
    
                    $attributesPattern = '/\s*(\w+)="([^"]*)"/';
    
                    preg_match_all($attributesPattern, $shortcodeContent, $attributesMatches, PREG_SET_ORDER);
    
                    $attributes = [];
                    foreach ($attributesMatches as $match) {
                        $paramName = $match[1];
                        $paramValue = $match[2];
    
                        if ($paramName === 'code' && $this->checkString->isLink($paramValue)) {
                            $paramValue = $this->fetchService->fetchContentFromUrl($paramValue);
                        }
    
                        $attributes[$paramName] = $paramValue;
                    }
    
                    $shortcodeNameFirstLetterUppercase = ucfirst($shortcodeName);
                    $shortcodeServicePath = __DIR__ . "/Shortcodes/{$shortcodeNameFirstLetterUppercase}.php";
                    if ($this->filesystem->exists($shortcodeServicePath)) {
                        $shortcodeService = $this->shortcodesFactory->get($shortcodeNameFirstLetterUppercase);
                        $data = $shortcodeService->getData();
                        $attributes['data'] = $data;
                    }
    
                    $output = $this->templating->render($templatePath, $attributes);
                    return $output;
                }
            }
        }
        else {
            return '';
        }
    }
}