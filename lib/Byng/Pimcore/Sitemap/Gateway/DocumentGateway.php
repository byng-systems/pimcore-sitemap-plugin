<?php


namespace Byng\Pimcore\Sitemap\Gateway;

use Pimcore\Model\Document;

/**
 * Class DocumentGateway
 *
 * @package PimcoreSitemapPlugin\Gateway
 */
final class DocumentGateway
{

    /**
     * This function returns all the root documents
     * which have parent id = 1 and they don't have the
     * sitemap exclude property
     *
     * @return array
     */
    public function getRootDocuments()
    {
        $list = new Document\Listing();
        $list->setOrderKey('index');
        $list->setOrder('ASC');
        $list->setCondition(
            "type = 'page'
             AND parentId = 1
             AND id NOT IN (SELECT cid FROM properties WHERE ctype='document' AND name='sitemap_exclude' AND data=1)
            "
        );
        
        return $list->load();
    }

    /**
     * @param Document $rootDocument
     *
     * @return array
     */
    public function getChildDocs(Document $rootDocument)
    {
        $list = new Document\Listing();
        $list->setCondition(
            "parentId = ? AND type = 'page' AND id NOT IN (SELECT cid FROM properties WHERE ctype='document' AND name='sitemap_exclude' AND data=1)",
            [
                $rootDocument->getId()
            ]
        );

        return $list->load();
    }

}