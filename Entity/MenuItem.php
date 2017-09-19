<?php

namespace MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItem
 *
 * @ORM\Table(name="menu_item")
 * @ORM\Entity
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="default_region")
 */
class MenuItem
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=191, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=191, nullable=true)
     */
    private $target;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_custom_url", type="boolean", nullable=true)
     */
    private $useCustomUrl = false;

    /**
     * @var string
     *
     * @ORM\Column(name="route_name", type="string", length=191, nullable=true)
     */
    private $routeName;

    /**
     * @var string
     *
     * @ORM\Column(name="route_parameters", type="string", options={"collation"="utf8_general_ci"}, length=600, nullable=true)
     */
    private $routeParameters;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=191, nullable=true)
     */
    private $url;

    /**
     * @var \MenuBundle\Entity\MenuItem
     *
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="default_region")
     * @ORM\ManyToOne(targetEntity="\MenuBundle\Entity\MenuItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $parent;

    /**
     * @var \MenuBundle\Entity\Menu
     *
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="default_region")
     * @ORM\ManyToOne(targetEntity="\MenuBundle\Entity\Menu", inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $menu;

    /**
     * @return string
     */
    function __toString()
    {
        return $this->name ? $this->name : '';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MenuItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return MenuItem
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get parent
     *
     * @return \MenuBundle\Entity\MenuItem
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent
     *
     * @param \MenuBundle\Entity\MenuItem $parent
     *
     * @return MenuItem
     */
    public function setParent(\MenuBundle\Entity\MenuItem $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \MenuBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set menu
     *
     * @param \MenuBundle\Entity\Menu $menu
     *
     * @return MenuItem
     */
    public function setMenu(\MenuBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set target
     *
     * @param string $target
     *
     * @return MenuItem
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return MenuItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set routeName
     *
     * @param string $routeName
     *
     * @return MenuItem
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }


    /**
     * Get useCustomUrl
     *
     * @return boolean
     */
    public function getUseCustomUrl()
    {
        return $this->useCustomUrl;
    }

    /**
     * Set useCustomUrl
     *
     * @param boolean $useCustomUrl
     *
     * @return MenuItem
     */
    public function setUseCustomUrl($useCustomUrl)
    {
        $this->useCustomUrl = $useCustomUrl;

        return $this;
    }

    /**
     * Set routeParameters
     *
     * @param string $routeParameters
     *
     * @return MenuItem
     */
    public function setRouteParameters($routeParameters)
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    /**
     * Get routeParameters
     *
     * @return string
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }
}
