<?php

//
//namespace App\DataFixtures;
//
//use App\Entity\Program;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Persistence\ObjectManager;
//
//class ProgramFixtures extends Fixture
//{
//    const TITLE = [
//        'Andor',
//        'The Lord of the Rings: The Rings of Power',
//        'Rick and Morty',
//        'Game of Thrones',
//        'The Blacklist',
//    ];
//
//    const SYNOPSIS = [
//        "Prequel series to Star Wars' 'Rogue One'.
//         In an era filled with danger, deception and intrigue,
//         Cassian will embark on the path that is destined to turn him into a Rebel hero.",
//        "Epic drama set thousands of years before the events of J.R.R. Tolkien's 'The Hobbit' and
//          'The Lord of the Rings'
//         follows an ensemble cast of characters, both familiar and new,
//          as they confront the long-feared re-emergence of evil to Middle-earth.",
//        "An animated series that follows the exploits of a super scientist and his not-so-bright grandson.",
//        "Nine noble families fight for control over the lands of Westeros,
//          while an ancient enemy returns after being dormant for millennia.",
//        "A new FBI profiler, Elizabeth Keen, has her entire life uprooted when a mysterious criminal,
//         Raymond Reddington, who has eluded capture for decades,
//          turns himself in and insists on speaking only to her.",
//    ];
//
//    const CAT = [
//        'category_Action',
//        'category_Adventure',
//        'category_Animation',
//        'category_Fantasy',
//        'category_Crime',
//    ];
//
//    public function load(ObjectManager $manager): void
//    {
//
//        for ($i = 0; $i < 5; $i++) {
//            $program = new Program();
//            $program->setTitle(self::TITLE[$i]);
//            $program->setSynopsis(self::SYNOPSIS[$i]);
//            $program->setCategory($this->getReference(self::CAT[$i]));
//            $manager->persist($program);
//            $manager->flush();
//        }
//        $manager->flush();
//    }
//
//    public function getDependencies()
//    {
//        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
//        return [
//            CategoryFixtures::class,
//        ];
//    }
//}
