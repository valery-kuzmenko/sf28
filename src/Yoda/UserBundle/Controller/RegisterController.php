<?php
/**
 * Created by PhpStorm.
 * User: Valery.Kuzmenka
 * Date: 4/22/2016
 * Time: 4:14 PM
 */

namespace Yoda\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yoda\EventBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\Form\RegisterFormType;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     *
     * typehint $request object - works only for Request class
     */
    public function registerAction(Request $request)
    {
//            $data = array(
//                'username' => 'Leia'
//            );

            $user = new User();
            $user->setUsername('Leya');


//            $form = $this->createFormBuilder($user, array(
//                'data_class' => 'Yoda\UserBundle\Entity\User'
//            ))
//            ->add('username', 'text')
//            ->add('email', 'text')
//            ->add('plainPassword', 'repeated', array(
//                'type' => 'password' // displays this field two times
//            ))
//            ->getForm();
        $form = $this->createForm(new RegisterFormType(), $user);

        $form->handleRequest($request);
        if(/*$form->isSubmitted() && */ $form->isValid()) {
//            $data = $form->getData();
//
//            $user = new User();
//            $user->setUsername($data['username']);
//            $user->setEmail($data['email']);
//            $user->setPassword($this->encodePassword($user, $data['password']));
            $user = $form->getData();
            $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->authenticateUser($user);

            $request->getSession()->getFlashBag()
                ->add('success', 'Welcome to the Death Star!');

            $url = $this->generateUrl('event');

            return $this->redirect($url);
        }

        return array('form' => $form->createView());


    }

    private function encodePassword(User $user, $plainPassword){
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    private function authenticateUser(User $user){
        $providerKey = 'secured_area';
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->getSecurityContext()->setToken($token);
    }
}