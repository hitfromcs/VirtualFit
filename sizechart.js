document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggle-chart-btn");
    const chart = document.getElementById("size-chart-content");

    if (toggleBtn && chart) {
        toggleBtn.addEventListener("click", function () {
            console.log("Button clicked!");
            chart.classList.toggle("hidden");
        });
    }
});

