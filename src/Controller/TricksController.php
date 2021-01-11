<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Tricks;
use App\Entity\Comment;
use App\Entity\Category;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     */
    public function getTricks(): Response
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findAll();

        foreach ($tricks as $key => $value) {
            $id = $value->getCategory();
            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->find($id);
            $value->catName = $category->getName();
        }

        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/trick", name="trick")
     */
    public function getTrick(Request $request, UserRepository $userRepository)
    {
        $id = $request->query->get('id');
        $trick = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->find($id);

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($trick->getCategory());

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('id_trick' => $id), array('created_at' => 'desc'));

        $session = $request->getSession();
        $userLogged = $session->get('user');



        if (isset($_POST["valider_com"])) {
            $user = $userRepository->find($userLogged->getId());
            $content = htmlspecialchars($_POST['content']);
            $comment = new Comment();
            $comment->setUser($user);
            $comment->setContent($content);
            $comment->setIdTrick($id);
            $now = new \DateTime();
            $now->setTimezone(new \DateTimeZone('Europe/Paris'));
            $comment->setCreatedAt($now);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirect($request->getUri());
        }


        return $this->render('tricks/trick.html.twig', [
            'trick' => $trick,
            'category' => $category->getName(), 'comments' => $comments
        ]);
    }
}
