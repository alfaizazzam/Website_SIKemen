document.addEventListener('DOMContentLoaded', function () {
    const doctors = document.querySelectorAll('.ourdoctor');
    const modal = document.getElementById('myModal');
    const modalImg = document.getElementById('modal-img');
    const modalName = document.getElementById('modal-name');
    const modalSpecialty = document.getElementById('modal-specialty');
    const modalDescription = document.getElementById('modal-description');
    const closeBtn = document.getElementsByClassName('close')[0];

    doctors.forEach(doctor => {
        doctor.addEventListener('click', function () {
            const imgSrc = doctor.querySelector('img').src;
            const name = doctor.querySelector('h4').textContent;
            const specialty = doctor.querySelector('p').textContent;
            const description = doctor.querySelector('.popup-card').textContent;

            modalImg.src = imgSrc;
            modalName.textContent = name;
            modalSpecialty.textContent = specialty;
            modalDescription.textContent = description;

            modal.style.display = 'flex';
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});