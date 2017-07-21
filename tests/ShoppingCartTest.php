<?php
/**
 * Test Cases for ShoppingCart Class
 */

require_once ('../src/ShoppingCart.php');

class ShoppingCartTest extends PHPUnit\Framework\TestCase  {

    private $product_1;
    private $product_2;
    private $product_3;
    private $product_4;
    private $product_5;

    public function setUp() {
        /** Initialising some products. Ideally the product should be done through Product class */
        $this->product_1 = new stdClass();
        $this->product_1->id = 1;
        $this->product_1->price = 1;
        $this->product_1->specialCode = 'b1g1f'; // this is for buy 1 get 1 free special

        $this->product_2 = new stdClass();
        $this->product_2->id = 2;
        $this->product_2->price = 2;
        $this->product_2->specialCode = '';

        $this->product_3 = new stdClass();
        $this->product_3->id = 3;
        $this->product_3->price = 3;
        $this->product_3->specialCode = '';

        $this->product_4 = new stdClass();
        $this->product_4->id = 4;
        $this->product_4->price = 4;
        $this->product_4->specialCode = 'b1g1f';

        $this->product_5 = new stdClass();
        $this->product_5->id = 5;
        $this->product_5->price = 5;
        $this->product_5->specialCode = '';
    }

    /**
     * Test case to add item to shopping cart
     */
    public function testAddToCart() {
        $shoppingCart = new ShoppingCart();

        $manualShoppingCart = new ShoppingCart();
        $testAddProduct1 = $manualShoppingCart->addToCart($this->product_1);
        $testAddProduct2 = $manualShoppingCart->addToCart($this->product_2);
        $testAddProduct3 = $manualShoppingCart->addToCart($this->product_3);

        $this->assertTrue($shoppingCart->addToCart($this->product_1) === $testAddProduct1);
        $this->assertTrue($shoppingCart->addToCart($this->product_2) === $testAddProduct2);
        $this->assertTrue($shoppingCart->addToCart($this->product_3) === $testAddProduct3);

        // manual test result
        $this->assertTrue($shoppingCart->addToCart($this->product_1) === true);
        $this->assertTrue($shoppingCart->addToCart($this->product_2) === true);
        $this->assertTrue($shoppingCart->addToCart($this->product_3) === true);
    }

    /**
     * Test case to empty shopping cart
     */
    public function testEmptyingCart() {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addToCart($this->product_1);
        $shoppingCart->addToCart($this->product_3);

        $this->assertEquals($shoppingCart->totalPrice(), 4);

        $this->assertTrue($shoppingCart->emptyingCart());

        // Additional test to confirm the function is working correctly
        $shoppingCart->addToCart($this->product_5);
        // manual calculation result
        $this->assertEquals($shoppingCart->totalPrice(), 5);
    }

    /**
     * Test case to calculate total price in shopping cart
     */
    public function testTotalPrice() {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addToCart($this->product_1);
        $shoppingCart->addToCart($this->product_4);
        $shoppingCart->addToCart($this->product_3);
        $shoppingCart->addToCart($this->product_4);
        $shoppingCart->addToCart($this->product_5);

        $manualShoppingCart = new ShoppingCart();
        $manualShoppingCart->addToCart($this->product_1);
        $manualShoppingCart->addToCart($this->product_4);
        $manualShoppingCart->addToCart($this->product_3);
        $manualShoppingCart->addToCart($this->product_4);
        $manualShoppingCart->addToCart($this->product_5);

        $this->assertEquals($shoppingCart->totalPrice(), $manualShoppingCart->totalPrice());

        // manual calculation result
        $this->assertEquals($shoppingCart->totalPrice(), 17);
    }

    /**
     * Test case to calculate total item in shopping cart
     */
    public function testTotalItem() {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addToCart($this->product_1);
        $shoppingCart->addToCart($this->product_2);
        $shoppingCart->addToCart($this->product_4);

        $manualShoppingCart = new ShoppingCart();
        $manualShoppingCart->addToCart($this->product_1);
        $manualShoppingCart->addToCart($this->product_2);
        $manualShoppingCart->addToCart($this->product_4);


        $this->assertEquals($shoppingCart->totalNumberOfItems(), $manualShoppingCart->totalNumberOfItems());

        // manual calculation result
        $this->assertEquals($shoppingCart->totalNumberOfItems(), 5);
    }
}