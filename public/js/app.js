'use strict'

document.getElementById('user-menu-button').addEventListener('click', () => {
    const toggleButton = document.getElementById("user-menu");
    // Adiciona ou remove a classe 'hidden' para alternar a visibilidade
    toggleButton.classList.toggle("hidden");

})

document.getElementById('mobile-menu-drop').addEventListener('click', () => {
    console.log('menu')

    const toggleButton = document.getElementById("mobile-menu");
    // Adiciona ou remove a classe 'hidden' para alternar a visibilidade
    toggleButton.classList.toggle("hidden");
})