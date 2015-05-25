<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use RiftRunBundle\Model\Wizard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WizardsController extends Controller
{
    /**
     * @return array
     * @View()
     * @Get("/wizards")
     */
    public function indexAction()
    {
        $wizard = new Wizard();
        $wizardB = new Wizard();

        return (['wizards' => [$wizard, $wizardB]]);
    }
}
