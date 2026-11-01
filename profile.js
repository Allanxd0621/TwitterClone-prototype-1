const profileIcon = document.getElementById('profileCheck');
const profileSection = document.getElementById('profileSection');


    profileIcon.addEventListener('click' , function(){

            profileSection.classList.add('profileSectionVisible');

    });

const exitProfileBtn = document.getElementById('exitProfileBtn');

    exitProfileBtn.addEventListener('click' , function(){

            profileSection.classList.remove('profileSectionVisible');

    });