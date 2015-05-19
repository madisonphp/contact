<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

$app->before(function ($request) use ($app) {
    $app['twig']->addGlobal('active', $request->get("_route"));
});

$app->error(function (\Swift_TransportException $e, $code) {
    return new Response('We are sorry, but something went terribly wrong.');
});

$app->match('/', function(Request $request) use($app) {
    $sent = false;
    $error = false;

    $default = array(
        'fullname' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
    );

    $form = $app['form.factory']->createBuilder('form', $default)
        ->add('fullname', 'text', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3))),
            'attr' => array('class' => 'form-control'),
            'label' => 'Full Name',
        ))
        ->add('email', 'email', array(
            'constraints' => new Assert\Email(),
            'attr' => array('class' => 'form-control'),
            'label' => 'Email Address',
        ))
        ->add('phone', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Phone',
            'required' => false,
        ))
        ->add('message', 'textarea', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10))),
            'attr' => array('class' => 'form-control'),
            'label' => 'Question/Message',
        ))
        ->add('send', 'submit', array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'Submit'
        ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject('Madison PHP Conference Comment')
                ->setFrom(array('conference@madisonphp.com' => 'Madison PHP Contact Form'))
                ->setTo(array('conference@madisonphp.com'))
                ->setReplyTo(array($data['email'] => $data['fullname']))
                ->setBody($app['twig']->render('email.twig.html', $data), 'text/html')
                ->addPart($app['twig']->render('email.twig.txt', $data), 'text/plain');

            $app['mailer']->send($message);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }

    return $app['twig']->render('index.twig.html', array('form' => $form->createView(), 'sent' => $sent, 'error' => $error));
})->bind('home');
