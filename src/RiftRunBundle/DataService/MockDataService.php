<?php

namespace RiftRunBundle\DataService;

use RiftRunBundle\Model\Wizard;

class MockDataService implements DataServiceInterface
{
    public function getData()
    {
        $wizard = new Wizard();
        $wizardB = new Wizard();

        $wizard->setId(1);
        $wizard->setParagonPoints(600);
        $wizardB->setId(2);
        $wizardB->setParagonPoints(200);

        return [$wizard, $wizardB];
    }

    public function getSingleData()
    {
        $wizard = new Wizard();
        $wizard->setId(2);
        $wizard->setParagonPoints(300);

        return $wizard;
    }
}
