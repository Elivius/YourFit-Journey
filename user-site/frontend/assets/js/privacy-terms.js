let justOpenedTerms = false;
let justOpenedPrivacy = false;

function openTermsModal() {
    const modal = document.getElementById("termsModal");
    const backdrop = document.getElementById("modalBackdrop");

    modal.classList.add("show");
    backdrop.classList.add("show");

    justOpenedTerms = true;
    setTimeout(() => {
        justOpenedTerms = false;
    }, 100);
}

function closeTermsModal() {
    const modal = document.getElementById("termsModal");
    const backdrop = document.getElementById("modalBackdrop");

    modal.classList.remove("show");
    backdrop.classList.remove("show");
}

function openPrivacyModal() {
    const modal = document.getElementById("privacyModal");
    const backdrop = document.getElementById("modalBackdrop");

    modal.classList.add("show");
    backdrop.classList.add("show");

    justOpenedPrivacy = true;
    setTimeout(() => {
        justOpenedPrivacy = false;
    }, 100);
}

function closePrivacyModal() {
    const modal = document.getElementById("privacyModal");
    const backdrop = document.getElementById("modalBackdrop");

    modal.classList.remove("show");
    backdrop.classList.remove("show");
}

// Close Terms if clicked outside
document.addEventListener("click", function (e) {
    if (justOpenedTerms) return;

    const modal = document.getElementById("termsModal");
    const content = modal?.querySelector(".modal-content");

    if (modal?.classList.contains("show") && !content?.contains(e.target)) {
        closeTermsModal();
    }
});

// Close Privacy if clicked outside
document.addEventListener("click", function (e) {
    if (justOpenedPrivacy) return;

    const modal = document.getElementById("privacyModal");
    const content = modal?.querySelector(".modal-content");

    if (modal?.classList.contains("show") && !content?.contains(e.target)) {
        closePrivacyModal();
    }
});
