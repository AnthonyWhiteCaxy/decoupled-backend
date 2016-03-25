<?php

namespace Caxy\AppBundle\EventListener;

use Doctrine\Common\Persistence\ManagerRegistry;
use FOS\OAuthServerBundle\Event\OAuthEvent;

class OAuthEventListener
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        $user = $this->getUser($event);

        if ($user) {
            $event->setAuthorizedClient(
                $user->isAuthorizedClient($event->getClient())
            );
        }
    }

    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        if ($event->isAuthorizedClient()) {
            if (null !== $client = $event->getClient()) {
                $user = $this->getUser($event);
                $user->addClient($client);
                $this->registry->getManagerForClass("AppBundle:User")->persist($user);
            }
        }
    }

    protected function getUser(OAuthEvent $event)
    {
        return $this->registry
                    ->getRepository("AppBundle:User")
                    ->findOneByUsername($event->getUser()->getUsername());
    }
}
