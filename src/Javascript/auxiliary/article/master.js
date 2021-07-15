$(document).ready(function () {
    let progress = $('#article-loading-bar');

    function appendHeader() {
        if (progress) {
            if (window.pageYOffset > 0) {
                progress.show();
            } else {
                progress.hide();
            }
        }
    }

    function readingProgress() {
        if ($(window).scrollTop() % 250 < 50) {
            let scrollT = $(window).scrollTop();
            progress.attr('value', scrollT);
        }
    }

    window.onscroll = function () {
        appendHeader();
        toggleBTT();
        readingProgress();
    };



    let article = $('#article-actual'),
        articleHeight = article.height(),
        articleOffset = article.offset().top,
        windowHeight = $(window).height();

    progress.attr('max', articleHeight - windowHeight + articleOffset);
});

$(document).ready(function () {
    $("img").click((e) => {
        e.currentTarget.classList.remove('double-clicked');
        e.currentTarget.classList.toggle('clicked');
    })
});

$(document).ready(function () {
    $("img").dblclick((e) => {
        e.currentTarget.classList.remove('clicked');
        e.currentTarget.classList.toggle('double-clicked');
    })
});

$(document).ready(function () {
        document.querySelectorAll('code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    }
);