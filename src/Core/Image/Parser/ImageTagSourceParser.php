<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\PrestaShop\Core\Image\Parser;

/**
 * Class ImageTagPathParser parses "src" attribute of given image tag and prefixed it with shop's uri.
 *
 * This service helps retrieving image path from image tag generated by legacy ImageManager::thumbnail() method
 * so image can be displayed in new pages.
 */
final class ImageTagSourceParser implements ImageTagSourceParserInterface
{
    /**
     * @var string
     */
    private $shopRootUri;

    /**
     * @param string $shopRootUri
     */
    public function __construct($shopRootUri)
    {
        $this->shopRootUri = $shopRootUri;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($imageTag)
    {
        $replacement = 'src="/';
        $imageTag = preg_replace('/src="(\.\.\/|\.\/)+/', $replacement, $imageTag);

        if (null === $imageTag) {
            return null;
        }

        preg_match('/src="\/([^"]+)"/', $imageTag, $path);

        if (empty($path[1])) {
            return null;
        }

        return sprintf('/%s', $path[1]);
    }
}