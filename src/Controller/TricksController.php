<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Video;
use App\Entity\Tricks;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Entity\Category;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     */
    public function getTricks(): Response
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findBy(array(), array('id' => 'desc'), 6, 0);

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
     * @Route("/tricks/loadMore/{start}", name="loadMore", requirements={"start": "\d+"})
     */
    public function loadMore($start = 6)
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findBy(array(), array('id' => 'desc'), 6, $start);

        foreach ($tricks as $key => $value) {
            $id = $value->getCategory();
            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->find($id);
            $value->catName = $category->getName();
        }

        return $this->render('tricks/loadMore.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/tricks/count", name="count")
     */
    public function getTricksCount()
    {
        $tricks = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findAll();
        return new JsonResponse($tricks);
    }

    /**
     * @Route("/trick/new", name="add")
     */
    public function addTrick(Request $request)
    {
        $user = $request->getSession()->get('user');
        if (!$user) {
            return $this->redirectToRoute('tricks');
        }
        $trick = new Tricks();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre trick a bien été créé !');

            $url = null;
            $url2 = null;
            $url3 = null;
            if (isset($_POST["url1"])) {
                $url = filter_input(INPUT_POST, 'url1');
                //$url = $_POST["url1"];
            }
            if (isset($_POST["url2"])) {
                $url2 = filter_input(INPUT_POST, 'url2');
                //$url2 = $_POST["url2"];
            }
            if (isset($_POST["url3"])) {
                $url3 = filter_input(INPUT_POST, 'url3');
                //$url3 = $_POST["url3"];
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
                $urlvideo = filter_input(INPUT_POST, 'urlvideo1');
                //$urlvideo = $_POST["urlvideo1"];
            }
            if (isset($_POST["urlvideo2"])) {
                $urlvideo2 = filter_input(INPUT_POST, 'urlvideo2');
                //$urlvideo2 = $_POST["urlvideo2"];
            }
            if (isset($_POST["urlvideo3"])) {
                $urlvideo3 = filter_input(INPUT_POST, 'urlvideo3');
                //$urlvideo3 = $_POST["urlvideo3"];
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
            $name = $trick->getName();
            $trick->setUrlPath($name);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trick);
            $entityManager->flush();
            return $this->redirectToRoute('tricks');
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
        $user = $request->getSession()->get('user');
        if (!$user) {
            return $this->redirectToRoute('tricks');
        }
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
            $this->addFlash('success', 'Votre trick a bien été modifié !');
            $trick = $form->getData();

            if (filter_input(INPUT_POST, 'url1')) {
                $url = filter_input(INPUT_POST, 'url1');
                //$url = $_POST["url1"];
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
                // $entityManager->flush();
            }
            if (filter_input(INPUT_POST, 'url2')) {
                $url2 = filter_input(INPUT_POST, 'url2');
                //$url2 = $_POST["url2"];
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
                // $entityManager->flush();
            }
            if (filter_input(INPUT_POST, 'url3')) {
                $url3 = filter_input(INPUT_POST, 'url3');
                //$url3 = $_POST["url3"];
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
                //  $entityManager->flush();
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


            if (filter_input(INPUT_POST, 'urlvideo1')) {
                $urlvideo = filter_input(INPUT_POST, 'urlvideo1');
                //$urlvideo = $_POST["urlvideo1"];
                if (count($videos) > 0) {
                    $videos[0]->setUrl($urlvideo);
                    //    $entityManager->persist($videos[0]);
                } else {
                    $video1 = new Video();
                    $video1->setUrl($urlvideo);
                    if ($urlvideo != "") {
                        $trick->addVideo($video1);
                    }
                }
                // $entityManager->flush();
            }
            if (filter_input(INPUT_POST, 'urlvideo2')) {
                $urlvideo2 = filter_input(INPUT_POST, 'urlvideo2');
                //$urlvideo2 = $_POST["urlvideo2"];
                if (count($videos) > 1) {
                    $videos[1]->setUrl($urlvideo2);
                    //  $entityManager->persist($videos[1]);
                } else {
                    $video2 = new Video();
                    $video2->setUrl($urlvideo2);
                    if ($urlvideo2 != "") {
                        $trick->addVideo($video2);
                    }
                }
                // $entityManager->flush();
            }
            if (filter_input(INPUT_POST, 'urlvideo3')) {
                $urlvideo3 = filter_input(INPUT_POST, 'urlvideo3');
                //$urlvideo3 = $_POST["urlvideo3"];
                if (count($videos) > 2) {
                    $videos[2]->setUrl($urlvideo3);
                    //  $entityManager->persist($videos[2]);
                } else {
                    $video3 = new Video();
                    $video3->setUrl($urlvideo3);
                    if ($urlvideo3 != "") {
                        $trick->addVideo($video3);
                    }
                }
                //  $entityManager->flush();
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
            // $entityManager->persist($trick);
            $entityManager->flush();
            return $this->redirectToRoute('tricks');
        }
        return $this->render('tricks/update.html.twig', [
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
        $user = $request->getSession()->get('user');
        if (!$user) {
            return $this->redirectToRoute('tricks');
        }
        $id = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $trick = $entityManager->getRepository(Tricks::class)->find($id);
        $entityManager->remove($trick);
        $entityManager->flush();
        $this->addFlash('success', 'Le trick a bien été supprimé !');
        return $this->redirectToRoute('tricks');
    }

    /**
     * @Route("/trick/{url_path}", name="trick")
     */
    public function getTrick(Request $request, UserRepository $userRepository, $url_path)
    {
        $session = $request->getSession();
        $userLogged = $session->get('user');
        $id = $request->query->get('id');
        $trick = $this->getDoctrine()
            ->getRepository(Tricks::class)
            ->findOneBy(array('url_path' => $url_path));

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($trick->getCategory());

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('id_trick' => $trick->getId()), array('created_at' => 'desc'));

        $photos = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findBy(array('trick' => $trick->getId()));

        $videos = $this->getDoctrine()
            ->getRepository(Video::class)
            ->findBy(array('trick' => $trick->getId()));

        if (filter_input(INPUT_POST, 'valider_com')) {
            $user = $userRepository->find($userLogged->getId());
            $content = filter_input(INPUT_POST, 'content');
            //$content = htmlspecialchars($_POST['content']);
            $comment = new Comment();
            $comment->setUser($user);
            $comment->setContent($content);
            $comment->setIdTrick($trick->getId());
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
}
