<?php


namespace App\Service;


use App\Controller\ServiceController;
use App\Entity\ExchangeRate;

class SaveCurrencyService extends ServiceController
{
    public function saveCurrency($date, $content)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $currency = new ExchangeRate();
        $currency->setDateCurrency($date);
        $currency->setContent($content);

        $entityManager->persist($currency);
        $entityManager->flush();
    }
}