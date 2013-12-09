<?php

namespace Needly\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Needly\TestBundle\Form\GuestBookForm;
use Needly\TestBundle\Entity\GuestBookEntry;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller {
	public function showAction(Request $request) {
		$guest_book = $this->get ( 'guest_book' );
		$entries = $guest_book->getEntries ();
		
		return $this->render ( 'NeedlyTestBundle:Default:index.html.twig', array (
				'entries' => $entries 
		) );
	}
	public function addEntryAction(Request $request) {
		$form = $this->createForm ( new GuestBookForm () );
		$method = $this->get ( 'request' )->getMethod ();
		
		if ($method == 'POST') {
			
			$form->handleRequest ( $request );
			
			if ($form->isValid ()) {
				$entry = new GuestBookEntry ();
				$data = $form->getData ();
				
				$entry->setName ( $data ['name'] );
				$entry->setComment ( $data ['comment'] );
				$entry->setEmail ( $data ['email'] );
				$entry->setCreatedAt ( $data ['created_at'] );
				
				$validator = $this->get ( 'validator' );
				$errors = $validator->validate ( $entry );
				
				if (count ( $errors ) > 0) {
					/*
					 * Uses a __toString method on the $errors variable which is a ConstraintViolationList object. This gives us a nice string for debugging
					 */
					$errorsString = ( string ) $errors;
					
					return $this->render ( 'NeedlyTestBundle:Default:add.html.twig', array (
							'form' => $form->createView (), 'error' => $errorsString 
					) );
				}
				
				$em = $this->getDoctrine ()->getManager ();
				$em->persist ( $entry );
				$em->flush ();
				return new Response ( 'Created guestbook entry ' . $entry->getId () );
			} else {
				return new Response ( 'Not valid' );
			}
		} 

		else {
			return $this->render ( 'NeedlyTestBundle:Default:add.html.twig', array (
					'form' => $form->createView () 
			) );
		}
	}
}
