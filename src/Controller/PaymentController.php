<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="app_payment")
     */
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


    /**
     * @Route("/checkout", name="checkout")
     */

    public function checkout(): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51JXqf1ESay5sBgHM8TdS5EV1QEBnmm1h6dbsfSlWbMV5rxEsJisnTAGQ9BW2IsYkMH5E2FIft9WUuVfRHSbrnj3A00mz15fytG');

        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost/acceptpay';

        /*
          line_item -> productos
          mxn (pesos) -> no modificar
          name-> product->name
          unit_amount-> product->{'sales_price'}
        */

        $checkout_session = \Stripe\Checkout\Session::create([
            //'customer_email' => 'customer@example.com',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA', 'MX'],
            ],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'PACK SANTORINI',
                        ],
                        'unit_amount' => 400000,
                    ],
                    'quantity' => 1,
                ],
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Tu :)',
                        ],
                        'unit_amount' => 500,
                    ],
                    'quantity' => 1,
                ],
            ],
            'payment_method_types' => [
                'card',

            ],
            'mode' => 'payment',

            'success_url' => $YOUR_DOMAIN . '/success.html' ,
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);

        return $this->redirect($checkout_session->url,303);
        return $this->redirectToRoute('success_url');

    }

    /**
     * @Route("/checkout/success_url" , name="success_url")
     */
    public function successCheckout():Response
    {

        return $this->render('payement/success.html.twig',[]);

    }
}
