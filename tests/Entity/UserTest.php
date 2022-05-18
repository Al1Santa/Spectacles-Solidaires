<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $user = (new User())
        ->setEmail('admin@admin.com')
        ->setPassword('admin')
        ->setFirstname('alain')
        ->setLastname('santa')
        ->setAvatar('avatar');

        self::bootKernel();
       $error = self::$container->get('validator')->validate($user);
       $this->assertCount(0, $error);
    }
}
