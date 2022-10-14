<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController
{

    public function __construct(private readonly CacheInterface $cache)
    {
    }

    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        $val = $this->cache->get('test1', function(ItemInterface $item){
            $item->expiresAfter(10);

            if (!$item->isHit()) {
                $item->set(microtime(true));
            }

            return $item->get();
        });

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'val' => $val
        ]);
    }
}
