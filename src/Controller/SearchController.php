<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PageRepository;

class SearchController extends AbstractController
{
    #[Route('/cms-sheets/search', methods: ['POST'], name: 'cms-sheets_search')]
    public function index(Request $request, PageRepository $pageRepository): Response
    {
        $strSearch = $request->getContent();
        $res = $pageRepository->getLinksWithNamesByTextInContent($strSearch);
        $response = new Response(json_encode($res, JSON_UNESCAPED_UNICODE), 200);
        // $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
        return $response;
    }
}