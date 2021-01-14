<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, UserRepository $repository): Response
    {
        $session = $request->getSession();
        $error = null;
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username =   filter_input(INPUT_POST, 'username');
            // htmlspecialchars($_POST['username']);
            $password = filter_input(INPUT_POST, 'password');
            //htmlspecialchars($_POST['password']);
            $user = $repository->findOneByUsername($username);
            if ($user) {
                $encoded = $user->getPassword();
                if (password_verify($password, $encoded)) {
                    $session->set('user', $user);
                    return $this->redirectToRoute('home');
                } else {
                    $error = "Identifiant ou mot de passe incorrect";
                }
            } else {
                $error = "Identifiant ou mot de passe incorrect";
            }
        }
        return $this->render('auth/login.html.twig', [
            'controller_name' => 'AuthController', 'error' => $error
        ]);
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPassword();
            $encoded = password_hash($plainPassword, PASSWORD_DEFAULT);
            $user->setPassword($encoded);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController', 'registrationForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        $session = $request->getSession();
        $session->remove('user');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/reset_password", name="reset_password")
     */
    public function reset_password(Request $request, UserRepository $repository)
    {
        $error = null;
        $reset = false;
        $success = false;
        if (filter_input(INPUT_POST, 'valider')) {
            $username = filter_input(INPUT_POST, 'username');
            // htmlspecialchars($_POST['username']);
            $user = $repository->findOneByUsername($username);
            if ($user) {
                $username = $user->getUsername();
                $email = $user->getEmail();
                $token = md5($email) . rand(10, 9999);
                $expDate = new \DateTime();
                $expDate->setTimezone(new \DateTimeZone('Europe/Paris'));
                $expDate->add(new \DateInterval('P1D'));
                $link = "<a href='http://snowtricks.test/reset_password?key=" . $username . "&amp;token=" . $token . "'>merci de cliquer sur ce lien pour changer votre mot de passe</a>";
                $user->setResetLinkToken($token);
                $user->setExpDate($expDate);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $body = '<!DOCTYPE html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Réinitialiser mot de passe</title>
                </head>
                    <body>
                        <p>
                            Bonjour <b>{username}</b>, 
                            {link}
                        </p>
                        <p>
                            A bientôt !
                        </p>
                    </body>
                </html>';
                $body = preg_replace("~{username}~i", $username, $body);
                $body = preg_replace("~{link}~i", $link, $body);
                $transport = (new Swift_SmtpTransport('smtp.orange.fr', 25))
                    ->setUsername('christophe.caillet2@orange.fr')
                    ->setPassword('Lizouliz13');
                $mailer = new Swift_Mailer($transport);
                $message = (new Swift_Message("Réinitialisation mot de passe"))
                    ->setFrom(['christophe.caillet2@orange.fr' => 'Christophe Caillet'])
                    ->setTo([$email])
                    ->setBody($body, 'text/html', 'utf-8');
                $mailer->send($message);
                $this->addFlash('success', 'Merci de vérifier votre mail et cliquer sur le lien !');
            } else {
                $error = "Utilisateur inconnu";
            }
        } else if (filter_input(INPUT_GET, 'key') && filter_input(INPUT_GET, 'token')) {
            //$username = $_GET['key'];
            //$token = $_GET['token'];
            $username = filter_input(INPUT_GET, 'key');
            $token = filter_input(INPUT_GET, 'key');
            $user = $repository->findOneByUsername($username);
            if ($token == $user->getResetLinkToken()) {
                $curDate = date("Y-m-d H:i:s");
                $expDate = $user->getExpDate();
                if ($expDate >= $curDate) {
                    $reset = true;
                }
                if (filter_input(INPUT_POST, 'valider_new')) {
                    $newPassword = filter_input(INPUT_POST, 'password');
                    // $newPassword = $_POST['password'];
                    $encoded = password_hash($newPassword, PASSWORD_DEFAULT);
                    $user->setPassword($encoded);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $success = true;
                }
            } else {
                $error = 'Token incorrect, merci de vérifier le lien';
            }
        }
        return $this->render('auth/reset.html.twig', [
            'controller_name' => 'AuthController', 'error' => $error, 'reset' => $reset, 'success' => $success
        ]);
    }
}
