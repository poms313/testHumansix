document.addEventListener('DOMContentLoaded', function() {

    /* open close the admin sidebar */
    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    openBtn.addEventListener('click', openSidebar);

    function openSidebar() {
        sidebar.classList.add('active');
        sidebarOverlay.classList.remove('d-none');
        closeBtn.classList.remove('d-none');
    }

    sidebarOverlay.addEventListener('click', closeSidebar);
    closeBtn.addEventListener('click', closeSidebar);

    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.add('d-none');
        closeBtn.classList.add('d-none');
    }

    /* display anim on create new order */
    const buttonSend = document.querySelector(".button-bird");
    if (buttonSend) {
        const buttonSendText = document.querySelector(".button-bird-text");
        buttonSend.addEventListener("click", change);

        function change() {
            if (buttonSend.classList.contains("actif")) {
                buttonSendText.innerHTML = "Confirmer";
            } else buttonSendText.innerHTML = "En cours d'envoi";
            buttonSend.classList.toggle("actif");
        }
    }
});