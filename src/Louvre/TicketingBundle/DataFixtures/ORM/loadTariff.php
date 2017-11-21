<?php

namespace Louvre\TicketingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Louvre\TicketingBundle\Entity\Tariff;

class LoadTicketing implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Normal',
      'Senior',
      'Enfant',
      'Moins de 4 ans'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $tariff = new Tariff();
      $tariff->setName($name);

      // On la persiste
      $manager->persist($tariff);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}