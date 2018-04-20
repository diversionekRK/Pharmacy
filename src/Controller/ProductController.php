<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="product_show")
     */
    /*public function products()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        //return new Response('Check out this great products: '.$products->getName());

        // or render a template
        // in the template, print things with {{ products.name }}
         return $this->render('products/products.html.twig', ['products' => $products]);
    }*/

    /**
     * @Route("/products/{id}", name="product_showTen")
     */
    public function productsID($id = 1)
    {
        $products = false;

        if ($id > 0) {
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findTenByPage($id);
        }

        if (!$products) {
            return $this->redirect('/products/1');
        }

        $length = count($this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll());

        $length = ($length % 10) ? ceil($length / 10) : $length / 10;

        return $this->render('products/products10.html.twig', ['products' => $products, 'length' => $length]);
    }
}
