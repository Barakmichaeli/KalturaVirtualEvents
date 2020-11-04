<?php

namespace App;

/**
 * Class Kaltura
 * @package App
 * @property \Kaltura\Client\Client $client
 */
class Kaltura {
    
    private $client;
    
    private function getClient () {
        if (null === $this->client) {
            $this->initClient();
        }
        return $this->client;
    }
    
    private function initClient () {
        $config = new \Kaltura\Client\Configuration();
        $config->setCurlTimeout(10);
        $client = new \Kaltura\Client\Client($config);
        $ks = $client->getSessionService()->start(
            config('constants.KALTURA_SECRET'),
            config('constants.KALTURA_USER_ID'),
            \Kaltura\Client\Enum\SessionType::ADMIN,
            config('constants.KALTURA_PARTNER_ID')
        );
        $client->setKS($ks);
        $this->client = $client;
    }
    
    public function searchLatestEntry ($keyword) {
        $filter = new \Kaltura\Client\Type\MediaEntryFilter();
        $filter->orderBy = \Kaltura\Client\Enum\MediaEntryOrderBy::CREATED_AT_DESC;
        $filter->freeText = $keyword;
        $resultObject = $this->getClient()->getMediaService()->listAction($filter);
        return $this->formatKalturaObjects($resultObject->objects);
    }
    
    public function getLatestEntries () {
        $filter = new \Kaltura\Client\Type\MediaEntryFilter();
        $filter->orderBy = \Kaltura\Client\Enum\MediaEntryOrderBy::CREATED_AT_DESC;
        $pager = new \Kaltura\Client\Type\FilterPager();
        $resultObject = $this->getClient()->getMediaService()->listAction($filter, $pager);
        return $this->formatKalturaObjects($resultObject->objects);
    }
    
    private function formatKalturaObjects (array $entriesObjects) {
        $entries = [];
        foreach ($entriesObjects as $idx => $entry) {
            $entries[] = [
                'id' => $idx + 1,
                'name' => $entry->name,
                'watch_url' => $entry->dataUrl,
                'thumbnail_url' => $entry->thumbnailUrl,
                'entry_id' => $entry->rootEntryId,
                'duration' => $this->getDurationMinutes($entry->duration), //seconds => minutes
                'created' => date("d/m/Y H:i", $entry->createdAt), //seconds => minutes
            ];
        }
        return $entries;
    }
    
    private function getDurationMinutes ($seconds) {
        return sprintf( "%02.2d:%02.2d", floor( $seconds / 60 ), $seconds % 60 );
    }
}