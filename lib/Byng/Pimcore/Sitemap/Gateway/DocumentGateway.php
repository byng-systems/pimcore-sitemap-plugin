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
     * Returns all of the root documents that have parent id '1', and don't have the sitemap exclude
     * property.
     *
     * @return array
     */
    public function getRootDocuments()
    {
        $list = new Document\Listing();
        $list->setOrderKey("index");
        $list->setOrder("ASC");
        $list->setCondition("
            type = 'page'
            AND parentId = 1
            AND id NOT IN (
                SELECT 
                    cid 
                FROM 
                    properties 
                WHERE 
                    ctype='document' 
                AND 
                    name='sitemap_exclude' 
                AND data = 1
            )
        ");

        return $list->load();
    }

    /**
     * Get child documents of a given document
     *
     * @param Document $rootDocument
     * @return array
     */
    public function getChildDocs(Document $rootDocument)
    {
        $condition = "
            parentId = ? 
            AND type = 'page' 
            AND id NOT IN (
                SELECT 
                    cid 
                FROM 
                    properties 
                WHERE 
                    ctype = 'document' 
                AND 
                    name = 'sitemap_exclude' 
                AND 
                    data = 1
            )
        ";

        $list = new Document\Listing();
        $list->setCondition($condition, [
            $rootDocument->getId()
        ]);

        return $list->load();
    }
}
