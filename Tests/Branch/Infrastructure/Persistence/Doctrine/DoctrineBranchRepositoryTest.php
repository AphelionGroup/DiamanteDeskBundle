<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Eltrino\DiamanteDeskBundle\Tests\Branch\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\LockMode;
use Eltrino\DiamanteDeskBundle\Entity\Branch;
use Eltrino\DiamanteDeskBundle\Branch\Model\Logo;
use Eltrino\DiamanteDeskBundle\Branch\Infrastructure\Persistence\Doctrine\DoctrineBranchRepository;
use Eltrino\PHPUnit\MockAnnotations\MockAnnotations;

class DoctrineBranchRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_CLASS_NAME = 'DUMMY_CLASS_NAME';
    /**
     * @var DoctrineBranchRepository
     */
    private $repository;

    /**
     * @var \Doctrine\ORM\EntityManager
     * @Mock \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     * @Mock \Doctrine\ORM\Mapping\ClassMetadata
     */
    private $classMetadata;

    protected function setUp()
    {
        MockAnnotations::init($this);
        $this->classMetadata->name = self::DUMMY_CLASS_NAME;
        $this->repository = new DoctrineBranchRepository($this->em, $this->classMetadata);
    }

    public function testGet()
    {
        $branchId = 1;
        $branch = $this->getBranch();
        $this->em
            ->expects($this->once())
            ->method('find')
            ->with(
                $this->equalTo(self::DUMMY_CLASS_NAME), $this->equalTo($branchId),
                $this->equalTo(LockMode::NONE), $this->equalTo(null))
            ->will($this->returnValue($branch));

        $retrievedBranch = $this->repository->find($branchId);

        $this->assertNotNull($retrievedBranch);
        $this->assertEquals($branch, $retrievedBranch);
    }

    public function testStore()
    {
        $branch = $this->getBranch();
        $this->em->expects($this->once())->method('persist')->with($this->equalTo($branch));
        $this->em->expects($this->once())->method('flush');

        $this->repository->store($branch);
    }

    public function testRemove()
    {
        $branch = $this->getBranch();
        $this->em->expects($this->once())->method('remove')->with($this->equalTo($branch));
        $this->em->expects($this->once())->method('flush');

        $this->repository->remove($branch);
    }

    private function getBranch()
    {
        return new Branch('DUMMY_NAME', 'DUMMY_DESC', new Logo('dummy'));
    }
} 