<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Service\CheckString;
use App\Service\FetchService;

use Symfony\Contracts\Cache\CacheInterface;

class PageUpdateFromSheetController extends AbstractController
{
    private $checkString;
    private $fetchService;

    public function __construct(CheckString $checkString, FetchService $fetchService)
    {
        $this->checkString = $checkString;
        $this->fetchService = $fetchService;
    }

    #[Route('/cms-sheets/page-update', name:'cms-sheets_page-update')]
    public function pageUpdateFromSheet(Request $request, EntityManagerInterface $entityManager, PageRepository $pageRepository, CacheInterface $pageCache): Response
    {
        $headerToken = $request->headers->get('Authorization');
        $expectedToken = 'Bearer ' . $_ENV["APP_GOOGLE_APP_SCRIPTS_TOKEN"];
    
        if ($headerToken !== $expectedToken) {
            return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        } else {
            $data = json_decode($request->getContent(), true);

            $sheetRowData = $data['sheetRowData'];

            $id_cms = $sheetRowData['id'];
            $name = $sheetRowData['name'];
            $url = $sheetRowData['url'];
            $template = $sheetRowData['template'];
            $title = $sheetRowData['title'];
            $description = $sheetRowData['description'];
            $off = $sheetRowData['off'];

            $content = $sheetRowData['content'];

            if ($this->checkString->isLink($content)) {
                $content = $this->fetchService->fetchContentFromUrl($content);
            } 

            $existsPage = $pageRepository->findPage($id_cms);

            if ($existsPage) {
                $page = $existsPage;
            } else {
                $page = new Page();
                $page->setIdCms($id_cms);
            }

            $page->setName($name);
            $page->setUrl($url);
            $page->setTemplate($template);
            $page->setTitle($title);
            $page->setDescription($description);
            $page->setContent($content);
            $page->setOff($off);

            $entityManager->persist($page);
            $entityManager->flush();

            $cacheKey = $url;
            $pageCache->delete($cacheKey);
            
            return new Response('success', Response::HTTP_OK);
        }
    }
}