<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $category = (new Category())
         ->setName('coucou');
        self::bootKernel();
       $error = self::$container->get('validator')->validate($category);
       $this->assertCount(0, $error);
    }
}
