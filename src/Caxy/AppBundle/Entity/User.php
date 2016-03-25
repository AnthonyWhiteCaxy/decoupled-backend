<?php

namespace Caxy\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User.
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Client", inversedBy="users")
     * @ORM\JoinTable(name="user_clients")
     */
    private $clients;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
    }

    /**
     * Get Id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Clients.
     *
     * @return ArrayCollection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Add Client.
     *
     * @param Client $client
     *
     * @return User
     */
    public function addClient(Client $client)
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
        }

        return $this;
    }

    /**
     * Remove Client.
     *
     * @param Client $client
     *
     * @return User
     */
    public function removeClient(Client $client)
    {
        $this->clients->removeElement($client);

        return $this;
    }

    /**
     * Check if Client is Authorized
     *
     * @param Client $client
     *
     * @return bool
     */
    public function isAuthorizedClient(Client $client)
    {
        return $this->clients->contains($client);
    }
}
