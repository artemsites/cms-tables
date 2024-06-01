<?php
namespace App\Service\Shortcodes;

use App\Repository\PageRepository;



class Articles implements ShortcodesInterface
{
    private $pageRepository;
    
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }
    
    public function getData(): ?array
    {
        $url = parse_url($_SERVER['REQUEST_URI'])['path'];
        $res = $this->pageRepository->getLinksWithNamesOfParentUrl($url);
        return $res;
    }
}