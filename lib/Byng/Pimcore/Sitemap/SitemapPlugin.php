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

namespace Byng\Pimcore\Sitemap;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Model\Schedule\Manager\Procedural as ProceduralScheduleManager;
use Pimcore\Model\Schedule\Maintenance\Job as MaintenanceJob;
use Byng\Pimcore\Sitemap\Generator\SitemapGenerator;

/**
 * Sitemap Plugin
 *
 * @author Ioannis Giakoumidis <ioannis@byng.co>
 */
class SitemapPlugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    const MAINTENANCE_JOB_GENERATE_SITEMAP = 'create-sitemap';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        \Pimcore::getEventManager()->attach("system.maintenance", function ($event) {
            /** @var ProceduralScheduleManager $target */
            $target = $event->getTarget();
            $target->registerJob(new MaintenanceJob(
                self::MAINTENANCE_JOB_GENERATE_SITEMAP,
                new SitemapGenerator(),
                "generateXml"
            ));
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function install()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function uninstall()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function isInstalled()
    {
        return true;
    }
}
