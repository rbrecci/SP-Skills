const form = document.querySelector('.menuForm');
const nickname = document.querySelector('.nick');

const handleSubmit = (event) => {
    event.preventDefault();
    localStorage.setItem('player', nickname.value);

    window.location = '../partida/index.html'
}

form.addEventListener('submit', handleSubmit);