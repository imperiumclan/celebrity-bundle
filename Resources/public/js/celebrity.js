$('img').on('error',function(){
    $(this).attr('src','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZk3y06bcooRBu224-A4IaLv3hRrK6AkTPjQ&usqp=CAU');
    $(this).parent().children('.card-img-overlay').remove();
});