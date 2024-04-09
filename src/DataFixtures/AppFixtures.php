<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    /**
     * Seeder 
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create("fr_FR");
    }


    public function load(ObjectManager $manager): void
    {




        $categories = [];

        for ($i=0; $i < 5 ; $i++) { 
            $createdDate = $this->faker->dateTimeBetween('-1 year', 'now');
            $category = new Category();
            $category->setName($this->faker->realText($maxNbChars=255, $indexSize = 2))
            ->setStatus("on")
            ->setCreatedAt($createdDate)
            ->setUpdatedAt($this->faker->dateTimeBetween($createdDate, 'now'));
            $categories[] = $category;
            $manager->persist($category);
        }
        $articles = [];
        for ($i=0; $i < 100; $i++) { 
            $createdDate = $this->faker->dateTimeBetween('-1 year', 'now');
            $article = new Article();
            $article->setTitle($this->faker->realText($maxNbChars=255, $indexSize = 2))
            ->setStatus("on")
            ->setCreatedAt($createdDate)
            ->setUpdatedAt($this->faker->dateTimeBetween($createdDate, 'now'))
            ->addCategory($categories[array_rand($categories)]);
            $articles[] = $article;
            $manager->persist($article);
        }

        for ($i=0; $i < 200; $i++) { 
            $article = $articles[array_rand($articles)];
            $articleCreatedAt = $article->getCreatedAt();
            $createdDate = $this->faker->dateTimeBetween($articleCreatedAt, 'now');

            $comment = new Comment();
            $comment->setContent($this->faker->realText($maxNbChars=255, $indexSize = 2))
            ->setStatus("on")
            ->setArticle($article)
            ->setCreatedAt($createdDate)
            ->setUpdatedAt($this->faker->dateTimeBetween($createdDate, 'now'));
            $manager->persist($comment);

        }

        $manager->flush();
    }
}
