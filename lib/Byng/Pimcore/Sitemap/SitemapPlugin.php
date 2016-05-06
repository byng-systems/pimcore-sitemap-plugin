<?php

namespace Byng\Pimcore\Sitemap;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Model\Schedule\Manager\Procedural as ProceduralScheduleManager;
use Pimcore\Model\Schedule\Maintenance\Job as MaintenanceJob;
use Byng\Pimcore\Sitemap\Generator\SitemapGenerator;

class SitemapPlugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface {

    const MAINTENANCE_JOB_GENERATE_SITEMAP = 'create-sitemap';

    public function init() {

        parent::init();

        \Pimcore::getEventManager()->attach("system.maintenance", function ($event) {
            /** @var ProceduralScheduleManager $target */
            $target = $event->getTarget();
            
            $target->registerJob(
                new MaintenanceJob(
                    self::MAINTENANCE_JOB_GENERATE_SITEMAP,
                    new SitemapGenerator(),
                    "generateXml"
                )
            );
        });

    }

    public function handleDocument ($event) {
        // do something
        $document = $event->getTarget();
    }

	public static function install (){
        // implement your own logic here
        return true;
	}
	
	public static function uninstall (){
        // implement your own logic here
        return true;
	}

	public static function isInstalled () {
        // implement your own logic here
        return true;
	}
}
