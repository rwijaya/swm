<?php
/**
 * ShoppingCart Class
 */

class ShoppingCart {

    private $cart;

    function __construct() {
        $this->cart = array();
    }

    /**
     * Add Item to cart
     *
     * @param stdClass $productObj
     * Please assumed stdClass is Product Class and it contains the following:
     * $productObj->id
     * $productObj->price
     * $productObj->specialCode -- eg: b1g1f = buy 1 get 1 free
     * $productObj->quantity
     */
    public function addToCart(stdClass $productObj) {
        if (!is_null ($productObj)) {

            // determine special product
            $specialProduct = 0;
            if ($productObj->specialCode == 'b1g1f') {
                $specialProduct = 1;
            }

            // Adding product to cart
            if (array_key_exists($productObj->id, $this->cart)) {
                $this->cart[$productObj->id]['quantity'] += (1 + $specialProduct);
            } else {
                $this->cart[$productObj->id] = array();
                $this->cart[$productObj->id]['quantity'] = (1 + $specialProduct);;
            }

            $this->cart[$productObj->id]['product'] = $productObj;

            return true;
        }
        return false;
    }

    /**
     * Removing item from current cart
     *
     * @return bool
     */
    public function emptyingCart() {
        unset($this->cart);
        $this->cart = array();

        return true;
    }

    /**
     * Calculate the total price in cart
     *
     * @return int
     */
    public function totalPrice() {
        $total = 0;
        if (!empty($this->cart)) {
            foreach ($this->cart as $key => $item) {
                $tempprice = $item['product']->price;
                if ($item['product']->specialCode == 'b1g1f') {
                    $tempprice = $item['product']->price / 2;
                }
                $total += ($item['quantity'] * $tempprice);
            }
        }
        return $total;
    }

    /**
     * Calculate the total item in cart
     *
     * @return int
     */
    public function totalNumberOfItems() {
        $numberOfItems = 0;
        foreach ($this->cart as $item) {
            $numberOfItems += $item['quantity'];
        }
        return $numberOfItems;
    }
}