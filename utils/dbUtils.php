<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DbUtils
{
    private $entityManager;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        // Chemin vers les entités (modèles)
        $paths = array("/path/to/your/entities");
        $isDevMode = true;

        // Configuration de la connexion à la base de données
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'dbname'   => getenv('DB_NAME'),
        );

        // Configuration et création de l'EntityManager
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function testDbConnection()
    {
        try {
            $this->entityManager->getConnection()->connect();
            echo "Connexion à la base de données réussie.\n";
        } catch (\Exception $e) {
            echo "Impossible de se connecter à la base de données: " . $e->getMessage() . "\n";
        }
    }

    public function syncDb()
    {
        try {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();

            // Mettre à jour le schéma de la base de données
            $schemaTool->updateSchema($classes, true);
            echo "Tous les modèles ont été synchronisés avec succès.\n";
        } catch (\Exception $e) {
            echo "Erreur lors de la synchronisation des modèles: " . $e->getMessage() . "\n";
        }
    }
}
