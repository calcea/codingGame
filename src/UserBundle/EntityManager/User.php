<?php

namespace UserBundle\EntityManager;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FrameworkExtensionBundle\Filesystem\UploadManager;
use UserBundle\Entity\User as UserEntity;


class User implements EventSubscriber
{
    /**
     * @var UploadManager
     */
    protected $uploadManager;

    /**
     * User constructor.
     * @param UploadManager $uploadManager
     */
    public function __construct($uploadManager)
    {
        $this->uploadManager = $uploadManager;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
       return array('postRemove');
    }

    /**
     * Post remove event.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getObject();

        if($user instanceof UserEntity){
            $this->uploadManager->removeDocument($user,'getOldAvatarUrl');
        }
    }
}