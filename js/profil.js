document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll(".profil-table tr");
    const btnSoumettre = document.getElementById('btn-soumettre');
    let modifications = {};

    rows.forEach(row => {
        const input = row.querySelector("input.editable-field");
        const btnEdit = row.querySelector("button.edit-btn");
        const btnSave = row.querySelector("button.save-btn");
        const btnCancel = row.querySelector("button.cancel-btn");

        if (!input || !btnEdit || !btnSave || !btnCancel) return;

        const originalValue = input.value;
        const field = row.dataset.field;

        btnEdit.addEventListener("click", () => {
            input.disabled = false;
            btnEdit.style.display = "none";
            btnSave.style.display = "inline-block";
            btnCancel.style.display = "inline-block";
        });

        btnCancel.addEventListener("click", () => {
            input.value = originalValue;
            input.disabled = true;
            btnEdit.style.display = "inline-block";
            btnSave.style.display = "none";
            btnCancel.style.display = "none";
        });

        btnSave.addEventListener("click", () => {
            const isEmail = input.name === "email";
            if (isEmail && !validateEmail(input.value)) {
                alert("❌ Email invalide.");
                return;
            }

            input.disabled = true;
            btnEdit.style.display = "inline-block";
            btnSave.style.display = "none";
            btnCancel.style.display = "none";

            const field = row.dataset.field;

            if (input.value !== originalValue) {
                modifications[field] = input.value;
                btnSoumettre.style.display = 'inline-block';
            }
        });
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    btnSoumettre.addEventListener('click', () => {
        fetch('update_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(modifications)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("✅ Modifications enregistrées !");
                btnSoumettre.style.display = 'none';
                modifications = {};
            } else {
                alert("❌ Échec : " + (data.error || "Erreur inconnue"));
            }
        })
        .catch(() => alert("❌ Erreur serveur"));
    });
});
