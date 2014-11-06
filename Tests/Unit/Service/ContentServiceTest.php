<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Tests\Unit\Service;

use ONGR\ContentBundle\Service\ContentService;
use ONGR\ElasticsearchBundle\DSL\Query\TermQuery;

class ContentServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if method getDocumentBySlug does what is expected.
     */
    public function testGetDocumentBySlug()
    {
        $searchMock = $this->getMock('ElasticsearchBundle\DSL\Search', ['addQuery']);
        $searchMock
            ->expects($this->once())
            ->method('addQuery')
            ->with(
                new TermQuery('slug', 'foo'),
                'must'
            );

        $repositoryMock = $this
            ->getMockBuilder('ElasticsearchBundle\ORM\Repository')
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createSearch'])
            ->getMock();

        $repositoryMock
            ->expects($this->once())
            ->method('createSearch')
            ->will($this->returnValue($searchMock));

        $repositoryMock
            ->expects($this->once())
            ->method('execute')
            ->with()
            ->will($this->returnValue(new \ArrayIterator(['first', 'second'])));

        $service = new ContentService($repositoryMock);

        $result = $service->getDocumentBySlug('foo');
        $this->assertEquals('first', $result, 'Expected first result.');
    }

    /**
     * Tests if method getDocumentBySlug is logging when no documents found.
     */
    public function testGetDocumentBySlugLogger()
    {
        $searchMock = $this->getMock('ElasticsearchBundle\DSL\Search', ['addQuery']);
        $searchMock
            ->expects($this->once())
            ->method('addQuery')
            ->with(
                $this->isInstanceOf('ONGR\ElasticsearchBundle\DSL\Query\TermQuery'),
                'must'
            );

        $repositoryMock = $this
            ->getMockBuilder('ElasticsearchBundle\ORM\Repository')
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'createSearch'])
            ->getMock();

        $repositoryMock
            ->expects($this->once())
            ->method('createSearch')
            ->will($this->returnValue($searchMock));

        $repositoryMock
            ->expects($this->once())
            ->method('execute')
            ->with()
            ->will($this->returnValue(new \ArrayIterator([])));

        $loggerMock = $this->getMock('Psr\\Log\\LoggerInterface');
        $loggerMock
            ->expects($this->once())
            ->method('warning')
            ->with('Can not render snippet for \'foo\' because content was not found.');

        $service = new ContentService($repositoryMock);
        $service->setLogger($loggerMock);

        $this->assertNull($service->getDocumentBySlug('foo'), 'Result expected to be null.');
    }
}
