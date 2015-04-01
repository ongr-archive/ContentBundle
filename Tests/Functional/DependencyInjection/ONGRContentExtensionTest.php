<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Functional\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Exception\LogicException;

class ONGRContentExtensionTest extends WebTestCase
{
    /**
     * @return array
     */
    public function getParametersData()
    {
        $out = [];

        $out[] = ['ongr_content.snippet.render_strategy', 'string', true, 'newValue'];

        return $out;
    }

    /**
     * Tests if parameters are being set.
     *
     * @param string $name
     * @param string $type
     *
     * @dataProvider getParametersData
     */
    public function testParameters($name, $type)
    {
        $container = self::createClient()->getContainer();

        $this->assertTrue($container->hasParameter($name), "Parameter '{$name}' is not set");

        switch ($type) {
            case 'int':
                $this->assertTrue(
                    is_int($container->getParameter($name)),
                    "Parameter {$name} should be integer."
                );
                break;
            default:
                $this->assertTrue(
                    is_string($container->getParameter($name)),
                    "Parameter {$name} should be string by default."
                );
                break;
        }
    }

    /**
     * Tests if exception is being thrown by overwriting values.
     *
     * @param string $name
     * @param bool   $overwrite
     * @param mixed  $overwriteValue
     *
     * @dataProvider getParametersData
     *
     * @expectedException LogicException
     */
    public function testParametersOverwrite($name, $overwrite, $overwriteValue)
    {
        $container = self::createClient()->getContainer();

        if ($overwrite && $container->hasParameter($name)) {
            $container->setParameter($name, $overwriteValue);
        }
    }

    /**
     * Data provider for testServices().
     *
     * @return array
     */
    public function getTestServicesData()
    {
        return [
            ['twig.extension.stringloader', 'Twig_Extension_StringLoader'],
            ['ongr_content.twig.content_extension', 'ONGR\ContentBundle\Twig\ContentExtension'],
            ['ongr_content.content_service', 'ONGR\ContentBundle\Service\ContentService'],
            ['ongr_content.category_service', 'ONGR\ContentBundle\Service\CategoryService'],
            ['ongr_content.twig.category_extension', 'ONGR\ContentBundle\Twig\CategoryExtension'],
        ];
    }

    /**
     * Tests if services are being created.
     *
     * @param string $id       Service id.
     * @param string $instance Service instance class name.
     *
     * @dataProvider getTestServicesData
     */
    public function testServices($id, $instance)
    {
        $container = self::createClient()->getContainer();

        $this->assertTrue($container->has($id));
        $this->assertInstanceOf($instance, $container->get($id));
    }
}
