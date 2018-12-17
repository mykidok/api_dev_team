<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class UserController extends AbstractController
{
    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(DecoderInterface $decoder, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, \Swift_Mailer $mailer)
    {
        $this->decoder = $decoder;
        $this->encoder = $encoder;
        $this->em = $em;
        $this->mailer = $mailer;
    }


    /**
     * @Route(
     *     name="create_user",
     *     path="/api/users",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="create_user"
     *     }
     * )
     */
    public function addUser(Request $request)
    {
        $content = $this->decoder->decode((string) $request->getContent(), JsonEncoder::FORMAT);
        $repository = $this->em->getRepository(User::class);

        $userFound = $repository->findOneBy(['username' => $content['username']]);

        if ($userFound instanceof User) {
            return new ConflictHttpException(sprintf('Account with username %s already exists', $content['username']));
        }

        $user = new User();
        $password = $this->encoder->encodePassword($user, $content['password']);

        $user
            ->setLastname($content['lastname'])
            ->setFirstname($content['firstname'])
            ->setUsername($content['username'])
            ->setPassword($password)
        ;

        return $user;
    }

    /**
     * @Route(
     *     name="update_password",
     *     path="/api/users/{id}/update_password",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="update_password"
     *     }
     * )
     *
     * @IsGranted("ROLE_VOTER", subject="user", message="Access Denied")
     */
    public function updateUserPassword(User $user, Request $request)
    {
        $content = $this->decoder->decode((string) $request->getContent(), JsonEncoder::FORMAT);

        if (!isset($content['password'])) {
            throw new UnprocessableEntityHttpException('A property "password" was expected');
        }

        $newPassword = $this->encoder->encodePassword($user, $content['password']);

        $user->setPassword($newPassword);

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($user->getUsername())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('password' => $content['password'])
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);

        return $user;
    }
}