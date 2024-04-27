//script to enable modal window pop-up upon clicking the "more info" button of a listed property
const moreInfoBtns = document.querySelectorAll('.more-info');
const closeBtns = document.querySelectorAll('.property-info-close');

moreInfoBtns.forEach((button) => {
    button.addEventListener('click', () => {
        //get the <dialog> element in relation to the More Info button
        let modal = button.nextElementSibling;
        console.log(modal);
        //show the dialog
        modal.showModal();
    });
});

closeBtns.forEach((button) => {
    button.addEventListener('click', () => {
        //the <dialog> element is the parent of the close button
        let modal = button.parentElement;
        console.log(modal);

        modal.close();
    });
});