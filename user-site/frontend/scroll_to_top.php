<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        #scrollToTopBtn {
            position: fixed;
            bottom: 15px;
            right: 15px;
            z-index: 999;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 100%;
            cursor: pointer;
            display: none;
            transition: opacity 0.3s ease;
        }

        #scrollToTopBtn:hover {
            background-color: var(--primary-hover); /* hover color */
        }
    </style>
</head>
<body>
    <button id="scrollToTopBtn" class="button" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

        window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
        });

        scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
        });
    </script>

</body>
</html>