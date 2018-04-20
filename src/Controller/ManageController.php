<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Entity\User;

class ManageController extends Controller
{
    /**
     * @Route("/manage", name="manage")
     */
    public function manage()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('management/manage.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/modify", name="modyf")
     */
    public function modifyAction()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('management/modify.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/modify/{id}", name="modyfItem")
     */
    public function modifyItem(Request $request, $id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            return $this->redirectToRoute('modyf');
        }

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('price', NumberType::class, array('invalid_message' => 'Niepoprawna wartość'))
            ->add('description', TextType::class)
            ->add('quantity', IntegerType::class)
            ->add('change', SubmitType::class, array('label' => 'Zmień'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $product = $form->getData();

            // ... perform some action, such as saving to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('modyf');
        }

        return $this->render('management/modifyItem.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('/management/delete.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/delete/{id}", name="deleteItem")
     */
    public function deleteItem(Request $request, $id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('delete');
    }

    /**
     * @Route("/add", name="add")
     */
    public function addItem(Request $request)
    {
        $product = new Product();

        $form = $this->createAddForm($product);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // $form->getData() holds the submitted values
                $product = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $form = $this->createAddForm();

                return $this->render('management/add.html.twig', array(
                    'form' => $form->createView(),
                    'info' => "Pomyślnie dodano!",
                ));
            } else
                return $this->render('management/add.html.twig', array(
                    'form' => $form->createView(),
                ));
        }
        return $this->render('management/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function createAddForm($product = NULL)
    {
        return $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('price', NumberType::class, array('invalid_message' => 'Niepoprawna wartość'))
            ->add('description', TextType::class)
            ->add('quantity', IntegerType::class)
            ->add('add', SubmitType::class, array('label' => 'Dodaj'))
            ->getForm();
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction()
    {
        // Create a new blank user and process the form
        $user = new User();
        $user->setUsername("testowy");
        $user->setPassword("test");

        // Encode the new users password
        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        // Save
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('login');
    }
}
