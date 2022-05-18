<?php

namespace App\Tests\Entity;

use App\Entity\Event;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $event = (new Event())
         ->setTitle('coucou')
         ->setContent('coucou')
         ->setContent2('coucou')
         ->setLinkVideo('coucou')
         ->setLinkSound('coucou')
         ->setPicture1('coucou')
         ->setPicture2('coucou')
         ->setPicture3('coucou')
        //  ->setTime(04/00/45)
         ->setAge('coucou')
         ->setTechnique1('coucou')
         ->setTechnique2('coucou')
         ->setTechnique3('coucou')
         ->setBonus1('coucou')
         ->setBonus2('coucou');
        self::bootKernel();
       $error = self::$container->get('validator')->validate($event);
       $this->assertCount(0, $error);
    }
}
