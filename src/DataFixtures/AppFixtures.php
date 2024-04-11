<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * Seeder 
     *
     * @var Generator
     */
    private Generator $faker;
/**
 * Undocumented variable
 *
 * @var UserPasswordHasherInterface
 */
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->faker = Factory::create("fr_FR");
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager): void
    {

        $users = [];
        for ($i=0; $i < 10 ; $i++) { 
            $user = new User();
            $password = $this->faker->password(2, 6);
            $user->setUsername($this->faker->userName() . "@" . $password)
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->userPasswordHasher->hashPassword($user, $password))
            ;
            $manager->persist($user);
        }
        $user = new User();
        $password = "password";
        $user->setUsername("admin")
        ->setRoles(["ROLE_ADMIN"])
        ->setPassword($this->userPasswordHasher->hashPassword($user, $password))
        ;
        $manager->persist($user);

        $categories = [];

        for ($i=0; $i < 5 ; $i++) { 
            $name =$this->faker->realText($maxNbChars=10, $indexSize = 2);
            $createdDate = $this->faker->dateTimeBetween('-1 year', 'now');
            $category = new Category();
            $category->setName($name)
            ->setSlug($name)
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
