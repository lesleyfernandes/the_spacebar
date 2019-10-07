$(document).ready(function () {
    $('.js-like-article').on('click', function (e) {
        e.preventDefault();
        let $link = $(e.currentTarget);
        // let $heart_num = parseInt($('.js-like-article-count').text());
        // if ($link.hasClass('fa-heart-o')) {
        //     $('.js-like-article-count').html($heart_num + 1);
        // } else {
        //     $('.js-like-article-count').html($heart_num + -1);
        // }
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function(data){
            $('.js-like-article-count').html(data.hearts);
        });
    });
});