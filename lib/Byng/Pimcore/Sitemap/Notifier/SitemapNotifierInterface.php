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

/**
 * SitemapNotifier Interface
 *
 * @author Ioannis Giakoumidis <ioannis@byng.co>
 */
interface SitemapNotifierInterface
{
    /**
     * Notify something that the sitemap has been updated.
     *
     * @return bool
     */
    public function notify();
}
