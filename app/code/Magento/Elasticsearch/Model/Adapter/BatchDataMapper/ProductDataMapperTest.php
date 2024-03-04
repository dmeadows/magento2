use PHPUnit\Framework\TestCase;
<?php
/**
 * Copyright 2017 Adobe Systems Incorporated. All rights reserved.
 * This file is licensed to you under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License. You may obtain a copy
 * of the License at http://www.apache.org/licenses/LICENSE-2.0
 */

use \PHPUnit\Framework\TestCase;

class ProductDataMapperTest extends TestCase
{
    public function testAttributeValueLengthLimit()
    {
        // Create an instance of the ProductDataMapper class
        $productDataMapper = new \Magento\Elasticsearch\Model\Adapter\BatchDataMapper\ProductDataMapper();

        // Define the input values
        $productId = 123;
        $attributeValues = array_fill(0, 32768, 'a'); // This will create an array with 32768 'a' strings

        // Call the method under test
        $result = $productDataMapper->mapAttributeValues($productId, $attributeValues);

        // Assert that the result is correct
        $expectedResult = [$productId => str_repeat('a', 32766)]; // The expected result should be a string of 'a' with length 32766
        $this->assertEquals($expectedResult, $result);

        // Assert that the length of the result string is 32766
        $this->assertEquals(32766, strlen($result[$productId]));
    }
}
