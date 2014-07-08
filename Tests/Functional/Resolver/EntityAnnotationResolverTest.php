<?php

/**
 * This file is part of the ControllerExtraBundle for Symfony2.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Mmoreram\ControllerExtraBundle\Tests\Functional\Resolver;

use Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Factory\FakeFactory;
use Mmoreram\ControllerExtraBundle\Tests\Functional\AbstractWebTestCase;

/**
 * Class EntityAnnotationResolverTest
 */
class EntityAnnotationResolverTest extends AbstractWebTestCase
{
    /**
     * testAnnotation
     */
    public function testAnnotation()
    {
        $this
            ->client
            ->request(
                'GET',
                '/fake/entity'
            );
    }

    /**
     * Test fake mapping
     */
    public function testMappingAnnotation()
    {
        $fake = FakeFactory::createStatic();
        $fake->setField('');
        $entityManager = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManagerForClass('Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Entity\Fake');

        $entityManager->persist($fake);
        $entityManager->flush();

        $this
            ->client
            ->request(
                'GET',
                '/fake/entity/mapped/1'
            );

        $this->assertEquals(
            '{"id":1}',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );
    }

    /**
     * Test fake mapping
     */
    public function testMappingManyAnnotation()
    {
        $fake = FakeFactory::createStatic();
        $fake->setField('value');
        $entityManager = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManagerForClass('Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Entity\Fake');

        $entityManager->persist($fake);
        $entityManager->flush();

        $this
            ->client
            ->request(
                'GET',
                '/fake/entity/mapped/many/1'
            );

        $this->assertEquals(
            '{"id":1}',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );
    }

    /**
     * Test fake mapping
     *
     * @expectedException \Mmoreram\ControllerExtraBundle\Exceptions\EntityNotFoundException
     */
    public function testMappingManyFailAnnotation()
    {
        $fake = FakeFactory::createStatic();
        $fake->setField('value2');
        $entityManager = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManagerForClass('Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Entity\Fake');

        $entityManager->persist($fake);
        $entityManager->flush();

        $this
            ->client
            ->request(
                'GET',
                '/fake/entity/mapped/many/1'
            );

        $this->assertEquals(
            '{"id":1}',
            $this
                ->client
                ->getResponse()
                ->getContent()
        );
    }
}
