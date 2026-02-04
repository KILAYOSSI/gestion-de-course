<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Courses Familiales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #e3f2fd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 182, 193, 0.1);
            animation: iceFloat 20s ease-in-out infinite;
            z-index: -1;
        }
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,215,0,0.5)" /></svg>') repeat;
            animation: sparkleFloat 20s ease-in-out infinite;
            z-index: -1;
        }
        .floating-particle:nth-child(1) {
            position: fixed;
            top: 10%;
            left: -10%;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, rgba(255,215,0,0.8) 0%, rgba(255,215,0,0.2) 70%);
            border-radius: 50%;
            animation: floatHorizontal1 15s linear infinite;
            z-index: -1;
        }
        .floating-particle:nth-child(2) {
            position: fixed;
            top: 30%;
            right: -10%;
            width: 15px;
            height: 15px;
            background: radial-gradient(circle, rgba(255,182,193,0.8) 0%, rgba(255,182,193,0.2) 70%);
            border-radius: 50%;
            animation: floatHorizontal2 20s linear infinite;
            z-index: -1;
        }
        .floating-particle:nth-child(3) {
            position: fixed;
            top: 50%;
            left: -10%;
            width: 25px;
            height: 25px;
            background: radial-gradient(circle, rgba(135,206,235,0.8) 0%, rgba(135,206,235,0.2) 70%);
            border-radius: 50%;
            animation: floatHorizontal1 18s linear infinite;
            z-index: -1;
        }
        .floating-particle:nth-child(4) {
            position: fixed;
            top: 70%;
            right: -10%;
            width: 18px;
            height: 18px;
            background: radial-gradient(circle, rgba(255,105,180,0.8) 0%, rgba(255,105,180,0.2) 70%);
            border-radius: 50%;
            animation: floatHorizontal2 22s linear infinite;
            z-index: -1;
        }
        .floating-particle:nth-child(5) {
            position: fixed;
            top: 20%;
            left: -10%;
            width: 12px;
            height: 12px;
            background: radial-gradient(circle, rgba(255,255,0,0.8) 0%, rgba(255,255,0,0.2) 70%);
            border-radius: 50%;
            animation: floatHorizontal1 12s linear infinite;
            z-index: -1;
        }
        @keyframes iceFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(90deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            75% { transform: translateY(-10px) rotate(270deg); }
        }
        @keyframes icePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes iceSparkle {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes floatHorizontal1 {
            0% { transform: translateX(-100vw); }
            100% { transform: translateX(100vw); }
        }
        @keyframes floatHorizontal2 {
            0% { transform: translateX(100vw); }
            100% { transform: translateX(-100vw); }
        }
        @keyframes floatDiagonal1 {
            0% { transform: translate(-100vw, -100vh); }
            100% { transform: translate(100vw, 100vh); }
        }
        @keyframes floatDiagonal2 {
            0% { transform: translate(100vw, -100vh); }
            100% { transform: translate(-100vw, 100vh); }
        }
        @keyframes zigzag {
            0%, 100% { transform: translateX(-100vw) translateY(0); }
            25% { transform: translateX(-50vw) translateY(-20vh); }
            50% { transform: translateX(0vw) translateY(0); }
            75% { transform: translateX(50vw) translateY(-20vh); }
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 5px rgba(255,215,0,0.5); }
            50% { box-shadow: 0 0 20px rgba(255,215,0,1), 0 0 30px rgba(255,215,0,0.8); }
        }
        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1); }
        }
        @keyframes bubbleFloat {
            0% { transform: translateY(100vh) scale(0.5); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1.2); opacity: 0; }
        }
        .floating-particle-extra {
            position: fixed;
            border-radius: 50%;
            z-index: -1;
            animation: pulseGlow 3s ease-in-out infinite;
        }
        .particle-6 {
            top: 15%;
            left: -5%;
            width: 30px;
            height: 30px;
            background: radial-gradient(circle, rgba(255,0,255,0.8) 0%, rgba(255,0,255,0.2) 70%);
            animation: floatDiagonal1 25s linear infinite, pulseGlow 4s ease-in-out infinite;
        }
        .particle-7 {
            top: 35%;
            right: -5%;
            width: 22px;
            height: 22px;
            background: radial-gradient(circle, rgba(0,255,255,0.8) 0%, rgba(0,255,255,0.2) 70%);
            animation: floatDiagonal2 30s linear infinite, pulseGlow 3.5s ease-in-out infinite;
        }
        .particle-8 {
            top: 55%;
            left: -5%;
            width: 18px;
            height: 18px;
            background: radial-gradient(circle, rgba(255,69,0,0.8) 0%, rgba(255,69,0,0.2) 70%);
            animation: zigzag 20s linear infinite, pulseGlow 5s ease-in-out infinite;
        }
        .particle-9 {
            top: 75%;
            right: -5%;
            width: 26px;
            height: 26px;
            background: radial-gradient(circle, rgba(0,255,0,0.8) 0%, rgba(0,255,0,0.2) 70%);
            animation: floatDiagonal1 28s linear infinite, pulseGlow 4.5s ease-in-out infinite;
        }
        .particle-10 {
            top: 25%;
            left: -5%;
            width: 14px;
            height: 14px;
            background: radial-gradient(circle, rgba(255,255,0,0.8) 0%, rgba(255,255,0,0.2) 70%);
            animation: floatDiagonal2 22s linear infinite, pulseGlow 3s ease-in-out infinite;
        }
        .particle-11 {
            top: 45%;
            right: -5%;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, rgba(255,0,0,0.8) 0%, rgba(255,0,0,0.2) 70%);
            animation: zigzag 26s linear infinite, pulseGlow 4s ease-in-out infinite;
        }
        .particle-12 {
            top: 65%;
            left: -5%;
            width: 16px;
            height: 16px;
            background: radial-gradient(circle, rgba(0,0,255,0.8) 0%, rgba(0,0,255,0.2) 70%);
            animation: floatDiagonal1 24s linear infinite, pulseGlow 3.5s ease-in-out infinite;
        }
        .particle-13 {
            top: 85%;
            right: -5%;
            width: 24px;
            height: 24px;
            background: radial-gradient(circle, rgba(255,165,0,0.8) 0%, rgba(255,165,0,0.2) 70%);
            animation: floatDiagonal2 32s linear infinite, pulseGlow 5s ease-in-out infinite;
        }
        .particle-14 {
            top: 5%;
            left: -5%;
            width: 12px;
            height: 12px;
            background: radial-gradient(circle, rgba(128,0,128,0.8) 0%, rgba(128,0,128,0.2) 70%);
            animation: zigzag 18s linear infinite, pulseGlow 2.5s ease-in-out infinite;
        }
        .particle-15 {
            top: 95%;
            right: -5%;
            width: 28px;
            height: 28px;
            background: radial-gradient(circle, rgba(0,128,128,0.8) 0%, rgba(0,128,128,0.2) 70%);
            animation: floatDiagonal1 35s linear infinite, pulseGlow 6s ease-in-out infinite;
        }
        .star {
            position: fixed;
            color: gold;
            font-size: 24px;
            z-index: -1;
            animation: sparkle 4s ease-in-out infinite;
        }
        .star-1 { top: 20%; left: 10%; animation-delay: 0s; }
        .star-2 { top: 40%; right: 15%; animation-delay: 1s; }
        .star-3 { top: 60%; left: 20%; animation-delay: 2s; }
        .star-4 { top: 80%; right: 10%; animation-delay: 3s; }
        .star-5 { top: 10%; left: 80%; animation-delay: 0.5s; }
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(173,216,230,0.6) 0%, rgba(173,216,230,0.2) 70%);
            z-index: -1;
            animation: bubbleFloat 15s linear infinite;
        }
        .bubble-1 { left: 5%; width: 40px; height: 40px; animation-delay: 0s; }
        .bubble-2 { left: 25%; width: 30px; height: 30px; animation-delay: 3s; }
        .bubble-3 { left: 50%; width: 50px; height: 50px; animation-delay: 6s; }
        .bubble-4 { left: 75%; width: 35px; height: 35px; animation-delay: 9s; }
        .bubble-5 { left: 90%; width: 25px; height: 25px; animation-delay: 12s; }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        .navbar {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: rgba(255, 255, 255, 0.95);
        }
        .btn-primary {
            background: linear-gradient(45deg, #42a5f5, #1e88e5);
            border: none;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #1976d2, #1565c0);
            transform: translateY(-2px);
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(66, 165, 245, 0.8), rgba(30, 136, 229, 0.8));
            color: white;
            padding: 60px 0;
            text-align: center;
            border-radius: 0 0 50px 50px;
        }
        .stats-card {
            background: linear-gradient(135deg, #42a5f5 0%, #1e88e5 100%);
            color: white;
        }
        .stats-card-transparent {
            background: rgba(173, 216, 230, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(173, 216, 230, 0.4);
            color: #333;
            box-shadow: 0 8px 32px rgba(173, 216, 230, 0.37);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stats-card-transparent:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(173, 216, 230, 0.5);
        }
        .stats-container {
            background: rgba(240, 248, 255, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(240, 248, 255, 0.6);
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(240, 248, 255, 0.4);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-shopping-cart text-primary me-2"></i>
                Courses Familiales
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=achats&action=index">
                            <i class="fas fa-list me-1"></i>Achats
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=statistiques&action=index">
                            <i class="fas fa-chart-bar me-1"></i>Statistiques
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4">
                <i class="fas fa-heart me-3"></i>
                Bienvenue dans votre Carnet de Courses Familial
            </h1>
            <p class="lead">Gérez vos achats avec amour et simplicité</p>
        </div>
    </div>

    <!-- Particules flottantes supplémentaires -->
    <div class="floating-particle-extra particle-6"></div>
    <div class="floating-particle-extra particle-7"></div>
    <div class="floating-particle-extra particle-8"></div>
    <div class="floating-particle-extra particle-9"></div>
    <div class="floating-particle-extra particle-10"></div>
    <div class="floating-particle-extra particle-11"></div>
    <div class="floating-particle-extra particle-12"></div>
    <div class="floating-particle-extra particle-13"></div>
    <div class="floating-particle-extra particle-14"></div>
    <div class="floating-particle-extra particle-15"></div>
    <div class="star star-1">★</div>
    <div class="star star-2">✦</div>
    <div class="star star-3">✧</div>
    <div class="star star-4">✩</div>
    <div class="star star-5">✫</div>
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>

    <div class="container my-5">
        <?php echo $content; ?>
    </div>

    <footer class="bg-primary text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2026 Kilys Startup - Gestion Courses Familiales. Tous droits réservés.</p>
            <div>
                <a href="#" class="text-white me-3">Conditions d'utilisation</a>
                <a href="#" class="text-white me-3">Politique de confidentialité</a>
                <a href="#" class="text-white">Contact</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
