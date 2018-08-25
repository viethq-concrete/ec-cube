<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Tests\Repository;

use Eccube\Entity\Master\DeviceType;
use Eccube\Repository\Master\DeviceTypeRepository;
use Eccube\Repository\PageRepository;
use Eccube\Tests\EccubeTestCase;

class PageRepositoryTest extends EccubeTestCase
{
    /** @var DeviceType */
    protected $DeviceType;

    /** @var PageRepository */
    protected $pageRepo;

    protected $userDataRealDir;
    protected $templateRealDir;
    protected $templateDefaultRealDir;

    public function setUp()
    {
        parent::setUp();
        $this->pageRepo = $this->container->get(PageRepository::class);
        $this->DeviceType = $this->container->get(DeviceTypeRepository::class)->find(DeviceType::DEVICE_TYPE_PC);
        $this->userDataRealDir = $this->container->getParameter('eccube_theme_user_data_dir');
        $this->templateRealDir = $this->container->getParameter('eccube_theme_app_dir');
        $this->templateDefaultRealDir = $this->container->getParameter('eccube_theme_src_dir');
    }

    public function testGet()
    {
        $Page = $this->pageRepo->find(1);

        $this->expected = 1;
        $this->actual = $Page->getId();
        $this->verify();
        $this->assertNotNull($Page->getBlockPositions());
        foreach ($Page->getBlockPositions() as $BlockPosition) {
            $this->assertNotNull($BlockPosition->getBlock()->getId());
        }
    }

    public function testGetByUrl()
    {
        $Page = $this->pageRepo->getByUrl($this->DeviceType, 'homepage');

        $this->expected = 1;
        $this->actual = $Page->getId();
        $this->verify();
        $this->assertNotNull($Page->getBlockPositions());
        foreach ($Page->getBlockPositions() as $BlockPosition) {
            $this->assertNotNull($BlockPosition->getBlock()->getId());
        }
    }

    public function testGetPageList()
    {
        $Pages = $this->pageRepo->getPageList();
        $All = $this->pageRepo->findAll();

        $this->expected = count($All) - 2;
        $this->actual = count($Pages);
        $this->verify();
    }
}
