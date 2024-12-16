<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OnlyEntityFixture extends Fixture
{
    private const FAQS = [
        [
            "question" => "Pourquoi utiliser des QR codes pour le contrôle des frais académiques ?",
            "response" => "Le QR code simplifie le processus de suivi des paiements en permettant une vérification rapide et sécurisée. Il élimine les bordereaux en papier, réduit les risques de perte et rend le système plus efficace."
        ],
        [
            "question" => "Que contient le QR code généré par l’application ?",
            "response" => "Le QR code contient les informations personnelles de l’étudiant (nom, numéro matricule, promotion) et son état de paiement (montants payés, montants restants, dates des paiements)."
        ],
        [
            "question" => "Comment récupérer mon QR code ?",
            "response" => "Une fois votre paiement enregistré, vous pouvez télécharger votre QR code directement depuis votre espace personnel dans l'application web ou mobile."
        ],
        [
            "question" => "Que se passe-t-il si je perds mon QR code ?",
            "response" => "Pas de panique ! Vous pouvez en générer un nouveau depuis l’application en vous connectant à votre compte étudiant. Le QR code reste lié à vos informations personnelles et à votre état de paiement."
        ],
        [
            "question" => "Qui peut scanner mon QR code ?",
            "response" => "Seuls les agents administratifs de l’université autorisés ont accès aux outils de vérification pour scanner et vérifier l’authenticité de votre QR code."
        ],
        [
            "question" => "Mes informations personnelles sont-elles en sécurité ?",
            "response" => "Oui. Les données intégrées au QR code sont cryptées et ne peuvent être lues qu’avec des outils dédiés à l’université. De plus, l’application respecte les normes de protection des données."
        ],
        [
            "question" => "Puis-je partager mon QR code avec un autre étudiant ?",
            "response" => "Non. Le QR code est unique et associé uniquement à votre profil étudiant. Toute tentative de partage ou de fraude sera détectée lors du scan."
        ],
        [
            "question" => "Puis-je utiliser mon QR code pour plusieurs paiements ?",
            "response" => "Oui, le QR code est mis à jour automatiquement après chaque paiement. Il reflète en temps réel votre état de paiement global."
        ],
        [
            "question" => "Que faire si mon QR code n'est pas accepté lors du scan ?",
            "response" => "Si le QR code ne fonctionne pas, vérifiez d’abord que vous avez téléchargé la dernière version via l’application. Si le problème persiste, contactez le service informatique ou l’administration de votre faculté."
        ],
        [
            "question" => "L’application prend-elle en charge les paiements en ligne ?",
            "response" => "Oui, l’application vous permet d’effectuer des paiements en ligne via des partenaires bancaires ou des services de paiement mobile. Une fois le paiement effectué, votre QR code est mis à jour automatiquement."
        ],
        [
            "question" => "Comment signaler une erreur dans mes informations de paiement ?",
            "response" => "En cas d’erreur, connectez-vous à l’application, allez dans la section “Assistance” et soumettez une demande. L’administration vérifiera vos informations et corrigera l’erreur si nécessaire."
        ],
        [
            "question" => "Est-ce que le QR code est obligatoire pour accéder aux services académiques ?",
            "response" => "Oui, le QR code est désormais requis pour vérifier votre statut de paiement et accéder à certains services académiques, comme l’inscription ou la participation aux examens."
        ],
        [
            "question" => "Combien de temps mon QR code reste-t-il valide ?",
            "response" => "Votre QR code reste valide tant que vous êtes inscrit et que vos paiements sont à jour. En cas de non-paiement, l’accès à certains services peut être bloqué."
        ],
        [
            "question" => "Que se passe-t-il si je ne paie pas à temps ?",
            "response" => "En cas de retard de paiement, votre QR code indiquera un état “paiement en attente”, ce qui pourrait limiter l’accès à certains services académiques, conformément aux règlements de l’université."
        ],
        [
            "question" => "Puis-je utiliser le QR code pour payer directement à l’université ?",
            "response" => "Non. Le QR code ne sert qu’à vérifier vos paiements. Les paiements doivent être effectués via les canaux autorisés (banques ou mobile money) avant d’être validés dans l’application."
        ],
    ];

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        foreach (self::FAQS as $faq) {

            $quiz = (new Quiz())
                ->setRequest($faq['question'])
                ->setResponse($faq['response'])
                ->setFeatured(true);

            $manager->persist($quiz);
        }

        $manager->flush();
    }
}
