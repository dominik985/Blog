<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
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
        
//   Displaying 30 posts with QueryBuilder
//        
//        $repo = $this->getDoctrine()->getRepository('AppBundle:Post');
//        
//        $query = $repo->createQueryBuilder('p')
//                ->setMaxResults(30)
//                ->getQuery();
//        
//        $posts = $query->getResult();
//        
//        
//        return $this->render('default/index.html.twig', array('posts'=> $posts));
        
        
        
//      Displaying post using knp_paginator
        
        $comments = new Post();
        $comments->getComments()->count();
        
        $repo = $this->getDoctrine()->getRepository('AppBundle:Post');
        
        $query = $repo->createQueryBuilder('p');
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        
        
        return $this->render('default/index.html.twig', array('posts' => $pagination, 'comments' => $comments));
                
        
    }
    
    /**
     * @Route("/post/{id}", name="show_post")
     */
    public function showAction(Post $post, Request $request)
    {   
        $form = null;
        
        //if user is loged in
        if ($user = $this->getUser()) {
            
            $comment = new Comment();
            $comment->setPost($post);
            $comment->setUser($user);
            
            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);
        
            if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            
            $this->addFlash('success', 'Komentarz został dodany');
            
            return $this->redirectToRoute('show_post', array('id' => $post->getId()));
            }
        }
        
        
        
        return $this->render('default/show.html.twig', array(
            'post' => $post,
            'form' => is_null($form) ? $form : $form->createView()
        ));
    }
}
