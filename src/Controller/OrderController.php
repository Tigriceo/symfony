<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends AbstractController
{

    /**
     * @Route("/add-to-cart/{id}", name="order_add_to_cart")
     */
    public function addToCart(Product $product, OrderService $orderService, Request $request)
    {
        $orderService->add($product, 1);

        if ($request->isXmlHttpRequest()) {
            return $this->headerCart($orderService);
        }

        return $this->redirectToRoute('default');
    }

    public function headerCart(OrderService $orderService)
    {
        $order = $orderService->getOrder();

        return $this->render('order/header_cart.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/cart", name="order_cart")
     */
    public function cart(OrderService $orderService)
    {
        $order = $orderService->getOrder();

        return $this->render('order/cart.html.twig', [
            'order' => $order,
        ]);
    }

}

/**
 * @Route("/cart/{id}/count" , name="order_set_count")
 */

    public function setCount(OrderItem $item, OrderService $orderService, Request $request)
{
    $count = $request->request->getInt('count');

    if ($count > 0 ) {
        $item->setCount($count);
        $orderService->($item->getCart());

    }

    return $this ->render('order/_cart_table.html.twig', [
        'order' => $item->getCart(),
    ]);
}



