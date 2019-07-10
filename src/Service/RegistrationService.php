<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 10.07.19
 * Time: 19:52
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RegistrationService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManger;

    /**
     * @var UserPasswordEncoderInterface
     */



    private $passwordEncoder;

    /**
     * @var MailerInterface
     */

    public function __construct (

        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        MailerInterface $mailer
) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder =$passwordEncoder;
        $this->mailer = $mailer;
}
 public function createUser(User $user)
   {
    $hash = $encoder->encodePassword($user, $user->getPlainPassword());
    $user->setPassword($hash);
    $user->setEmailCheckCode(md5(random_bytes(32)));
    $entityManager->persist($user);
    $entityManager->flush();

    $this->sendEmailConfirmationMassege(User $user)
   }


   public function confirmEmail(User $user)
   {
       $user->setIsEmailChecked(true);
       $user->setEmailCheckCode(null);
       $this->entityManager->flush();
   }


   private function sendEmailConfirmationMessage(User $user)
   {
       $massege = new  TemplatedEmail();
       $massege->to( new NamedAddress($user->getEmail(), $user->getFullName)))
       $massege->from('noreply@shop.com');
       $massege->subject('Подтверджение регистрации на сайте');
       $massege->htmlTemplate('security/emails/confirmation.html.twig');
       $massege->context(['user' => $user]);
       $this->mailer->send($massege);
   }
}