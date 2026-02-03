<?php
/**
 * Script de test unitaire pour la logique du top produit
 * Ce script teste la fonction getTopProduit sans dépendre de la base de données
 */

// Fonction simulée pour obtenir le top produit (logique extraite du modèle Achat)
function getTopProduitSimule($listeAchats) {
    // Simuler la logique de produitsPlusAchetes
    $produits = [];

    // Parser la liste d'achats (format: "produit1; produit2; produit1; ...")
    $achats = explode(';', $listeAchats);
    $achats = array_map('trim', $achats);

    // Compter les occurrences de chaque produit
    foreach ($achats as $produit) {
        if (!empty($produit)) {
            if (!isset($produits[$produit])) {
                $produits[$produit] = 0;
            }
            $produits[$produit]++;
        }
    }

    // Trier par quantité décroissante
    arsort($produits);

    // Retourner le produit le plus acheté
    if (!empty($produits)) {
        $topProduit = key($produits);
        return [
            'nom' => $topProduit,
            'total_quantite' => current($produits)
        ];
    }

    return null;
}

// Fonction de test
function testerTopProduit() {
    echo "=== Test Unitaire : Logique du Top Produit ===\n\n";

    $tests = [
        [
            'liste' => 'pomme; poire; pomme',
            'attendu' => 'pomme',
            'description' => 'Test avec pommes et poires'
        ],
        [
            'liste' => 'banane; orange; banane; banane; pomme',
            'attendu' => 'banane',
            'description' => 'Test avec bananes majoritaires'
        ],
        [
            'liste' => 'carotte; tomate; carotte; tomate; carotte',
            'attendu' => 'carotte',
            'description' => 'Test avec légumes'
        ],
        [
            'liste' => 'pain',
            'attendu' => 'pain',
            'description' => 'Test avec un seul produit'
        ],
        [
            'liste' => '',
            'attendu' => null,
            'description' => 'Test avec liste vide'
        ]
    ];

    $testsReussis = 0;
    $totalTests = count($tests);

    foreach ($tests as $index => $test) {
        echo "Test " . ($index + 1) . ": " . $test['description'] . "\n";
        echo "Liste d'achats: \"" . $test['liste'] . "\"\n";

        $resultat = getTopProduitSimule($test['liste']);
        $produitObtenu = $resultat ? $resultat['nom'] : null;

        echo "Résultat attendu: " . ($test['attendu'] ?? 'null') . "\n";
        echo "Résultat obtenu: " . ($produitObtenu ?? 'null') . "\n";

        if ($produitObtenu === $test['attendu']) {
            echo "✅ TEST RÉUSSI\n";
            $testsReussis++;
        } else {
            echo "❌ TEST ÉCHOUÉ\n";
        }

        echo "Quantité: " . ($resultat ? $resultat['total_quantite'] : 'N/A') . "\n";
        echo "------------------------\n\n";
    }

    echo "=== RÉSULTATS FINAUX ===\n";
    echo "Tests réussis: $testsReussis / $totalTests\n";

    if ($testsReussis === $totalTests) {
        echo "🎉 TOUS LES TESTS SONT RÉUSSIS ! La logique du top produit fonctionne correctement.\n";
        return true;
    } else {
        echo "⚠️ Certains tests ont échoué. Vérifiez la logique.\n";
        return false;
    }
}

// Exécuter les tests
$resultatGlobal = testerTopProduit();

// Code de sortie pour les scripts automatisés
exit($resultatGlobal ? 0 : 1);
?>
