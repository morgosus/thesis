
//Notifications and cookie - animations / black & white modes
$(document).ready(function () {
    let meta = document.getElementById('notification-meta');
    let notice = document.getElementById('notice-paragraph');

    if (meta) {
        notice.innerHTML = meta.content.toString();
        notice.style.display = 'block';
    }

    let sheet;

    if (getCookie('animations') === 'disabled') {
        sheet = document.getElementById('animation-stylesheet');
        sheet.disabled = true;
        sheet.parentNode.removeChild(sheet);
        console.log('Animations disabled.');
    }

    sheet = document.getElementById('black-and-white-stylesheet');

    if (getCookie('black-and-white') === 'enabled') {
        sheet.disabled = false;
        console.log('Black and white mode enabled.');
    } else {
        sheet.disabled = true;
        sheet.parentNode.removeChild(sheet);
    }
});

//Back to top main script

let executedScroll = 0;
let bttInterval = null;

function toggleBTT(reset = false) {
    $(document).ready(() => {
        if (reset === true) {
            let backToTop = document.getElementById('back-to-top');

            backToTop.classList.remove('appear');

            backToTop.classList.add('disappear');

            bttInterval = setInterval(() => {
                backToTop.classList.add('hidden');
                backToTop.classList.remove('disappear');
                executedScroll = 0;
            }, 1000);
        }
        else if (executedScroll === 0) {
            let backToTop = document.getElementById('back-to-top');

            if (document.body.scrollTop < document.documentElement.scrollTop) {
                clearInterval(bttInterval);
                backToTop.classList.remove('hidden');
                backToTop.classList.remove('disappear');
                backToTop.classList.add('appear');
                executedScroll = 1;
            } else {

                backToTop.classList.remove('appear');

                backToTop.classList.add('disappear');

                bttInterval = setInterval(() => {
                    backToTop.classList.add('hidden');
                    backToTop.classList.remove('disappear');
                    executedScroll = 0;
                }, 1000);

            }
        }
    })
}