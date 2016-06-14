<?php

/**
 * This file is part of the pimcore-sitemap-plugin package.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Byng\Pimcore\Sitemap\Generator;

use Pimcore\Config;
use Pimcore\Model\Document;
use Byng\Pimcore\Sitemap\Gateway\DocumentGateway;
use Byng\Pimcore\Sitemap\Notifier\GoogleNotifier;
use SimpleXMLElement;

/**
 * Sitemap Generator
 *
 * @author Ioannis Giakoumidis <ioannis@byng.co>
 */
final class SitemapGenerator
{
    /**
     * @var string
     */
    private $hostUrl;

    /**
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * @var DocumentGateway
     */
    private $documentGateway;


    /**
     * SitemapGenerator constructor.
     */
    public function __construct()
    {
        $this->hostUrl = Config::getSystemConfig()->get("general")->get("domain");
        $this->documentGateway = new DocumentGateway();

        $this->xml = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?>'
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>'
        );
    }

    /**
     * Generates the sitemap.xml file
     *
     * @return void
     */
    public function generateXml()
    {
        // Get all the root elements with parentId '1'
        $rootDocuments = $this->documentGateway->getChildren(1);

        foreach ($rootDocuments as $rootDocument) {
            $this->addUrlChild($rootDocument);
            $this->listAllChildren($rootDocument);
        }
        $this->xml->asXML(PIMCORE_DOCUMENT_ROOT . "/sitemap.xml");

        if (Config::getSystemConfig()->get("general")->get("environment") === "production") {
            $this->notifySearchEngines();
        }
    }

    /**
     * Finds all the children of a document recursively
     *
     * @param Document $document
     * @return void
     */
    private function listAllChildren(Document $document)
    {
        $children = $this->documentGateway->getChildren($document->getId());

        foreach ($children as $child) {
            $this->addUrlChild($child);
            $this->listAllChildren($child);
        }
    }

    /**
     * Adds a url child in the xml file.
     *
     * @param Document $document
     * @return void
     */
    private function addUrlChild(Document $document)
    {
        if (
            $document instanceof Document\Page &&
            !$document->getProperty("sitemap_exclude")
        ) {
            echo $this->hostUrl . $document->getFullPath() . "\n";
            $url = $this->xml->addChild("url");
            $url->addChild('loc', $this->hostUrl . $document->getFullPath());
            $url->addChild('lastmod', $this->getDateFormat($document->getModificationDate()));
        }
    }

    /**
     * Format a given date.
     *
     * @param $date
     * @return string
     */
    private function getDateFormat($date)
    {
        return gmdate(DATE_ATOM, $date);
    }

    /**
     * Notify search engines about the sitemap update.
     *
     * @return void
     */
    private function notifySearchEngines()
    {
        $googleNotifier = new GoogleNotifier();

        if ($googleNotifier->notify()) {
            echo "Google has been notified \n";
        } else {
            echo "Google has not been notified \n";
        }
    }
}
