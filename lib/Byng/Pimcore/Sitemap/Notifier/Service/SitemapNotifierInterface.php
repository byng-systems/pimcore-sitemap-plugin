<?php

namespace Byng\Pimcore\Sitemap\Notifier\Service;

/**
 * Interface SitemapNotifierInterface
 *
 * @package PimcoreSitemapPlugin\Notifier\Service
 */
interface SitemapNotifierInterface
{
    /**
     * @return bool
     */
    public function notify();
}