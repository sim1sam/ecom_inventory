<?php

function custom_sanitize($content)
{
    $replace = array('<p>', '</p>');
    $response = str_replace($replace, '', $content);
    return $response;
}

/**
 * Encode order ID for secure URL
 */
function encodeOrderId($orderId)
{
    try {
        return base64_encode(encrypt($orderId));
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Decode order ID from secure URL
 */
function decodeOrderId($encodedOrderId)
{
    try {
        return decrypt(base64_decode($encodedOrderId));
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Check if product has discount (offer price)
 */
function checkDiscount($product)
{
    return $product->offer_price && $product->offer_price < $product->price;
}
