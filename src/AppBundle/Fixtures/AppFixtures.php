<?php

namespace AppBundle\Fixtures;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Les fixtures sont dés données de tests.
 * Vous pouvez les charger en utilisant la console:
 *           bin/console doctrine:fixtures:load
 */
final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoryNames = ['PHP', 'Javascript', 'ReactJs', 'Java', 'Téléphonie'];
        $categories = [];

        foreach ($categoryNames as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);

            $categories[$categoryName] = $category;
        }

        $article = new Article();
        $article->setTitle('Architecture PHP scalable et haute performance en 2018');
        $article->setCategory($categories['PHP']);
        $article->setContent('Il y a 4 ans, je vous présentais quelques outils permettant de mettre en place un site Web fort trafic. C\'est l\'heure de mettre à jour cette architecture PHP en version 2018 ! Il s\'agit d\'un article contenant quelques pistes sur les principaux composants logiciels à utiliser afin d\'obtenir des performances optimales sur votre stack.');
        $article->setCreatedAt(new \DateTime('last monday'));
        $article->setImage($this->getFile('php1.jpg'));
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Comment générer des fichiers Excel (XLSX, XLS) en PHP ?');
        $article->setCategory($categories['PHP']);
        $article->setContent('Cet article liste les principales solutions pour écrire des fichiers Excel aux formats XLS et XLSX à partir d\'une application PHP. Si vous développez des applications de gestion en PHP, vous vous êtes probablement déjà retrouvés face au choix de la librairie permettant d\'exporter des fichiers Excel.');
        $article->setCreatedAt(new \DateTime('last tuesday'));
        $article->setImage($this->getFile('php2.png'));
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Connecter son ordinateur à Internet via la 4G du téléphone en bluetooth');
        $article->setCategory($categories['Téléphonie']);
        $article->setContent('Il y a quelques temps, je vous expliquais comment connecter son ordinateur à Internet via la 4G de son téléphone portable en utilisant le port USB de son téléphone ou en connectant son ordinateur à un réseau Wifi créé avec son téléphone. Il est désormais possible de connecter son ordinateur et son téléphone en bluetooth pour profiter de sa connexion');
        $article->setCreatedAt(new \DateTime('last wednesday'));
        $article->setImage($this->getFile('tel1.png'));
        $manager->persist($article);

        $article = new Article();
        $article->setTitle('Partage de connexion Internet en Wifi : problème « pas d’Internet » – Configuration APN');
        $article->setCategory($categories['Téléphonie']);
        $article->setContent('Il y a quelques temps, je vous expliquais comment connecter son ordinateur à Internet via la 4G de son téléphone portable en utilisant le port USB de son téléphone ou en connectant son ordinateur à un réseau Wifi créé avec son téléphone. Il est désormais possible de connecter son ordinateur et son téléphone en bluetooth pour profiter de sa connexion');
        $article->setCreatedAt(new \DateTime('last thursday'));
        $article->setImage($this->getFile('tel2.png'));
        $manager->persist($article);

        $manager->flush();
    }

    private function getFile($sampleFilename)
    {
        $file = new File(__DIR__ . '/images/' . $sampleFilename);
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        // moves the file to the directory where image are stored
        $file->move(
            __DIR__ . '/../../../web/uploads/article',
            $fileName
        );
        return $fileName;
    }

}
