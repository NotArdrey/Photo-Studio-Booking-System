document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const contentSections = document.querySelectorAll(".content-section");

    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            const target = link.getAttribute("data-target");

            //default hide
            contentSections.forEach(section => {
                section.classList.remove("active");
            });

            // make show of the selected section in navbar
            document.getElementById(target).classList.add("active");
        });
    });
});



