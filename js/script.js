function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar.style.width === '250px') {
        sidebar.style.width = '0';
    } else {
        sidebar.style.width = '250px';
    }
}

let lastScrollTop = 0;
const navbar = document.querySelector("header");

window.addEventListener("scroll", function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop) {
        // Scroll ke bawah - sembunyikan navbar
        navbar.classList.remove('visible');
        navbar.classList.add('hidden');
    } else {
        // Scroll ke atas - tampilkan navbar
        navbar.classList.remove('hidden');
        navbar.classList.add('visible');
    }
    lastScrollTop = scrollTop;
});