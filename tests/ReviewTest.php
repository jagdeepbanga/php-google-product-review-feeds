<?php

namespace JagdeepBanga\GoogleProductReviewFeed\Tests;

use JagdeepBanga\GoogleProductReviewFeed\Feed;
use JagdeepBanga\GoogleProductReviewFeed\Product;
use JagdeepBanga\GoogleProductReviewFeed\Review;
use JagdeepBanga\GoogleProductReviewFeed\Tests\Fixture\FeedFixture;

class ReviewTest extends TestCase
{
    /** @test */
    public function can_generate_product_review_feed(): void
    {
        $expectedReviewXmlFeed = FeedFixture::getReviewExpectedXml();

        $product = new Product();
        $product->setName('Product Name');
        $product->setGtin('1234567890123');
        $product->setSku('1234567890123');
        $product->setBrand('Brand Name');
        $product->setUrl('https://www.example.com/product/1');

        $review = new Review();
        $review->setName('John Doe');
        $review->setTimeStamp('2020-01-01T00:00:00+00:00');
        $review->setTitle('Excellent');
        $review->setId(123);
        $review->setUrl('https://www.example.com/review/1');
        $review->setRating(5);
        $review->setContent('This is a review');
        $review->addProduct($product);

        $feed = new Feed('Company Name', 'https://www.example.com/favicon.ico');
        $feed->addReview($review);

        $this->assertXmlStringEqualsXmlString($expectedReviewXmlFeed, $feed->generate());
    }
}