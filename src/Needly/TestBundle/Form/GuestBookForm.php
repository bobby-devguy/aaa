<?php

namespace Needly\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GuestBookForm extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'name', 'text' );
		$builder->add ( 'comment', 'textarea' );
		$builder->add ( 'email', 'email' );
		$builder->add ( 'created_at', 'date' );
		$builder->add('save', 'submit');
		
	}
	public function getName() {
		return 'entry';
	}
}
