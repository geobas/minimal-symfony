<?php

namespace Custom\CMSBundle\MyService;

class PagesSrv
{
	/**
	 * Instance of entity manager
	 *
	 * @var doctrine.orm.entity_manager
	 */
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Get all pages
     *
     * @return Page[]
     */
	public function fetchOnePage()
	{
		$pages = $this->em->getRepository('CustomCMSBundle:Page')->findAll();

		return array_shift($pages);
	}
}