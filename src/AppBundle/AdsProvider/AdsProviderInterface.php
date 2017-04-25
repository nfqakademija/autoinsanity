<?php

namespace AppBundle\AdsProvider;


interface AdsProviderInterface
{
    public function getNewAds();

    public function saveToDb($cars);

    public function getHtml($url);

    public function saveImages($imageUrl);
}