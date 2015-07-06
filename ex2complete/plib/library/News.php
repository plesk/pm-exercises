<?php

class Modules_PanelNews_News
{

    public static function load()
    {
        $xml = simplexml_load_file('http://www.parallels.com/products/plesk/rss');

        $lastItem = $xml->channel->item;

        pm_Settings::set('news_text', (string) $lastItem->title);
        pm_Settings::set('news_link', (string) $lastItem->link);
    }

}
