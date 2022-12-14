<?php

namespace Jagdeepbanga\GoogleProductReviewFeed\Tests;

use Jagdeepbanga\GoogleProductReviewFeed\Feed;
use Jagdeepbanga\GoogleProductReviewFeed\ProductFeed;
use Jagdeepbanga\GoogleProductReviewFeed\ReviewerFeed;
use Jagdeepbanga\GoogleProductReviewFeed\ReviewFeed;
use Jagdeepbanga\GoogleProductReviewFeed\Tests\Fixture\FeedFixture;

class ReviewFeedTest extends TestCase
{
    /** @test */
    public function can_generate_product_review_feed(): void
    {
        $expectedReviewXmlFeed = FeedFixture::getReviewExpectedXml();

        $product = new ProductFeed();
        $product->setName('Product Name');
        $product->setGtin('1234567890123');
        $product->setSku('1234567890123');
        $product->setBrand('Brand Name');
        $product->setUrl('https://www.example.com/product/1');

        $reviewer = new ReviewerFeed();
        $reviewer->setName('John Doe');
        $reviewer->setId('234');

        $review = new ReviewFeed();
        $review->setTimeStamp('2020-01-01T00:00:00+00:00');
        $review->setTitle('Excellent');
        $review->setId(123);
        $review->setUrl('https://www.example.com/review/123');
        $review->setRating(5);
        $review->setContent('This is a review');

        $review->addReviewer($reviewer);
        $review->addProduct($product);

        $product2 = new ProductFeed();
        $product2->setName('Product Name 2');
        $product2->setGtin('2345678901234');
        $product2->setSku('5678901234567');
        $product2->setBrand('Brand Name 2');
        $product2->setUrl('https://www.example.com/product/2');

        $reviewer2 = new ReviewerFeed();
        $reviewer2->setName('Peter Parker');
        $reviewer2->setId('235');

        $review2 = new ReviewFeed();
        $review2->setTimeStamp('2022-03-07T00:00:00+00:00');
        $review2->setTitle('Good');
        $review2->setId(124);
        $review2->setUrl('https://www.example.com/review/124');
        $review2->setRating(4);
        $review2->setContent('Lorem ipsum dolor sit amet');
        $review2->addReviewer($reviewer2);
        $review2->addProduct($product2);

        $feed = new Feed('Company Name', 'https://www.example.com/favicon.ico');
        $feed->addReview($review);
        $feed->addReview($review2);

        $this->assertXmlStringEqualsXmlString($expectedReviewXmlFeed, $feed->generate());
    }
}
