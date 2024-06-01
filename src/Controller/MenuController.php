<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\MenuRepository;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
class MenuController extends AbstractController
{
    #[Route('/cms-sheets/menu', methods: ['GET'], name: 'cms-sheets_menu')]
    public function menuRoute(MenuRepository $menuRepository, CacheInterface $menuCache): Response 
    {
        $cacheKey = 'menu';

        $menuJson = $menuCache->get($cacheKey, function (ItemInterface $item) use ($menuRepository) {
            // $item->expiresAfter(0);
            $item->expiresAfter(365 * 24 * 60 * 60);

            $menu = $menuRepository->getMenu();
            return json_encode($menu, JSON_UNESCAPED_UNICODE);
        });

        $response = new Response($menuJson, 200);
        // $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
        return $response;
    }
}