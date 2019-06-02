<?php
/**
 * Tests unitaires de la class PdoGsb
 * 
 *  PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Pauline Gaonac'h <pauline.gaod@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

use PHPUnit\Framework\TestCase;

class PdoGsbTest extends TestCase {
    protected $pdo;

    protected function setUp() : void 
    {
        include_once "/var/www/html/gsb-web/includes/class.pdogsb.inc.php";
        $this->pdo = PdoGsb::getPdoGsb();
    }

    public function utilisateurProvider()
    {
        return [
            ['a17', 'David', 'Andre', '0'],
            ['a2', 'Mathias', 'Cohen', '1'],
            ['c54', 'Michel', 'Debelle', '0']
        ];
    }

    public function ficheProvider()
    {
        return [
            ['a17', '201805', [14.0*110.0, 654.0*0.62, 4.0*80.0, 12.0*25.0]], //[186.0, 31.0, 45.0, 143.0, 33.0]
            ['c3', '201701', [20.0*110.0, 751.0*0.62, 3.0*80.0, 5.0*25.0]]
        ];
    }

    /**
     * @dataProvider ficheProvider
     */
    public function testGetLesMontantsFraisForfait($idVisiteur, $mois, $lesMontantsPrevus) : void 
    {
        $lesMontants = $this->pdo->getLesMontantsFraisForfait($idVisiteur, $mois);
        $this->assertSame($lesMontantsPrevus, $lesMontants);
    }

    /**
     * @dataProvider utilisateurProvider
     */
    public function testGetInfosUtilisateurParId($id, $prenom, $nom, $fonction) : void
    {
        $infos = $this->pdo->getInfosUtilisateurParId($id);
        $this->assertSame($fonction, $infos['fonction']);
        $this->assertSame($nom, $infos['nom']);
        $this->assertSame($prenom, $infos['prenom']);
    }
/*
    public function getLesMontantsFraisHorsForfaitValides() : void 
    {

    }
    
    public function majFraisHorsForfait() : void 
    {

    }

    public function refuserFraisHorsForfait()  : void 
    {

    }

    public function reporterFraisHorsForfait()  : void 
    {

    }

    public function getLesFichesValidees()  : void 
    {

    }
    
    public function getLesMoisDisponiblesAEtats()  : void 
    {

    }

    public function majEtatFicheFrais()  : void 
    {

    }

    public function majMontantValideFicheFrais()  : void 
    {

    }*/
}