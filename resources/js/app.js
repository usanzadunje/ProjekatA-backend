require('./bootstrap');

const button = document.getElementById('button');
const hiddenText = document.getElementById('hidden');

button.addEventListener('click', (event) => {
    let elStyle = event.target.style;
    if(elStyle.marginTop === '40px') {
        elStyle.marginTop = '20px';
        hiddenText.style.display = 'none';
    }else {
        elStyle.marginTop = '40px';
        hiddenText.style.display = 'block';
    }
});