<?php

namespace nrv\Repository;

use PDO;

class   NRVRepository
{

    private static NRVRepository $rep;
    private static string $CONF;
    private static array $PARAMS;
    private PDO $bd;

    private function __construct()
    {
        if (!isset($_PARAMS)) {
            $this->setConfig("conf.ini");
        }
        $this->bd = new PDO(self::$PARAMS['driver'] . ":host=" . self::$PARAMS['host'] . "; dbname=" . self::$PARAMS['database'] . "; charset=utf8", self::$PARAMS['username'], self::$PARAMS['password']);
    }

    public static function setConfig($file)
    {
        self::$CONF = $file;
        self::$PARAMS = parse_ini_file($file);
    }

    public static function getInstance()
    {
        if (!isset($rep)) {
            $rep = new NRVRepository();
        }
        return $rep;
    }

    public function getDb()
    {
        return $this->bd;
    }

    public function findSoiree(int $id)
    { //retourne un tableau de données
        $query = $this->bd->prepare("select * from soiree where idSoiree = ? ;");
        $query->bindParam(1, $id);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findSpectacleBySoiree(int $id)
    { //retourne un tableau de tableaux de données
        $query = $this->bd->prepare("select * from spectacle inner join spectacle2soiree on spectacle.idSpectacle = spectacle2soiree.idSpectacle inner join soiree on soiree.idSoiree = spectacle2Soiree.idSoiree where soiree.idSoiree = ? ;");
        $query->bindParam(1, $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSoiree(string $nom, string $theme, string $date, string $description, float $tarif): bool
    {
        $query = $this->bd->prepare("INSERT INTO Soiree (NomSoiree, theme, date, descriptionSoiree, tarif) VALUES (:nom, :theme, :date, :description, :tarif)");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':theme', $theme);
        $query->bindParam(':date', $date);
        $query->bindParam(':description', $description);
        $query->bindParam(':tarif', $tarif);
        return $query->execute();
    }

    public function createSpectacle(int $idLieu, string $titre, int $style, string $date, int $duree, string $description, string $horaire, string $artiste): bool
    {
        $query = $this->bd->prepare("INSERT INTO spectacle (idSpectacle, idLieu, titre, nomArtiste, style, date, horaire, duree, description) VALUES (:idLieu, :titre, :artiste, :style, :date, :horaire, :duree, :description)");
        $query->bindParam(':idLieu', $idLieu);
        $query->bindParam(':titre', $titre);
        $query->bindParam(':artiste', $artiste);
        $query->bindParam(':style', $style);
        $query->bindParam(':date', $date);
        $query->bindParam(':horaire', $horaire);
        $query->bindParam(':duree', $duree);
        $query->bindParam(':description', $description);
        return $query->execute();
    }

    public function findSpectacle(int $id)
    {
        $query = $this->bd->prepare("select * from spectacle where idSpectacle = ? ;");
        $query->bindParam(1, $id);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findSoireeBySpectacle(int $id)
    {
        $query = $this->bd->prepare("select * from soiree inner join spectacle2soiree on soiree.idSoiree = spectacle2soiree.idSoiree where idSpectacle = ? ;");
        $query->bindParam(1, $id);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findListSoiree()
    {
        $query = $this->bd->prepare("select * from soiree;");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findListSpec()
    {
        $query = $this->bd->prepare("select * from spectacle;");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findListSpecByDate($date)
    {
        $query = "SELECT * FROM spectacle WHERE date = :date";
        $query = $this->bd->prepare($query);
        $query->bindParam(':date', $date);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findListSoireeByDate($date)
    {
        $query = "SELECT * FROM soiree WHERE date = :date";
        $query = $this->bd->prepare($query);
        $query->bindParam(':date', $date);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllLieux() {
        $query = "SELECT idLieu, nomLieu FROM lieu";
        $query = $this->bd->prepare($query);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllStyles() {
        $query = "SELECT idStyle, libelle FROM style";
        $query = $this->bd->prepare($query);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


}