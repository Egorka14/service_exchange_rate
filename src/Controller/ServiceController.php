<?php


namespace App\Controller;

use App\Repository\ExchangeRateRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\RedisAdapter;


class ServiceController extends AbstractController
{

    private $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    /**
     * @Route("/", name="currency_list")
     */
    public function list_currency()
    {
        $total = $this->redis('res');
        return $this->render('service.html.twig', ['res' => $total]);
    }

    /**
     * @Route("/api", name="api_currency_date", methods={"GET"})
     */
    public function getApi()
    {
        $total = $this->redis('api');
        return $this->json($total);
    }


    public function redis($key)
    {
        try
        {
            $client = RedisAdapter::createConnection(
                'redis://localhost'
            );

            $cache =  new RedisAdapter($client, $namespace = '', $defaultLifetime = 3600);

            $cachedRes =  $cache->getItem($key);
            $cache->clear();
            if ( !$cachedRes->isHit())  {
                $content = $this->exchangeRateRepository->getByCurrency();
                $cachedRes->set($content);
                $cache->save($cachedRes);
            }
            $total =  $cachedRes->get();
        }
        catch (\Exception $e) {
            $total = $this->exchangeRateRepository->getByCurrency();;
        }

        return $total;
    }
}