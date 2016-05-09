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

namespace Byng\Pimcore\Sitemap\Gateway;

use Pimcore\Model\Document;

/**
 * Document Gateway
 *
 * @author Ioannis Giakoumidis <ioannis@byng.co>
 */
final class DocumentGateway
{
    /**
     * Returns all the children of the parent with the
     * given id
     *
     * @param int $parentId
     * @return array
     */
    public function getChildren($parentId)
    {
        $list = new Document\Listing();
        $list->setOrderKey("index");
        $list->setOrder("ASC");
        $list->setCondition(
            "parentId = ? ",
            $parentId
        );

        return $list->load();
    }
}
