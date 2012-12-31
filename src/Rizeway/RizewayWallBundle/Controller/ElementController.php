<?php

namespace Rizeway\RizewayWallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Rizeway\RizewayWallBundle\Entity\Element;
use Rizeway\RizewayWallBundle\Form\Type\ElementType;
use Rizeway\RizewayWallBundle\Utils\Grid;

class ElementController extends Controller
{
    
    public function listAction()
    {
        $elements = $this->getDoctrine()->getRepository('RizewayWallBundle:Element')
                ->findBy(array('approved' => 1));
        $grid = new Grid($elements);

        return $this->render('RizewayWallBundle:Element:list.html.twig',
            array(
                'grid'  => $grid->render($this->get('templating')),
                'width' => $grid->getWidth()
            ));
    }
    
    public function addAction()
    {
        $element = new Element();
        $form = $this->createForm(new ElementType(), $element);
        $view = 'RizewayWallBundle:Element:add.html.twig';
        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($element);
                $em->flush();

                //$this->sendNotification($element);
                $this->get('session')->setFlash('info', 'Votre article a été ajouté avec succès, il sera validé dans les plus brefs délais');

                return $this->redirect($this->generateUrl('_welcome'));
            }

            $view = 'RizewayWallBundle:Element:add_post.html.twig';
        }

        return $this->render($view, array('form' => $form->createView()));
    }
    
    public function writeAction()
    {
        $element = new Element();
        $form = $this->createForm(new ElementType(), $element, array('write' => true));
        $view = 'RizewayWallBundle:Element:write.html.twig';
        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($element);
                $em->flush();

                //$this->sendNotification($element);
                $this->get('session')->setFlash('info', 'Votre article a été ajouté avec succès, il sera validé dans les plus brefs délais');

                return $this->redirect($this->generateUrl('_welcome'));
            }

            $view = 'RizewayWallBundle:Element:write_post.html.twig';
        }

        return $this->render($view, array('form' => $form->createView()));
    }

    public function showAction($id)
    {
        $element = $this->getDoctrine()->getRepository('RizewayWallBundle:Element')
            ->find($id);
        
        return $this->render('RizewayWallBundle:Element:details.html.twig', array('element' => $element));
    }


    public function sendNotification(Element $element)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('DZBlogDay Wall')
            ->setFrom('contact@dzblogday.com')
            ->setTo('contact@rizeway.com')
            ->setBody('Un nouvel article a été proposé : '.$element->getTitle())
        ;
        $this->get('mailer')->send($message);
    }
    
}
