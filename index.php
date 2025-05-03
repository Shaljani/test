
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xplore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link id="theme-style" rel="stylesheet" href="css/styleindex.css">
    <script src="js/theme.js" defer></script>

</head>



<body>
    
    <section class="header">
          
            <a href="index.php" class="logo">XPlore</a>
            <label class="switch">
              <input type="checkbox" id="themeToggle">
              <span class="slider round"></span>
            </label>

            </div>

    
            <nav class="navbar">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'administrator') : ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
                <a href="index.php">Accueil</a>
                <a href="destination.php">Destination</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profil.php">Mon Profil</a>
                    <a href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="connexion.php">Se connecter</a>
                <?php endif; ?>
            </nav>

        <div class="menu-reduit" id="menu-reduit"><i class="fas fa-bars"></i></div>

    </section>

    

    <div class="menu-redu">
        <a href="admin.php">Admin</a>
        <a href="index.php">Accueil</a>
        <a href="destination.php">Destination</a>
        <a href="profil.php">Mon Profil</a>
        <a href="inscription.php">Se connecter</a>
    </nav>
    </div>

<section class="recherche">
    <div class="presentation">
    <h1>Vivez une aventure</h1>
    <p>Découvrez de merveilleuses places...</p>
  </div>
</section>


 <!-- Destinations de Trek Populaires -->

<section class="destinations">
    <h1>Treks Incontournables</h1>
    <div class="destination-container">
        <div class="destination" style="background-image: url('image/himalaya.jpg');">
            <h3>Himalaya, Népal</h3>
        </div>
        <div class="destination" style="background-image: url('image/patagonie.jpg');">
            <h3>Patagonie, Chili</h3>
        </div>
        <div class="destination" style="background-image: url('image/alpes.jpeg');">
            <h3>Les Alpes, France</h3>
        </div>
        <div class="destination" style="background-image: url('image/amazonie.jpg');">
            <h3>Andes, Pérou</h3>
        </div>
        <div class="destination" style="background-image: url('image/img55.jpeg');">
            <h3>Montagnes Rocheuses, Canada</h3>
        </div>
    </div>
</section>

</section>

<!-- À Propos de Nous -->
<section class="about">
  <div class="about-container">
    <h2><i class="fas fa-mountain"></i> À Propos de Nous</h2>
    <p>
      Chez <strong>XPlore</strong>, nous sommes bien plus qu’une simple agence de voyages : nous sommes des passionnés
      d’aventure, d’exploration et de découvertes authentiques. Notre mission est de vous emmener hors des sentiers battus,
      au cœur de paysages époustouflants, pour vivre des expériences uniques et inoubliables.
    </p>
    <p>
      Que vous soyez amateur de trekking en haute montagne, de randonnées en forêt tropicale ou d’explorations désertiques,
      nos voyages sont conçus sur mesure, alliant immersion locale, respect de la nature, dépassement de soi et rencontres
      inoubliables avec les populations locales.
    </p>
    <p>
      Notre équipe est composée de guides expérimentés, de voyageurs engagés et de partenaires locaux de confiance.
      Rejoindre XPlore, c’est choisir une aventure humaine, éthique et enrichissante.
    </p>
  </div>
</section>
</section>


<!-- Témoignages -->
<section class="testimonials">
  <h2><i class="fas fa-comment-dots"></i> Avis de Trekkeurs</h2>
  <div class="testimonial-container">
    <div class="testimonial">
      <p>"Une aventure incroyable dans l’Himalaya ! Organisation et guides au top."</p>
      <h4><i class="fas fa-user-circle"></i> Lucas P.</h4>
    </div>
    <div class="testimonial">
      <p>"Les paysages en Patagonie étaient à couper le souffle ! Merci pour cette expérience unique."</p>
      <h4><i class="fas fa-user-circle"></i> Camille D.</h4>
    </div>
    <div class="testimonial">
      <p>"Le trek dans les Andes a été une expérience transformative. Je recommande vivement !"</p>
      <h4><i class="fas fa-user-circle"></i> Antoine R.</h4>
    </div>
    <div class="testimonial">
      <p>"Les Montagnes Rocheuses offrent des vues spectaculaires. Un voyage inoubliable."</p>
      <h4><i class="fas fa-user-circle"></i> Sophie M.</h4>
    </div>
  </div>
</section>



<<!-- Conseils Trek & Aventure -->
<section class="blog">
  <h2><i class="fas fa-hiking"></i> Conseils Trek & Aventure</h2>
  <div class="blog-container">
    <article>
      <h3><i class="fas fa-suitcase-rolling"></i> Comment bien préparer son sac de trek ?</h3>
      <p>Tout ce qu’il faut savoir pour randonner léger, équilibré et sans rien oublier. Checklists et astuces incluses !</p>
    </article>
    <article>
      <h3><i class="fas fa-map-marked-alt"></i> Les plus beaux treks du monde</h3>
      <p>Découvrez notre sélection des itinéraires de trekking incontournables, du Népal à la Patagonie.</p>
    </article>
    <article>
      <h3><i class="fas fa-burn"></i> Gérer son énergie en trek</h3>
      <p>Conseils pour bien manger, bien dormir et rester motivé sur plusieurs jours d’effort.</p>
    </article>
    <article>
      <h3><i class="fas fa-mountain"></i> Trek en altitude : les précautions</h3>
      <p>Évitez le mal aigu des montagnes grâce à nos recommandations pour une acclimatation progressive.</p>
    </article>
    <article>
      <h3><i class="fas fa-shoe-prints"></i> Bien choisir ses chaussures de randonnée</h3>
      <p>Montantes ou basses ? Légères ou robustes ? On vous aide à faire le bon choix selon votre trek.</p>
    </article>
    <article>
      <h3><i class="fas fa-camera-retro"></i> Photographier ses aventures</h3>
      <p>Immortalisez vos moments forts en trek : lumière, cadrage, matériel léger et conseils de pro.</p>
    </article>
    <article>
      <h3><i class="fas fa-leaf"></i> Trek et écoresponsabilité</h3>
      <p>Adoptez les bons gestes pour minimiser votre impact et préserver les sentiers et écosystèmes.</p>
    </article>
    <article>
      <h3><i class="fas fa-compass"></i> Randonner en toute sécurité</h3>
      <p>Apprenez à lire une carte, utiliser une boussole, et faire face aux imprévus météo ou physiques.</p>
    </article>
  </div>
</section>



<!-- Newsletter -->
<section class="newsletter">
  <div class="newsletter-content">
    <h2><i class="fas fa-paper-plane"></i> Recevez nos Bons Plans Trek</h2>
    <p>Inscrivez-vous à notre newsletter et recevez chaque mois nos meilleures destinations, conseils d'aventure et offres exclusives.</p>
    <form class="newsletter-form">
      <input type="email" placeholder="Entrez votre adresse email" required>
      <button type="submit"><i class="fas fa-sign-in-alt"></i> S'inscrire</button>
    </form>
  </div>
</section>

<!-- Contact -->
<section class="contact">
  <div class="contact-container">
    <h2><i class="fas fa-map-signs"></i> Contactez-nous</h2>
    <p>Une question, une suggestion ou juste envie de discuter trek ? On est là pour vous !</p>
    <form class="contact-form">
      <input type="text" placeholder="Nom" required>
      <input type="email" placeholder="Email" required>
      <textarea rows="5" placeholder="Votre message" required></textarea>
      <button type="submit"><i class="fas fa-paper-plane"></i> Envoyer</button>
    </form>
  </div>
</section>


    <script>
        const MenuButton = document.querySelector('.menu-reduit')
        const MenuButtonICON = document.querySelector('.menu-reduit i')
        const Menu = document.querySelector('.menu-redu')

        MenuButton.onclick = function(){
            Menu.classList.toggle('open')
            const isOpen = Menu.classList.contains('open')
            MenuButtonICON.classList= isOpen ? 'fas fa-xmark':'fas fa-bars'
        }

    </script>

<script>
  const backgrounds = [
    "image/laponie.jpg",
    "image/mnemba.jpg",
    "image/volcan-islande.jpg"

  ];

  let current = 0;
  const section = document.querySelector(".recherche");

  function changeBackground() {
    current = (current + 1) % backgrounds.length;
    section.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(${backgrounds[current]})`;
  }

  setInterval(changeBackground, 5000);
</script>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h2>XPlore</h2>
            <p>Vivez une aventure</p>
        </div>
        <div class="footer-section">
            <h3>À propos</h3>
            <ul>
                <li><a href="#">Qui sommes-nous ?</a></li>
                <li><a href="#">Nos agences</a></li>
                <li><a href="#">Recrutement</a></li>
                <li><a href="#">Affiliation</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Conditions</h3>
            <ul>
                <li><a href="#">CGV</a></li>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Paiement sécurisé</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Tel: 01 34 25 10 10</p>
            <p>Email: contact@xplore.com</p>
            <p>Av. du Parc, 95000 Cergy</p>
        </div>
        <div class="footer-section">
            <h3>Suivez-nous</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 XPlore - Tous droits réservés</p>
    </div>
</footer>
     
    
</body>
</html>