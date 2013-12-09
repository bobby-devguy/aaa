<?php

namespace Needly\TestBundle;

class GuestBook {
	
	protected $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function getEntries() {
		$entries = $this->em->getRepository ( 'NeedlyTestBundle:GuestBookEntry' )->findAll ();
		return $entries;
	}
}
