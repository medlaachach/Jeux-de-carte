<?php

namespace Contact\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Contact\Form\ContactForm;
//use Contact\Model\Contact;

class HttpError extends Zend\Mvc\Controller\AbstractActionController
{
    /*private $translator = null;
    
    public function translate($str)
    {
        if (!$this->translator)
        {
            $this->translator = $this->getServiceLocator()->get('translator');
        }
        return $this->translator->translate($str);
    }*/
    
    public function error404Action()
    {
        return new ViewModel(array('lang'=>$this->params()->fromRoute('lang')));
    }    
}
