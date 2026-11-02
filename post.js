const postBtn = document.getElementById('postBtn');
const postForm = document.querySelector('.postForm');


postBtn.addEventListener('click' , function(){

    postForm.classList.toggle('postFormVisible');


});

const postBtn1 = document.getElementById('postBtn1');

//then if enter post button in form it would close 

postBtn1.addEventListener('click' , function(){

    postBtn1.classList.remove('postFormVisible');

});

const postExitBtn = document.getElementById('postExitBtn');

    postExitBtn.addEventListener('click' , function(){

        postForm.classList.remove('postFormVisible');

    });
