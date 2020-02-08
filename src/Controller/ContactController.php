<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\NamedAddress;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAdmin(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
            ->from(new NamedAddress($contact->getEmail(), $contact->getName()))
            ->to('projetastro.photo@gmail.com')

            ->subject('Formulaire de contact')
            ->htmlTemplate("contact/emailType.html.twig")
            ->context(['contact' =>$contact]);
        /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
            $mailer->send($email);

            $this->addFlash("success", "Votre message a bien été envoyé");
            return $this->redirectToRoute("home");
        }

        return $this->render('contact/contactAdmin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
