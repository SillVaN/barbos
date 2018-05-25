$(document).ready(function() {

    $('.delete').click(function() {

        var rel = $(this).attr("href");
       confirm({
            title: 'Подтверждение удаления',
            contents: 'После удаления восстановление будет невозможно! Продолжить?',
            buttons: {
                confirm: function () {
                        location.href = rel;
                },
                cancel: function () {
                    class: 'gray',
                    alert("dsf");
                }
            },
        });
    });

    $('#select-links').click(function(){
   $("#list-links").slideToggle(200);
    });
    
});