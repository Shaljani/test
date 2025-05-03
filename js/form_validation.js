document.addEventListener("DOMContentLoaded", function () {
    console.log("JS validation chargé !");

    const formInscription = document.getElementById("form-inscription");
    const formConnexion = document.querySelector("form[action='connexion.php']");

    // Fonction pour vérifier un email basique
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // -------- FORMULAIRE D’INSCRIPTION --------
    if (formInscription) {
        const pseudoInput = document.getElementById("pseudo");
        const charCount = document.getElementById("charCount");
        const toggleBtn = document.getElementById("togglePassword");
        const passwordField = document.getElementById("password");

        // Limite de caractères pour le pseudo
        pseudoInput.addEventListener("input", () => {
            charCount.textContent = `${pseudoInput.value.length}/20`;
            if (pseudoInput.value.length > 20) {
                charCount.style.color = "red";
            } else {
                charCount.style.color = "black";
            }
        });

        // Afficher / masquer mot de passe
        toggleBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
        });

        // Validation avant envoi
        formInscription.addEventListener("submit", function (e) {
            const nom = formInscription.nom.value.trim();
            const email = formInscription.email.value.trim();
            const password = formInscription.password.value.trim();

            let message = "";
            if (nom === "" || email === "" || password === "") {
                message = "Veuillez remplir tous les champs obligatoires.";
            } else if (!isValidEmail(email)) {
                message = "Adresse email invalide.";
            }

            if (message !== "") {
                e.preventDefault();
                document.getElementById("form-error").textContent = message;
            }
        });
    }

    // -------- FORMULAIRE DE CONNEXION --------
    if (formConnexion) {
        formConnexion.addEventListener("submit", function (e) {
            const email = formConnexion.email.value.trim();
            const password = formConnexion.password.value.trim();

            let message = "";
            if (email === "" || password === "") {
                message = "Veuillez remplir tous les champs.";
            } else if (!isValidEmail(email)) {
                message = "Adresse email invalide.";
            }

            if (message !== "") {
                e.preventDefault();
                const existingError = document.querySelector(".error-msg");
                if (existingError) {
                    existingError.textContent = message;
                } else {
                    const msg = document.createElement("p");
                    msg.className = "error-msg";
                    msg.textContent = message;
                    formConnexion.insertBefore(msg, formConnexion.firstChild);
                }
            }
        });
    }
});
