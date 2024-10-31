<?php
require_once '../vendor/autoload.php';
require_once('../config.php');

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
function getProducts()
{
    $products = \Stripe\Product::all([
        'active' => true,
        'limit' => 100,
    ]);

    $plans = [];
    foreach (PLANS as $name => $productId) {
        $stripeProduct = array_filter($products->data, function ($product) use ($productId) {
            return $product->id === $productId;
        });
        $stripeProduct = reset($stripeProduct);

        $price = \Stripe\Price::retrieve($stripeProduct->default_price);

        $plans[$name] = [
            'id' => $productId,
            'price' => $price->unit_amount / 100,
            'priceId' => $price->id,
            'trial_period_days' => isset($price->recurring->trial_period_days) ? $price->recurring->trial_period_days : 0,
        ];
    }

    return $plans;
}