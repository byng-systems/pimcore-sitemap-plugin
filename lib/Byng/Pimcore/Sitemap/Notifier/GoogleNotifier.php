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

namespace Byng\Pimcore\Sitemap\Notifier;

use Pimcore\Config;

/**
 * Google Notifier
 *
 * @author Ioannis Giakoumidis <ioannis@byng.co>
 */
final class GoogleNotifier implements SitemapNotifierInterface
{
    /**
     * {@inheritdoc}
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
