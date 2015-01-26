<?php

namespace Kreait\FirebaseBundle\Tests\DependencyInjection;

use Kreait\FirebaseBundle\DependencyInjection\KreaitFirebaseExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KreaitFirebaseExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $container = new ContainerBuilder();
        $loader = new KreaitFirebaseExtension();
        $loader->load(array(), $container);
    }

    public function testMinimalValid()
    {
        $container = new ContainerBuilder();
        $loader = new KreaitFirebaseExtension();
        $loader->load(array(array('connections' => array('foo' => array('host' => 'bar')))), $container);
        $this->assertTrue($container->hasDefinition('kreait_firebase.connection.foo'));
    }

    public function testWithReference()
    {
        $container = new ContainerBuilder();
        $loader = new KreaitFirebaseExtension();
        $loader->load(array(array('connections' => array(
            'foo' => array(
                'host' => 'foohost',
                'references' => array(
                    'bar' => 'path/to/bar',
                    'bazz' => 'path/to/bazz'
                )
            )
        ))), $container);

        $this->assertTrue($container->hasDefinition('kreait_firebase.reference.bar'));
        $this->assertTrue($container->hasDefinition('kreait_firebase.reference.bazz'));
    }
}