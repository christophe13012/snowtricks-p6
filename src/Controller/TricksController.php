<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tricks;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Photo;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     */
    public function getTricks(): Response
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findBy(array(), array('id' => 'desc'));

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

        $photos = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('trick' => $id));

        $videos = $this->getDoctrine()
            ->getRepository(Video::class)
            ->findBy(array('trick' => $id));

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
            'category' => $category->getName(), 'comments' => $comments, 'videos' => $videos, 'photos' => $photos
        ]);
    }
    /**
     * @Route("/trick/new", name="add")
     */
    public function addTrick(Request $request)
    {
        $trick = new Tricks();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = null;
            $url2 = null;
            $url3 = null;
            if (isset($_POST["url1"])) {
                $url = $_POST["url1"];
            }
            if (isset($_POST["url2"])) {
                $url2 = $_POST["url2"];
            }
            if (isset($_POST["url3"])) {
                $url3 = $_POST["url3"];
            }
            $photo = new Photo();
            $photo->setUrl($url);
            if ($url != "") {
                $trick->addPhoto($photo);
            }
            $photo2 = new Photo();
            $photo2->setUrl($url2);
            if ($url2 != "") {
                $trick->addPhoto($photo2);
            }
            $photo3 = new Photo();
            $photo3->setUrl($url3);
            if ($url3 != "") {
                $trick->addPhoto($photo3);
            }

            $urlvideo = null;
            $urlvideo2 = null;
            $urlvideo3 = null;
            if (isset($_POST["urlvideo1"])) {
                $urlvideo = $_POST["urlvideo1"];
            }
            if (isset($_POST["urlvideo2"])) {
                $urlvideo2 = $_POST["urlvideo2"];
            }
            if (isset($_POST["urlvideo3"])) {
                $urlvideo3 = $_POST["urlvideo3"];
            }
            $video = new Video();
            $video->setUrl($urlvideo);
            if ($urlvideo != "") {
                $trick->addVideo($video);
            }
            $video2 = new Video();
            $video2->setUrl($urlvideo2);
            if ($urlvideo2 != "") {
                $trick->addVideo($video2);
            }
            $video3 = new Video();
            $video3->setUrl($urlvideo3);
            if ($urlvideo3 != "") {
                $trick->addVideo($video3);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trick);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('tricks/add.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/update", name="update")
     */
    public function updateTrick(Request $request)
    {
        $categoriesData = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $categories = array();

        foreach ($categoriesData as $key => $value) {
            $categories[$value->getName()] = $value->getId();
        }

        $id = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $trick = $entityManager->getRepository(Tricks::class)->find($id);
        $photos = $entityManager->getRepository(Photo::class)->findBy(array('trick' => $trick), array('id' => 'asc'));
        $videos = $entityManager->getRepository(Video::class)->findBy(array('trick' => $trick), array('id' => 'asc'));
        $form = $this->createForm(TrickType::class, $trick, [
            'categories' => $categories
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            if (isset($_POST["url1"])) {
                $url = $_POST["url1"];
                if (count($photos) > 0) {
                    $photos[0]->setUrl($url);
                    $entityManager->persist($photos[0]);
                } else {
                    $photo1 = new Photo();
                    $photo1->setUrl($url);
                    if ($url != "") {
                        $trick->addPhoto($photo1);
                    }
                }
                $entityManager->flush();
            }
            if (isset($_POST["url2"])) {
                $url2 = $_POST["url2"];
                if (count($photos) > 1) {
                    $photos[1]->setUrl($url2);
                    $entityManager->persist($photos[1]);
                } else {
                    $photo2 = new Photo();
                    $photo2->setUrl($url2);
                    if ($url2 != "") {
                        $trick->addPhoto($photo2);
                    }
                }
                $entityManager->flush();
            }
            if (isset($_POST["url3"])) {
                $url3 = $_POST["url3"];
                if (count($photos) > 2) {
                    $photos[2]->setUrl($url3);
                    $entityManager->persist($photos[2]);
                } else {
                    $photo3 = new Photo();
                    $photo3->setUrl($url3);
                    if ($url3 != "") {
                        $trick->addPhoto($photo3);
                    }
                }
                $entityManager->flush();
            }
            if (count($photos) == 1 && $url == "") {
                $trick->removePhoto($photos[0]);
            }
            if (count($photos) == 2 && $url2 == "") {
                $trick->removePhoto($photos[1]);
            }
            if (count($photos) == 3 && $url3 == "") {
                $trick->removePhoto($photos[2]);
            }


            if (isset($_POST["urlvideo1"])) {
                $urlvideo = $_POST["urlvideo1"];
                if (count($videos) > 0) {
                    $videos[0]->setUrl($urlvideo);
                    $entityManager->persist($videos[0]);
                } else {
                    $video1 = new Video();
                    $video1->setUrl($urlvideo);
                    if ($urlvideo != "") {
                        $trick->addVideo($video1);
                    }
                }
                $entityManager->flush();
            }
            if (isset($_POST["urlvideo2"])) {
                $urlvideo2 = $_POST["urlvideo2"];
                if (count($videos) > 1) {
                    $videos[1]->setUrl($urlvideo2);
                    $entityManager->persist($videos[1]);
                } else {
                    $video2 = new Video();
                    $video2->setUrl($urlvideo2);
                    if ($urlvideo2 != "") {
                        $trick->addVideo($video2);
                    }
                }
                $entityManager->flush();
            }
            if (isset($_POST["urlvideo3"])) {
                $urlvideo3 = $_POST["urlvideo3"];
                if (count($videos) > 2) {
                    $videos[2]->setUrl($urlvideo3);
                    $entityManager->persist($videos[2]);
                } else {
                    $video3 = new Video();
                    $video3->setUrl($urlvideo3);
                    if ($urlvideo3 != "") {
                        $trick->addVideo($video3);
                    }
                }
                $entityManager->flush();
            }
            if (count($videos) == 1 && $urlvideo == "") {
                $trick->removeVideo($videos[0]);
            }
            if (count($videos) == 2 && $urlvideo2 == "") {
                $trick->removeVideo($videos[1]);
            }
            if (count($videos) == 3 && $urlvideo3 == "") {
                $trick->removeVideo($videos[2]);
            }
            $entityManager->persist($trick);
            $entityManager->flush();
            return $this->redirectToRoute('tricks');
        }
        return $this->render('tricks/update.html.twig', [
            'trick' => $trick,
            'photos' => $photos,
            'videos' => $videos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/delete", name="delete")
     */
    public function deleteTrick(Request $request)
    {
        $id = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $trick = $entityManager->getRepository(Tricks::class)->find($id);
        $entityManager->remove($trick);
        $entityManager->flush();
        return $this->redirectToRoute('tricks');
    }
}
