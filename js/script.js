//sorter
const sorter = document.querySelector('.sort-list');
if( sorter ){
    const sortLi = sorter.querySelectorAll('li');
    sorter.querySelector('.opt-trigger').addEventListener('click', function (){
        sorter.querySelector('ul').classList.toggle('show');
    });

    sortLi.forEach((item) => item.addEventListener('click', function (){
        sortLi.forEach((li) => li != this ? li.classList.remove('active') : null);

        this.classList.add('active');
        sorter.querySelector('.opt-trigger span.value').textContent =this.textContent;
        sorter.querySelector('ul').classList.toggle('show');
    }))
}
//menu
// const triggerOpen = document.querySelectorAll('[trigger-button]');
// const triggerClose = document.querySelectorAll('[close-button]');
// const overlay = document.querySelector('[data-overlay]');
//
// for (let i = 0; i < triggerOpen.length; i++){
//     let currentId = triggerOpen[i].dataset.target,
//         targetEl = document.querySelector(`#${currentId}`)
//
//     const openData = function (){
//       targetEl.classList.remove('active');
//       overlay.classList.remove('active');
//     };
//     triggerOpen[i].addEventListener('click', function (){
//         targetEl.classList.add('active');
//         overlay.classList.add('active');
//     });
//
//     targetEl.querySelector('[close-button]').addEventListener('click');
//     overlay.addEventListener('click', openData);
// }
//tabbed
const trigger = document.querySelectorAll('.tabbed-trigger');
const content = document.querySelectorAll('.tabbed > div');

trigger.forEach((btn) => {
    btn.addEventListener('click', function () {
        let dataTarget = this.dataset.id;
        let body = document.querySelector(`#${dataTarget}`);

        // Reset all triggers and content elements
        trigger.forEach((b) => b.parentNode.classList.remove('active'));
        content.forEach((c) => c.classList.remove('active'));

        // Set the clicked trigger and content element as active
        this.parentNode.classList.add('active');
        body.classList.add('active');
    });
});










