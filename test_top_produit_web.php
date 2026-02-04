<?php
/**
 * Page web pour exécuter le test unitaire de la logique du top produit
 * Accessible via navigateur pour visualiser les résultats
 */

// Fonction simulée pour obtenir le top produit (logique extraite du modèle Achat)
function getTopProduitSimule($listeAchats) {
    // Simuler la logique de produitsPlusAchetes
    $produits = [];

    // Si c'est un tableau, utiliser directement, sinon parser la chaîne
    if (is_array($listeAchats)) {
        $achats = $listeAchats;
    } else {
        // Parser la liste d'achats (format: "produit1; produit2; produit1; ...")
        $achats = explode(';', $listeAchats);
        $achats = array_map('trim', $achats);
    }

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
    $resultats = [];

    foreach ($tests as $index => $test) {
        $resultat = getTopProduitSimule($test['liste']);
        $produitObtenu = $resultat ? $resultat['nom'] : null;

        $reussi = $produitObtenu === $test['attendu'];
        if ($reussi) {
            $testsReussis++;
        }

        $resultats[] = [
            'numero' => $index + 1,
            'description' => $test['description'],
            'liste' => $test['liste'],
            'attendu' => $test['attendu'],
            'obtenu' => $produitObtenu,
            'reussi' => $reussi,
            'quantite' => $resultat ? $resultat['total_quantite'] : 'N/A'
        ];
    }

    return [
        'resultats' => $resultats,
        'testsReussis' => $testsReussis,
        'totalTests' => $totalTests,
        'succes' => $testsReussis === $totalTests
    ];
}

// Exécuter les tests
$resultatsTests = testerTopProduit();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Unitaire - Logique du Top Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .test-result {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid;
        }
        .test-success {
            background-color: #d4edda;
            border-left-color: #28a745;
        }
        .test-failure {
            background-color: #f8d7da;
            border-left-color: #dc3545;
        }
        .test-header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .test-details {
            margin-left: 20px;
        }
        .summary {
            margin-top: 30px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            color: #28a745;
            font-size: 1.2em;
        }
        .failure {
            color: #dc3545;
            font-size: 1.2em;
        }
        .refresh-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .refresh-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test Unitaire : Logique du Top Produit</h1>

        <?php foreach ($resultatsTests['resultats'] as $test): ?>
        <div class="test-result <?php echo $test['reussi'] ? 'test-success' : 'test-failure'; ?>">
            <div class="test-header">
                Test <?php echo $test['numero']; ?>: <?php echo $test['description']; ?>
                <?php echo $test['reussi'] ? '✅ RÉUSSI' : '❌ ÉCHOUÉ'; ?>
            </div>
            <div class="test-details">
                <strong>Liste d'achats:</strong> "<?php echo htmlspecialchars($test['liste']); ?>"<br>
                <strong>Résultat attendu:</strong> <?php echo $test['attendu'] ? htmlspecialchars($test['attendu']) : 'null'; ?><br>
                <strong>Résultat obtenu:</strong> <?php echo $test['obtenu'] ? htmlspecialchars($test['obtenu']) : 'null'; ?><br>
                <strong>Quantité:</strong> <?php echo $test['quantite']; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="summary">
            <h2>Résultats finaux</h2>
            <p class="<?php echo $resultatsTests['succes'] ? 'success' : 'failure'; ?>">
                Tests réussis: <?php echo $resultatsTests['testsReussis']; ?> / <?php echo $resultatsTests['totalTests']; ?>
            </p>
            <?php if ($resultatsTests['succes']): ?>
                <p class="success">🎉 TOUS LES TESTS SONT RÉUSSIS ! La logique du top produit fonctionne correctement.</p>
            <?php else: ?>
                <p class="failure">⚠️ Certains tests ont échoué. Vérifiez la logique.</p>
            <?php endif; ?>
        </div>

        <button class="refresh-btn" onclick="location.reload()">Relancer les tests</button>
    </div>
</body>
</html>
