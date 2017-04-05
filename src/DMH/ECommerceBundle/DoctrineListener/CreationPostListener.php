<?php

namespace DMH\ECommerceBundle\DoctrineListener;

use DMH\ECommerceBundle\Entity\Creation;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CreationPostListener{

    public function __construct()
    {
    }
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $isInstanceOfUniverse= $entity instanceof Creation;
        if ( $isInstanceOfUniverse != true) {
            return;
        }
        /* @var Creation $entity */
        $entity->setPreviewDir();
        $entity->getPreview()->upload();
    }
}