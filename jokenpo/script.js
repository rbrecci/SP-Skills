const pedra = document.getElementById('pedra')
const papel = document.getElementById('papel')
const tesoura = document.getElementById('tesoura')

function selectPedra(){ document.getElementById('yourMove').innerHTML = "<button id='pedra'> Pedra </button>" }
function selectPapel(){ document.getElementById('yourMove').innerHTML = "<button id='papel'> Papel </button>" }
function selectTesoura(){ document.getElementById('yourMove').innerHTML = "<button id='tesoura'> Tesoura </button>" }

pedra.addEventListener('click', selectPedra)
papel.addEventListener('click', selectPapel)
tesoura.addEventListener('click', selectTesoura)

const moves = document.querySelectorAll('.enemyChoice')
const randomIndex = Math.floor(Math.random() * moves.length)
const move = moves[randomIndex]
const move2 = move.id

function enemyPlay(){document.getElementById('enemyMove').innerHTML = ('<button id="' + move2 + '">' + move2 + '</button>')}
const play = document.getElementsByClassName('botao')

play.addEventListener('onfocus', enemyPlay)
