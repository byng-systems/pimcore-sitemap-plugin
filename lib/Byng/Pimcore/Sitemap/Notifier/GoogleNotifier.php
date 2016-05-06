<?php


namespace Byng\Pimcore\Sitemap\Notifier;

use Pimcore\Config;
use Byng\Pimcore\Sitemap\Notifier\Service\SitemapNotifierInterface;

/**
 * Class GoogleNotifier
 *
 * @package PimcoreSitemapPlugin\Notifier
 */
class GoogleNotifier implements SitemapNotifierInterface
{
    /**
     * Notify Google for new sitemap
     *
     * @return bool
     */
    public function notify()
    {
        $ch = curl_init(
            sprintf(
                "http://www.google.com/webmasters/sitemaps/ping?sitemap=%s/sitemap.xml",
                Config::getSystemConfig()->get("general")->get("domain")
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode >= 200 && $httpcode < 300){
            return true;
        } else {
            return false;
        }
    }

}