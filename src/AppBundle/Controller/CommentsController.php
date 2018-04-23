<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 14/04/18
 * Time: 22:13
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comments;
use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @property  securityContext
 * @Route("/comments")
 */
class CommentsController extends Controller
{

    /**
     * Show comments
     * @Route("/", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $userName = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
            if($userName == 'admin'){
                $comments = $em->getRepository('AppBundle:Comments')->findAll();
            }
            else {
                $comments = $em->getRepository('AppBundle:Comments')->getCommentsByUser($userId);
            }
        }
        $categories = $em->getRepository('AppBundle:Category')->findAll();


        return $this->render('comments/index.html.twig', array(
            'comments' => $comments,
            'categories' => $categories,
        ));
    }

    /**
     * Show comments of the article
     *
     * @Route("/articleComments/{id}", name="article_id")
     * @param Article $article
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Method({"GET","PUT"})
     */
    public function showComments(Article $article, Request $request){
        $em = $this->getDoctrine()->getManager();

        $newComment = new Comments();
        $form = $this->createForm('AppBundle\Form\CommentsType', $newComment, array(
            'method' => 'get'
        ));
        $form->handleRequest($request);
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $userName = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        }
        if($form->isSubmitted()){
            $newComment->setArticleId($article->getId());
            $newComment->setUserId($userId);
            $newComment->setUsername($userName);
            $newComment->setContent($newComment->getContent());
            $em->persist($newComment);
            $em->flush();

            return $this->redirectToRoute('article_id', array('id' => $article->getId()));

        }

        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->getDisplayableCategories();

        $comments = $em->getRepository('AppBundle:Comments')->getComments($article);

        return $this->render('comments/articleComments.html.twig', [
            'categories' => $category,
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     * @param Comments $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comments/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="comment_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Comments $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('AppBundle\Form\CommentsType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $comment->getId()));
        }
        return $this->render('comments/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Comments $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Comments $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comments $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comments $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}