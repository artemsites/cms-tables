<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PageRepository;
use App\Service\MarkdownParserService;
use App\Service\ShortcodeHandler;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
class PageController extends AbstractController
{

    private $markdownParserService;
    private $shortcodeHandler;
    private $filesystem;

    public function __construct(MarkdownParserService $markdownParserService, ShortcodeHandler $shortcodeHandler, Filesystem $filesystem)
    {
        $this->markdownParserService = $markdownParserService;
        $this->shortcodeHandler = $shortcodeHandler;
        $this->filesystem = $filesystem;
    }
    
    #[Route('/{url}', methods: ['GET'], name: 'page', requirements: ["url"=>"^(?!cms-sheets).*"])]
    public function pageRoute(string $url, PageRepository $pageRepository, CacheInterface $pageCache): Response 
    {
        // !@note the match comes without the first slash, and in the database and cms the url with the first slash
        $url = '/'.$url;

        $cacheKey = $url;

        $pageContent = $pageCache->get($cacheKey, function (ItemInterface $item) use ($pageRepository, $url) {
            $item->expiresAfter(365 * 24 * 60 * 60);

            $page = $pageRepository->getPageByUrl($url);

            if ($page && $page['off'] !== "1") {
                $md = $page['content'];

                $contentHtml = $this->markdownParserService->toHtml($md);
                // var_dump($contentHtml);
                $contentHtml = $this->shortcodeHandler->processContent($contentHtml);

                $template = $page['template'];
                $templatePath = __DIR__ . "/../../templates/{$template}.twig";
                if (!$template || !$this->filesystem->exists($templatePath)) {
                    $template = 'default';
                }

                return $this->renderView("{$template}.twig", [
                    'title' => $page['title'],
                    'description' => $page['description'],
                    'contentHtml' => $contentHtml,
                    'createdAt' =>  $page['created_at']->format('d.m.Y'),
                    'updatedAt' =>  $page['updated_at']->format('d.m.Y'),
                ]);
            } else {
                // throw $this->createNotFoundException('The page does not exist');
                throw new NotFoundHttpException('The resource was not found.');
            }
        });

        $response = new Response($pageContent, 200);
        return $response;
    }
}