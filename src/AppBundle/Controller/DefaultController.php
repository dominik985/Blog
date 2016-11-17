<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        $repo = $this->getDoctrine()->getRepository('AppBundle:Post');
        
        $query = $repo->createQueryBuilder('p')
                ->setMaxResults(30)
                ->getQuery();
        
        $posts = $query->getResult();
        
        
        return $this->render('default/index.html.twig', array('posts'=> $posts));
    }
}
