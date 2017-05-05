<?php

namespace AppBundle\AdsProvider;

interface AdsProviderInterface
{
    public function getNewAds();

    public function getHtml($url);

    public function saveImages($imageUrl, $providerName, $id);

    public function saveToModel($accessor, $car);
}
